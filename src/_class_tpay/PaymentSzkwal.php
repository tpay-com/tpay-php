<?php

/*
 * Created by tpay.com
 */

namespace tpay;

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
class PaymentSzkwal
{
    const APILOGIN = 'api_login';
    const APIPASS = 'api_password';
    const DATE = 'Y-m-d';
    const TITLE = 'title';
    const INVALIDRESPONSE = 'Invalid server response';
    const AMOUNT = 'amount';
    /**
     * API login
     * @var string
     */
    protected $apiLogin = '[SZKWAL_LOGIN]';
    /**
     * API password
     * @var string
     */
    protected $apiPass = '[SZKWAL_API_PASSWORD]';
    /**
     * API hash
     * @var string
     */
    protected $apiHash = '[SZKWAL_API_HASH]';
    /**
     * API partner unique address
     * @var string
     */
    protected $partnerUniqueAddress = '[SZKWAL_PARTNER_ADDRESS]';
    /**
     * API title format
     * @var string
     */
    protected $titleFormat = '[SZKWAL_TITLE_FORMAT]';
    /**
     * tpay payment url
     * @var string
     */
    protected $apiUrl = 'https://szkwal.tpay.com/';
    /**
     * The list of possible errors returning from tpay servive
     * @var array
     */
    protected $errorCodes = array(
        'ERR01' => 'authorization failed',
        'ERR02' => 'required input empty',
        'ERR03' => 'incorrect title format',
        'ERR04' => 'title busy',
        'ERR05' => 'incorrect hash',
        'ERR06' => 'no such client',
        'ERR07' => 'malformed CSV',
        'ERR08' => 'no such package',
        'ERR09' => 'incorrect host',
        'ERR10' => 'incorrect email',
        'ERR11' => 'incorrect dates',
        'ERR12' => 'incorrect amount',
        'ERR13' => 'no such method',
        'ERR14' => 'Insufficient funds',
        'ERR15' => 'Incorrect client account number',
        'ERR99' => 'other error',
    );

