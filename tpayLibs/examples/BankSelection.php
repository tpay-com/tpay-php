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

    /**
     * Get bank selection by sending data array
     */
    public function getBankForm()
    {

        $config = array(
            'amount' => 999.99,
            'description' => 'Transaction description',
            'crc' => '100020003000',
            'result_url' => 'http://example.pl/examples/notificationBasic.php?transaction_confirmation',
            'result_email' => 'shop@example.com',
            'return_url' => 'http://example.pl/examples/success.html',
            'email' => 'customer@example.com',
            'name' => 'John Doe',
        );

        $form = $this->getBankSelectionForm($config, false, true, null, true);

        echo $form;
    }

    /**
     * Get simple banks list presented as tiles without any other elements
     */
    public function getSimpleBanksForm()
    {
        echo $this->getSimpleBankList(false, false);
    }

}

(new BankSelectionExample())->getBankForm();
