<?php

/*
 * Created by tpay.com
 */

class CardBasic
{
    private $tpay;

    public function __construct(tpay\PaymentCard $object)
    {
        $this->tpay = $object;
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

        echo $this->tpay->getTransactionForm($config);

    }


}
