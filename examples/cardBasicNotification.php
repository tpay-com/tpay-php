<?php

/**
 * Created by PhpStorm.
 * User: user
 * Date: 18.01.2017
 * Time: 18:55
 */
class CardBasicNotification
{
    public function __construct()
    {
        if (filter_input(INPUT_GET, ['card_notification'])) {
            $this->handleNotification();
        }
    }

    public function handleNotification()
    {

        $tpay = new tpay\PaymentCard();
        return $tpay->handleNotification();


    }

}
