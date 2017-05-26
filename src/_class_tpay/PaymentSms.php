<?php

/*
 * Created by tpay.com
 */

namespace tpay;

/**
 * Class PaymentSMS
 *
 * @package tpay
 */
class PaymentSMS
{
    /**
     * Url to verify SMS code
     * @var string
     */
    private $secureURL = 'http://sms.tpay.com/widget/verifyCode.php';

    /**
     * PaymentSMS class constructor
     */
    public function __construct()
    {
        require_once(dirname(__FILE__) . '/Util.php');
        Util::checkVersionPHP();
        Util::loadClass('Curl');
    }

    /**
     * Get code sent by from tpay SMS widget.
     * Validate code by sending cURL to tpay server.
     *
     * @return bool
     *
     * @throws TException
     */
    public function verifyCode()
    {
        $codeToCheck = Util::post('tfCodeToCheck', 'string');
        $hash = Util::post('tfHash', 'string');

        if ($codeToCheck === false || $hash === false) {
            throw new TException('Invalid input data');
        }

        $postData = array(
            'tfCodeToCheck' => $codeToCheck,
            'tfHash'        => $hash,
        );
        $response = Curl::doCurlRequest($this->secureURL, $postData);

        $data = explode("\n", $response);

        $status = (int)$data[0];

        return (bool)$status;
    }
}
