<?php

namespace tpayLibs\src\_class_tpay\Notifications;

use tpayLibs\src\_class_tpay\PaymentOptions\BasicPaymentOptions;
use tpayLibs\src\_class_tpay\Utilities\TException;
use tpayLibs\src\_class_tpay\Utilities\Util;
use tpayLibs\src\_class_tpay\Validators\PaymentTypes\PaymentTypeBlikAlias;

class BlikAliasNotificationHandler extends BasicPaymentOptions
{
    /**
     * Check cURL request from tpay server after payment.
     * This method check server ip sent by payment server.
     * Display information to prevent sending repeated notifications.
     *
     * @throws TException
     *
     * @return array
     *
     * @internal param string $paymentType optional payment type default is 'basic'
     */
    public function checkAliasNotification()
    {
        Util::log('Blik notification', "POST params: \n".print_r($_POST, true));
        $res = $this->getResponse(new PaymentTypeBlikAlias());
        if (true === $this->validateServerIP && false === $this->isTpayServer()) {
            throw new TException('Request is not from secure server');
        }
        echo 'TRUE';

        return $res;
    }
}
