<?php

/**
 * Created by PhpStorm.
 * User: user
 * Date: 18.01.2017
 * Time: 19:30
 */
class SzkwalNotification
{
    public function __construct()
    {
        if (filter_input(INPUT_GET, ['szkwal_notification'])) {
            $this->handleNotification();
        }
    }

    public function handleNotification()
    {
        $tpay = new tpay\PaymentSzkwal();
        tpay\Lang::setLang('pl');
        return $tpay->handleNotification();

    }
}
