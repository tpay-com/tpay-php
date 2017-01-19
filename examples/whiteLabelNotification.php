<?php

/**
 * Created by PhpStorm.
 * User: user
 * Date: 19.01.2017
 * Time: 12:21
 */
class WhiteLabelNotification
{
    public function __construct()
    {
        if (filter_input(INPUT_GET, ['szkwal_notification'])) {
            $this->handleNotification();
        }
    }

    public function handleNotification()
    {

        $tpay = new tpay\PaymentWhiteLabel();

        return $tpay->handleNotification();
    }

}
