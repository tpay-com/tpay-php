<?php

/*
 * Created by tpay.com
 */

class CardBasicNotification
{
    private $tpay;

    public function __construct(tpay\PaymentCard $object)
    {
        if (filter_input(INPUT_GET, 'card_notification')) {
            $this->tpay = $object;
            $this->handleNotification();
        }
    }

    public function handleNotification()
    {

        return $this->tpay->handleNotification();

    }

}
