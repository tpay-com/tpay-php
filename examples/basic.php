<?php

/*
 * Created by tpay.com
 */

class TpayBasic
{
    private $tpay;

    public function __construct(tpay\PaymentBasic $object)
    {
        $this->tpay = $object;
        $this->getDataForTpay();
    }

    public function getDataForTpay()
    {

        $config = array(
            'kwota'     => 999.99,
            'opis'      => 'Transaction description',
            'crc'       => '100020003000',
            'pow_url'   => 'https://www.tpay.com',
            'wyn_url'   => 'http://example.pl/examples/paymentBasic.php?transaction_confirmation',
            'wyn_email' => 'shop@example.com',
            'email'     => 'customer@example.com',
            'imie'      => 'Jan',
            'nazwisko'  => 'Kowalski',
        );

        /*
         * This method return HTML form
         */
        echo $this->tpay->getTransactionForm($config);

    }
}
