<?php

/*
 * Created by tpay.com
 */

namespace tpay;

/**
 * Class PaymentWhiteLabel
 *
 * @package tpay
 */
class PaymentWhiteLabel extends PaymentSzkwal
{
    const APILOGIN = 'api_login';
    const APIPASS = 'api_password';

    /**
     * PaymentWhiteLabel class constructor
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
        parent::__construct($apiLogin, $apiPass, $apiHash, $partnerUniqueAddress, $titleFormat);
    }

    /**
     * Method used to add new order to the system
     *
     * @param string $clientName customer name; up to 96 alphanumeric characters
     * @param string $clientEmail customer e-mail; up to 128 alphanumeric characters, must be a valid e-mail address
     * @param string $clientPhone customer phone; up to 32 numeric characters
     * @param float $amount field containing order amount, dot separated, e.g. 123.45
     *
     * @throws TException
     *
     * @return string
     */
    public function registerOrder($clientName, $clientEmail, $clientPhone, $amount)
    {
        $title = $this->generateTitle();

        $hash = sha1($clientName . $clientEmail . $clientPhone . $title . $amount . $this->apiHash);

        $postData = array(
            static::APILOGIN => $this->apiLogin,
            static::APIPASS  => $this->apiPass,
            'cli_name'       => $clientName,
            'cli_email'      => $clientEmail,
            'cli_phone'      => $clientPhone,
            'order'          => $title,
            'amount'         => $amount,
            'hash'           => $hash,
        );

        Validate::validateConfig(Validate::PAYMENT_TYPE_WHITE_LABEL, $postData);

        Util::log('White label request data ', print_r($postData, true));
        $res = $this->request('RegisterOrder', $postData);
        $this->checkError($res);

        Util::log('White label server resp', print_r($res, true));
        if (strpos($res, 'correct') !== -1) {
            return $title;
        } else {
            throw new TException('Invalid server response');
        }
    }

    /**
     * Method used to acquire report of incoming payments.
     * Method returns list of all payments in the specified period.
     *
     * @param string $order
     * @param int $startTime time in unix timestamp format
     * @param int|bool $endTime time in unix timestamp format
     * @param string $separator
     *
     * @return mixed
     */
    public function paymentsReport($order, $startTime, $endTime = false, $separator = ';')
    {
        $postData = array(
            static::APILOGIN => $this->apiLogin,
            static::APIPASS  => $this->apiPass,
            'order'          => $order,
            'separator'      => $separator,
        );
        $postData['from'] = date('Y-m-d', (int)$startTime);
        $endTime = ($endTime !== false) ? (int)$endTime : time();
        $postData['to'] = date('Y-m-d', $endTime);

        $postData['hash'] = sha1($order . $postData['from'] . $postData['to'] . $separator . $this->apiHash);

        return $this->request('PaymentsReport', $postData);
    }

    /**
     * Get information about all available bank channels.
     *
     * @throws TException
     *
     * @return mixed
     */
    public function getBanksData()
    {
        $data = $this->getBanks();
        return array(
            'data' => $data,
            'html' => Util::parseTemplate('white_label/_tpl/bankList', $data),
        );

    }

    /**
     * Bank transfer instruction for specific bank id
     *
     * @param int $bankID bank id
     *
     * @throws TException
     *
     * @return string[]
     */
    public function getBankInstr($bankID)
    {
        $postData = array(
            static::APILOGIN => $this->apiLogin,
            static::APIPASS  => $this->apiPass,
            'bank_id'        => $bankID,
        );
        $res = $this->request('GetBankInstr', $postData);

        preg_match_all('/(.*)/', $res, $matches);
        if (isset($matches[1]) && isset($matches[1][0])) {
            $instructions = json_decode($matches[1][0], true);
        } else {
            throw new TException('Invalid server response');
        }

        $data = array(
            'bank_id'      => $bankID,
            'instructions' => $instructions,
        );

        return Util::parseTemplate('white_label/_tpl/bankInstruction', $data);
    }
}
