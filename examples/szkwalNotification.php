<?php

/*
 * Created by tpay.com
 */

class SzkwalNotification
{
    private $tpay;

    public function __construct(tpay\PaymentSzkwal $object)
    {
        if (filter_input(INPUT_GET, 'szkwal_notification')) {
            $this->tpay = $object;
            $this->handleNotification();
        }
    }

    public function handleNotification()
    {
        tpay\Lang::setLang('pl');
        return $this->tpay->handleNotification();

    }
}
