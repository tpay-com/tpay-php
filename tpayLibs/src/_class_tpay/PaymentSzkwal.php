<?php

/*
 * Created by tpay.com
 */

namespace tpayLibs\src\_class_tpay;

use tpayLibs\src\_class_tpay\Utilities\ObjectsHelper;
use tpayLibs\src\_class_tpay\Utilities\TException;
use tpayLibs\src\_class_tpay\Utilities\Util;
use tpayLibs\src\_class_tpay\Validators\PaymentTypes\PaymentTypeSzkwal;
use tpayLibs\src\Dictionaries\ErrorCodes\SzkwalErrors;

/**
 * Class PaymentSzkwal
 *
 * SZKWał  (Virtual  Accounts  Recharge  System)  was  designed  to  simplify  the  payment  process  for  the  client.
 * Instead  of  traditional  payment  gateway,  client  makes  a  payment  with  fixed
 * title  directly  from  his  online
 * banking  without  the  necessity  of  multiple  redirections  through  various  pages.  SZKWał  recognizes  such
 * payments and notifies the partner system.
 *
 * @package tpay
 */
class PaymentSzkwal extends ObjectsHelper
{
    const APILOGIN = 'api_login';
    const APIPASS = 'api_password';
    const DATE = 'Y-m-d';
    const TITLE = 'title';
    const INVALIDRESPONSE = 'Invalid server response';
    const AMOUNT = 'amount';

    /**
     * tpay payment url
     * @var string
     */
    protected $szkwalApiUrl = 'https://szkwal.tpay.com/';

    /**
     * PaymentSzkwal class constructor
     *
     */
    public function __construct()
    {
        $this->isNotEmptyString($this->szkwalApiLogin, 'API login');
        $this->isNotEmptyString($this->szkwalApiPass, 'API password');
        $this->isNotEmptyString($this->szkwalApiHash, 'API hash');
        $this->isNotEmptyString($this->szkwalPartnerUniqueAddress, 'Partner unique address');
        $this->isNotEmptyString($this->szkwalTitleFormat, 'Title format');
    }

    /**
     * Register a new client (method RegisterClient) - or update his data with UpdateClient . This method has to
     * be used before Client makes his first payment. Bellow we will register a new customer Jan Nowak and his
     * dedicated constant payment title, together with his bank account number. If Client will make a payment with
     * incorrect title, SZKWAL can automatically connect the payment from that bank account to this Client.
     *
     * @param string $clientName customer name; up to 96 alphanumeric characters;
     * @param string $clientEmail customer e-mail; up to 128 alphanumeric characters, must be a valid e-mail address;
     * @param int $clientPhone customer phone; up to 32 numeric characters;
     * @param string $crc optional field sent in notifications; up to 64 characters;
     * @param int $clientAccount client account number; 26 digits
     *
     * @throws TException
     *
     * @return array
     */
    public function registerClient($clientName, $clientEmail, $clientPhone, $crc, $clientAccount)
    {

        $title = $this->generateTitle();

        Util::log('SZKWal register client sha1 params', print_r(array(
            'cli_name'    => $clientName,
            'cli_mail'    => $clientEmail,
            'cli_phone'   => $clientPhone,
            static::TITLE => $title,
            'crc'         => $crc,
            'account'     => $clientAccount,
            'apiHash'     => $this->szkwalApiHash,
        ), true));
        $sha1 = sha1($clientName . $clientEmail . $clientPhone . $title . $crc . $clientAccount . $this->szkwalApiHash);

        $postData = array(
            static::APILOGIN => $this->szkwalApiLogin,
            static::APIPASS  => $this->szkwalApiPass,
            'cli_name'       => $clientName,
            'cli_email'      => $clientEmail,
            'cli_phone'      => $clientPhone,
            static::TITLE    => $title,
            'crc'            => $crc,
            'cli_account'    => $clientAccount,
            'hash'           => $sha1,
        );

        $this->validateConfig(new PaymentTypeSzkwal(), $postData);

        $res = $this->request('RegisterClient', $postData);

        $this->checkSzkwalError($res);
        preg_match_all('/([0-9]*)/', $res, $matchesCliId);

        if (isset($matchesCliId[1]) && isset($matchesCliId[1][0])) {
            $clientID = (int)$matchesCliId[1][0];
        } else {
            throw new TException(static::INVALIDRESPONSE);
        }

        return array(
            'client_id'   => $clientID,
            static::TITLE => $title,
        );
    }

    /**
     * Generate new unique title
     *
     * @return string
     */
    public static function generateTitle()
    {
        return 'KIP' . substr(time(), 1);
    }

    /**
     * Send API request
     *
     * @param string $method method name
     * @param array $params post data
     *
     * @return mixed
     */
    protected function request($method, $params)
    {
        $url = $this->szkwalApiUrl . $this->szkwalPartnerUniqueAddress . '/' . $method;

        return parent::requests($url, $params);
    }

