<?php

require_once dirname(dirname(__FILE__)) . '/src/_class_tpay/paymentCard.php';

/**
 * Created by PhpStorm.
 * User: user
 * Date: 18.01.2017
 * Time: 19:03
 */
class CardDirectNotification
{
    public function __construct()
    {
        if (filter_input(INPUT_GET, ['carddata'])) {

            $this->handleNotification();
        }
    }

    public function handleNotification()
    {

        $tpay = new tpay\PaymentCard();
        tpay\Lang::setLang('pl');
        $orderAmount = (float)rand(10, 100);
        $orderID = '12312311';
        $orderDesc = 'Transaction description';
        $respons = $tpay->directSale($orderAmount, $orderID, $orderDesc);

        echo '<h2>CARD DIRECT SALE RESPONSE</h2><pre>' . print_r($respons, true) . '</pre>';
    }
}
