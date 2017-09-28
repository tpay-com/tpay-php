<?php

/*
 * Created by tpay.com
 */

namespace tpayLibs\src\_class_tpay;

/**
 * Class PaymentWhiteLabel
 *
 * @package tpay
 */
use tpayLibs\src\_class_tpay\Utilities\TException;
use tpayLibs\src\_class_tpay\Utilities\Util;
use tpayLibs\src\_class_tpay\Validators\PaymentTypes\PaymentTypeWhiteLabel;

class PaymentWhiteLabel extends PaymentSzkwal
{

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

        $hash = sha1($clientName . $clientEmail . $clientPhone . $title . $amount . $this->szkwalApiHash);

        $postData = array(
            static::APILOGIN => $this->szkwalApiLogin,
            static::APIPASS  => $this->szkwalApiPass,
            'cli_name'       => $clientName,
            'cli_email'      => $clientEmail,
            'cli_phone'      => $clientPhone,
            'order'          => $title,
            'amount'         => $amount,
            'hash'           => $hash,
        );

        $this->validateConfig(new PaymentTypeWhiteLabel(), $postData);

        Util::log('White label request data ', print_r($postData, true));
        $res = $this->request('RegisterOrder', $postData);
        $this->checkSzkwalError($res);

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
            static::APILOGIN => $this->szkwalApiLogin,
            static::APIPASS  => $this->szkwalApiPass,
            'order'          => $order,
            'separator'      => $separator,
        );
        $postData['from'] = date('Y-m-d', (int)$startTime);
        $endTime = ($endTime !== false) ? (int)$endTime : time();
        $postData['to'] = date('Y-m-d', $endTime);

        $postData['hash'] = sha1($order . $postData['from'] . $postData['to'] . $separator . $this->szkwalApiHash);

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
            'html' => Util::parseTemplate('bankList', $data),
        );

    }

    /**
     * Bank transfer instruction for specific bank id
     *
     * @param int $bankID bank id
     *
     * @throws TException
     *
     * @return string
     */
    public function getBankInstr($bankID)
    {
        $postData = array(
            static::APILOGIN => $this->szkwalApiLogin,
            static::APIPASS  => $this->szkwalApiPass,
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

        return Util::parseTemplate('bankInstruction', $data);
    }
}
