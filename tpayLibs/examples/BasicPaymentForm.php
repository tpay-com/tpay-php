<?php

/*
 * Created by tpay.com
 */

namespace tpayLibs\examples;

use tpayLibs\src\_class_tpay\PaymentForms\PaymentBasicForms;

include_once 'config.php';
include_once 'loader.php';

class TpayBasicExample extends PaymentBasicForms
{

    public function __construct()
    {
        $this->merchantSecret = 'demo';
        $this->merchantId = 1010;
        parent::__construct();
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
        echo $this->getTransactionForm($config);

    }
}

(new TpayBasicExample())->getDataForTpay();
