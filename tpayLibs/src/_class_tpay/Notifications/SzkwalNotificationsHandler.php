<?php

/*
 * Created by tpay.com.
 * Date: 26.06.2017
 * Time: 17:36
 */

namespace tpayLibs\src\_class_tpay\Notifications;


use tpayLibs\src\_class_tpay\PaymentSzkwal;
use tpayLibs\src\_class_tpay\Utilities\TException;
use tpayLibs\src\_class_tpay\Utilities\Util;
use tpayLibs\src\_class_tpay\Validators\PaymentTypes\PaymentTypeSzkwal;

class SzkwalNotificationsHandler extends PaymentSzkwal
{

    /**
     * Handle response from tpay server
     * Check all required fields and sh1 check sum
     * Parse variables to valid types
     *
     * @throws TException
     *
     * @return array
     */
    public function handleSzkwalNotification()
    {
        Util::log('szkwal notification', print_r(INPUT_POST, true));
        $res = $this->getResponse(new PaymentTypeSzkwal());

        echo '<?xml version="1.0" encoding="UTF-8"?>
            <data>
            <result>correct</result>
            </data>';

        return $res;
    }

}
