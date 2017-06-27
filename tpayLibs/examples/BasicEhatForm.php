<?php

/*
 * Created by tpay.com
 */

namespace tpayLibs\examples;

use tpayLibs\src\_class_tpay\PaymentForms\PaymentBasicForms;

include_once 'config.php';
include_once 'loader.php';

class BasicEhatExample extends PaymentBasicForms
{

    public function __construct()
    {
        $this->merchantSecret = 'demo';
        $this->merchantId = 1010;
        parent::__construct();
    }

    public function displayEhatForm()
    {
        $config = array(
            'kwota'     => 999.99,
            'opis'      => 'Transaction description',
            'crc'       => '100020003000',
            'wyn_url'   => 'http://example.pl/examples/paymentBasic.php?transaction_confirmation',
            'wyn_email' => 'shop@example.com',
            'pow_url'   => 'http://example.pl/examples/paymentBasic.php',
            'email'     => 'customer@example.com',
            'imie'      => 'Jan',
            'nazwisko'  => 'Kowalski',
        );

        /*
         * This method return HTML form
         */
        echo $this->getEHatForm($config);

    }
}

(new BasicEhatExample())->displayEhatForm();
