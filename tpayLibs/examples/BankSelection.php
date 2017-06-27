<?php

/*
 * Created by tpay.com
 */

namespace tpayLibs\examples;

use tpayLibs\src\_class_tpay\PaymentForms\PaymentBasicForms;

include_once 'config.php';
include_once 'loader.php';

class BankSelectionExample extends PaymentBasicForms
{
    public function __construct()
    {
        $this->merchantSecret = 'demo';
        $this->merchantId = 1010;
        parent::__construct();
    }

    /*
     *Get bank selection by sending data array
     */
    public function getBankForm()
    {

        $config = array(
            'kwota'     => 999.99,
            'opis'      => 'Transaction description',
            'crc'       => '100020003000',
            'wyn_url'   => 'http://example.pl/examples/notificationBasic.php?transaction_confirmation',
            'wyn_email' => 'shop@example.com',
            'pow_url'   => 'http://example.pl/examples/success.html',
            'email'     => 'customer@example.com',
            'imie'      => 'Jan',
            'nazwisko'  => 'Kowalski',
        );

        $form = $this->getBankSelectionForm($config, false, true);

        echo $form;
    }
}

(new BankSelectionExample())->getBankForm();
