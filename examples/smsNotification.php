<?php

/*
 * Created by tpay.com
 */

class SmsNotification
{
    private $tpay;

    public function __construct(tpay\PaymentSMS $object)
    {
        if (filter_input(INPUT_GET, 'check_sms')) {
            $this->tpay = $object;
            $this->handleSmsNotification();
        }
    }

    public function handleSmsNotification()
    {
        $result = $this->tpay->verifyCode();

        echo '<h1>sprawdzenie SMS</h1>';
        echo 'result: ' . (int)$result;
    }
}
