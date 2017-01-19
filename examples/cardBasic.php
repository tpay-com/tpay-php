<?php

require_once dirname(dirname(__FILE__)) . '/src/_class_tpay/paymentCard.php';

class CardBasic
{

    public function __construct()
    {
        $this->getCardTransactionForm();
    }

    public function getCardTransactionForm()
    {

        $config = array(
            'name'     => 'Jan Kowalski',
            'email'    => 'jan.kowalski@example.com',
            'amount'   => 99.99,
            'order_id' => '100020003000',
            'desc'     => 'Transaction description',
        );

        $tpay = new tpay\PaymentCard();
        echo $tpay->getTransactionForm($config);

    }


}
