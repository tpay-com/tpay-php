<?php

namespace Tpay\Notifications;

use Tpay\PaymentOptions\BasicPaymentOptions;
use Tpay\Utilities\TException;
use Tpay\Utilities\Util;
use Tpay\Validators\PaymentTypes\PaymentTypeBasic;

class BasicNotificationHandler extends BasicPaymentOptions
{
    /**
     * Check cURL request from tpay server after payment.
     * This method check server ip, required fields and md5 checksum sent by payment server.
     * Display information to prevent sending repeated notifications.
     *
     * @param string $response Print response to Tpay server (enum: 'TRUE', 'FALSE').
     *                         If empty, then you have to print it somewhere else to avoid rescheduling notifications
     *
     * @throws TException
     *
     * @return array
     */
    public function checkPayment($response = 'TRUE')
    {
        Util::log('Basic payment notification', "POST params: \n".print_r($_POST, true));
        $res = $this->getResponse(new PaymentTypeBasic());
        $this->setTransactionID($res['tr_id']);
        $checkMD5 = $this->isMd5Valid(
            $res['md5sum'],
            number_format($res['tr_amount'], 2, '.', ''),
            $res['tr_crc']
        );
        Util::logLine('Check MD5: '.(int)$checkMD5);
        if (true === $this->validateServerIP && false === $this->isTpayServer()) {
            throw new TException('Request is not from secure server');
        }
        if (false === $checkMD5) {
            throw new TException('MD5 checksum is invalid');
        }
        if (!empty($response) && is_string($response)) {
            echo $response;
        }

        return $res;
    }

    /**
     * Check md5 sum to validate tpay response.
     * The values of variables that md5 sum includes are available only for
     * merchant and tpay system.
     *
     * @param string $md5sum            md5 sum received from tpay
     * @param string $transactionAmount transaction amount
     * @param string $crc               transaction crc
     *
     * @return bool
     */
    private function isMd5Valid($md5sum, $transactionAmount, $crc)
    {
        if (!is_string($md5sum) || 32 !== strlen($md5sum)) {
            return false;
        }

        return $md5sum === md5($this->merchantId.$this->transactionID
                .$transactionAmount.$crc.$this->merchantSecret);
    }
}