    /**
     * PaymentSzkwal class constructor
     *
     * @param string|bool $apiLogin API login
     * @param string|bool $apiPass API password
     * @param string|bool $apiHash API hash
     * @param string|bool $partnerUniqueAddress API partner unique address
     * @param string|bool $titleFormat API title format
     */
    public function __construct($apiLogin = false, $apiPass = false, $apiHash = false,
                                $partnerUniqueAddress = false, $titleFormat = false)
    {
        if ($apiLogin !== false) {
            $this->apiLogin = $apiLogin;
        }
        if ($apiPass !== false) {
            $this->apiPass = $apiPass;
        }
        if ($apiHash !== false) {
            $this->apiHash = $apiHash;
        }
        if ($partnerUniqueAddress !== false) {
            $this->partnerUniqueAddress = $partnerUniqueAddress;
        }
        if ($titleFormat !== false) {
            $this->titleFormat = $titleFormat;
        }

        require_once(dirname(__FILE__) . '/util.php');

        Util::loadClass('Curl');
        Util::loadClass('Exception');
        Util::loadClass('Validate');
        Util::loadClass('Lang');
        Util::checkVersionPHP();
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
            'cli_name'  => $clientName,
            'cli_mail'  => $clientEmail,
            'cli_phone' => $clientPhone,
            static::TITLE     => $title,
            'crc'       => $crc,
            'account'   => $clientAccount,
            'apiHash'   => $this->apiHash,
        ), true));
        $sha1 = sha1($clientName . $clientEmail . $clientPhone . $title . $crc . $clientAccount . $this->apiHash);

        $postData = array(
            static::APILOGIN    => $this->apiLogin,
            static::APIPASS => $this->apiPass,
            'cli_name'     => $clientName,
            'cli_email'    => $clientEmail,
            'cli_phone'    => $clientPhone,
            static::TITLE        => $title,
            'crc'          => $crc,
            'cli_account'  => $clientAccount,
            'hash'         => $sha1,
        );

        Validate::validateConfig(Validate::PAYMENT_TYPE_SZKWAL, $postData);

        $res = $this->request('RegisterClient', $postData);

        $this->checkError($res);
        preg_match_all('/([0-9]*)/', $res, $matchesCliId);

        if (isset($matchesCliId[1]) && isset($matchesCliId[1][0])) {
            $clientID = (int)$matchesCliId[1][0];
        } else {
            throw new TException(static::INVALIDRESPONSE);
        }

        return array(
            'client_id' => $clientID,
            static::TITLE     => $title,
        );
    }

    /**
     * Generate new unique title
     *
     * @return string
     * @todo
     */
    public static function generateTitle()
    {
        return 'KIP' . substr(time(), 1);
    }

    /**
     * Send API request
     *
     * @param string $method method name
     * @param array $postData post data
     *
     * @return mixed
     */
    protected function request($method, $postData)
    {
        $url = $this->apiUrl . $this->partnerUniqueAddress . '/' . $method;

        return Curl::doCurlRequest($url, $postData);
    }

    /**
     * Check for error presence in response
     *
     * @param string $response
     *
     * @throws TException
     */
    protected function checkError($response)
    {
        preg_match_all('/(ERR[0-9]*)/', $response, $matchesError);
        if (isset($matchesError[1]) && isset($matchesError[1][0])) {
            $errorCode = $matchesError[1][0];
            throw new TException($this->errorCodes[$errorCode]);
        }
    }

    /**
     * Create HTML confirmation block with transaction info and merchant data
     *
     * @param string $title transaction title
     * @param bool|float $amount transaction amount
     * @param string $staticFilesURL static file URL
     * @param string $merchantData merchant data to display
     *
     * @return string
     *
     * @throws TException
     */
    public function getConfirmationBlock($title, $amount = false, $staticFilesURL = '', $merchantData = '')
    {
        $data = array(
            static::TITLE            => $title,
            'banks'            => $this->getBanks(),
            static::AMOUNT           => $amount,
            'static_files_url' => $staticFilesURL,
            'merchant_data'    => $merchantData
        );

        return Util::parseTemplate('szkwal/_tpl/confirmation', $data);
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
            static::APILOGIN    => $this->apiLogin,
            static::APIPASS => $this->apiPass,
        );
        $res = $this->request('GetBanksData', $postData);
        $this->checkError($res);

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
        $sha1 = sha1($notifyURL . $this->apiHash);
        $postData = array(
            static::APILOGIN    => $this->apiLogin,
            static::APIPASS => $this->apiPass,
            'notify_url'   => $notifyURL,
            'hash'         => $sha1,
        );
        $res = $this->request('ChangeSellerData', $postData);
        $this->checkError($res);

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
        $sha1 = sha1($title . $status . $this->apiHash);

        $postData = array(
            static::APILOGIN    => $this->apiLogin,
            static::APIPASS => $this->apiPass,
            static::TITLE        => $title,
            'status'       => $status,
            'hash'         => $sha1,
        );

        return $this->request('ClientStatus', $postData);
    }

    /**
     * Method sed to acquire report of incoming payments. Depending on input parameters, the function can
     * return a list of payments for one client (providing cli_id or title) or list of all payments in the specified
     * period.
     *
     * @param int $clientId
     * @param string $title
     * @param int $startTime time in unix timestamp format
     * @param int|bool $endTime time in unix timestamp format, if false than now
     *
     * @return array
     */
    public function paymentsReport($clientId, $title, $startTime, $endTime = false)
    {
        $postData = array(
            static::APILOGIN    => $this->apiLogin,
            static::APIPASS => $this->apiPass,
        );
        $postData['from'] = date(static::DATE, $startTime);
        if ($clientId !== false) {
            $postData['cli_id'] = $clientId;
        }
        if ($title !== false) {
            $postData[static::TITLE] = $title;
        }
        $endTime = ($endTime !== false) ? $endTime : time();
        $postData['to'] = date(static::DATE, $endTime);

        $postData['hash'] = sha1(
            $postData['cli_id'] . $postData[static::TITLE] . $postData['from'] . $postData['to'] . $this->apiHash
        );

        return $this->request('PaymentsReport', $postData);
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
            static::APILOGIN    => $this->apiLogin,
            static::APIPASS => $this->apiPass,
            static::TITLE        => $title,
            static::AMOUNT       => $amount,
        );

        $postData['hash'] = sha1($title . $amount . $this->apiHash);

        return $this->request('RegisterIncome', $postData);
    }

    /**
     * Generate monthly report
     *
     * @param int $startTime time in unix timestamp format
     * @param int|bool $endTime time in unix timestamp format, if false than now
     *
     * @return array
     */
    public function monthlyReport($startTime, $endTime = false)
    {
        return $this->generateReport('MonthlyReport', $startTime, $endTime);
    }

    /**
     * Generate monthly report
     *
     * @param string $type generate daily or monthly report
     * @param int $startTime time in unix timestamp format
     * @param int|bool $endTime time in unix timestamp format, if false than now
     *
     * @return array
     */
    private function generateReport($type, $startTime, $endTime)
    {
        $postData = array(
            static::APILOGIN    => $this->apiLogin,
            static::APIPASS => $this->apiPass,
        );
        $postData['from'] = date(static::DATE, $startTime);
        if ($endTime !== false) {
            $postData['to'] = date(static::DATE, $endTime);
        } else {
            $postData['to'] = date(static::DATE);
        }

        $sha1 = sha1($postData['from'] . $postData['to'] . $this->apiHash);
        $postData['hash'] = $sha1;

        return $this->request($type, $postData);
    }

    /**
     * Generate daily report
     *
     * @param int $startTime time in unix timestamp format
     * @param int|bool $endTime time in unix timestamp format, if false than now
     *
     * @return array
     */
    public function dailyReport($startTime, $endTime = false)
    {
        return $this->generateReport('DailyReport', $startTime, $endTime);
    }

    /**
     * Handle response from tpay server
     * Check all required fields and sh1 check sum
     * Parse variables to valid types
     *
     * @throws TException
     *
     * @return array
     */
    public function handleNotification()
    {
        Util::log('szkwal notification', print_r(INPUT_POST, true));
        $res = Validate::getResponse(Validate::PAYMENT_TYPE_SZKWAL);

        echo '<?xml version="1.0" encoding="UTF-8"?>
            <data>
            <result>correct</result>
            </data>';

        return $res;
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
    public function validateSign($sign, $payId, $notId, $title, $crc, $amount)
    {
        Util::log('Szkwal sign check components', print_r(array(
            'sign'    => $sign,
            'payId'   => $payId,
            'noti_id' => $notId,
            static::TITLE   => $title,
            'crc'     => $crc,
            static::AMOUNT  => $amount,
            'hash'    => $this->apiHash,
        ), true));

        $amount = number_format($amount, 2, '.', '');

        if ($sign !== sha1($payId . $notId . $title . $crc . $amount . $this->apiHash)) {
            throw new TException('invalid checksum');
        }
    }
}