    /**
     * Check for error presence in response
     *
     * @param string $response
     *
     * @throws TException
     */
    protected function checkSzkwalError($response)
    {
        preg_match_all('/(ERR[0-9]*)/', $response, $matchesError);
        if (isset($matchesError[1]) && isset($matchesError[1][0])) {
            $errorCode = $matchesError[1][0];
            throw new TException(SzkwalErrors::ERROR_CODES[$errorCode]);
        }
    }

    /**
     * Create HTML confirmation block with transaction info and merchant data
     *
     * @param string $title transaction title
     * @param bool|float $amount transaction amount
     * @param string $merchantData merchant data to display
     *
     * @return string
     *
     * @throws TException
     */
    public function getConfirmationBlock($title, $amount = false, $merchantData = '')
    {
        $data = array(
            static::TITLE      => $title,
            'banks'            => $this->getBanks(),
            static::AMOUNT     => $amount,
            'merchant_data'    => $merchantData
        );

        return Util::parseTemplate('confirmation', $data);
    }

    /**
     * Method used to receive information about all available bank channels.
     *
     * @throws TException
     *
     * @return mixed
     */
    public function getBanks()
    {
        $postData = array(
            static::APILOGIN => $this->szkwalApiLogin,
            static::APIPASS  => $this->szkwalApiPass,
        );
        $res = $this->request('GetBanksData', $postData);
        $this->checkSzkwalError($res);

        preg_match_all('/(.*)/', $res, $matches);
        if (isset($matches[1]) && isset($matches[1][0])) {
            $data = json_decode($matches[1][0], true);
            foreach ($data as &$d) {
                $d['availability'] = json_decode($d['availability'], true);
            }
        } else {
            throw new TException(static::INVALIDRESPONSE);
        }

        return $data;
    }

    /**
     * Method used to change result URL where payment notifications will be send.
     *
     * @param string|bool $notifyURL notify url
     *
     * @throws TException
     *
     * @return bool
     */
    public function changeSellerData($notifyURL)
    {
        $sha1 = sha1($notifyURL . $this->szkwalApiHash);
        $postData = array(
            static::APILOGIN => $this->szkwalApiLogin,
            static::APIPASS  => $this->szkwalApiPass,
            'notify_url'     => $notifyURL,
            'hash'           => $sha1,
        );
        $res = $this->request('ChangeSellerData', $postData);
        $this->checkSzkwalError($res);

        if (strpos($res, 'correct') !== -1) {
            return true;
        } else {
            throw new TException(static::INVALIDRESPONSE);
        }
    }

    /**
     * Method used to block/unblock payments for specific client.
     *
     * @param string $title client title according to agreed format
     * @param int $status Type 1 to enable client, 0 to disable
     *
     * @return bool
     */
    public function clientStatus($title, $status)
    {
        $sha1 = sha1($title . $status . $this->szkwalApiHash);

        $postData = array(
            static::APILOGIN => $this->szkwalApiLogin,
            static::APIPASS  => $this->szkwalApiPass,
            static::TITLE    => $title,
            'status'         => $status,
            'hash'           => $sha1,
        );

        return $this->request('ClientStatus', $postData);
    }

    /**
     * Simulate user payment in test mode
     * @param string $title client/transaction title
     * @param float $amount amount
     *
     * @return mixed
     */
    public function registerIncome($title, $amount)
    {
        $postData = array(
            static::APILOGIN => $this->szkwalApiLogin,
            static::APIPASS  => $this->szkwalApiPass,
            static::TITLE    => $title,
            static::AMOUNT   => $amount,
        );

        $postData['hash'] = sha1($title . $amount . $this->szkwalApiHash);

        return $this->request('RegisterIncome', $postData);
    }

    /**
     * Check md5 sum to confirm tpay response and value of payment amount
     *
     * @param string $sign sha1 checksum
     * @param string $payId unique szkwal payment id
     * @param string $notId unique szkwal notification id
     * @param string $title payment title in agreed format
     * @param string $crc additional client field
     * @param float $amount amount of payment
     *
     * @throws TException
     */
    public function validateSzkwalSign($sign, $payId, $notId, $title, $crc, $amount)
    {
        Util::log('Szkwal sign check components', print_r(array(
            'sign'         => $sign,
            'payId'        => $payId,
            'noti_id'      => $notId,
            static::TITLE  => $title,
            'crc'          => $crc,
            static::AMOUNT => $amount,
            'hash'         => $this->szkwalApiHash,
        ), true));

        $amount = number_format($amount, 2, '.', '');

        if ($sign !== sha1($payId . $notId . $title . $crc . $amount . $this->szkwalApiHash)) {
            throw new TException('invalid checksum');
        }
    }
}
