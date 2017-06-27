<?php

/*
 * Created by tpay.com
 */

namespace tpayLibs\examples;

use tpayLibs\src\_class_tpay\PaymentSMS;

include_once 'config.php';
include_once 'loader.php';

class SmsNotification extends PaymentSMS
{

    public function __construct()
    {
        if (filter_input(INPUT_GET, 'check_sms')) {
            $this->handleSmsNotification();
        }
    }

    public function handleSmsNotification()
    {
        $result = $this->doSmsRequest();

        echo '<h1>sprawdzenie SMS</h1>';
        echo 'result: ' . (int)$result;
    }
}
