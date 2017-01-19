<?php

/*
 * Created by tpay.com
 */

class WhiteLabelNotification
{
    private $tpay;

    public function __construct(tpay\PaymentWhiteLabel $object)
    {
        if (filter_input(INPUT_GET, ['szkwal_notification'])) {
            $this->tpay = $object;
            $this->handleNotification();
        }
    }

    public function handleNotification()
    {
        return $this->tpay->handleNotification();
    }

}
