<?php

/**
 * Created by PhpStorm.
 * User: user
 * Date: 18.01.2017
 * Time: 19:24
 */
class SmsNotification
{
    public function __construct()
    {
        if (filter_input(INPUT_POST, ['check_sms'])) {
            $this->handleSmsNotification();
        }
    }

    public function handleSmsNotification()
    {

        $tpay = new tpay\PaymentSMS();
        $result = $tpay->verifyCode();

        echo '<h1>sprawdzenie SMS</h1>';
        echo 'result: ' . (int)$result;
    }
}
