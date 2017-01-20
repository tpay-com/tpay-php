<?php

/*
 * Created by tpay.com
 */

class CardDirectNotification
{
    private $tpay;

    public function __construct(\tpay\PaymentCard $object)
    {
        if (filter_input(INPUT_GET, 'carddata')) {
            $this->tpay = $object;
            $this->handleNotification();
        }
    }

    public function handleNotification()
    {

        tpay\Lang::setLang('pl');
        $orderAmount = (float)rand(10, 100);
        $orderID = '12312311';
        $orderDesc = 'Transaction description';
        $respons = $this->tpay->directSale($orderAmount, $orderID, $orderDesc);

        echo '<h2>CARD DIRECT SALE RESPONSE</h2><pre>' . print_r($respons, true) . '</pre>';
    }
}
