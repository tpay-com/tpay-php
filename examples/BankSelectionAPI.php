<?php

namespace TpayExample;

use Tpay\OriginApi\PaymentForms\PaymentBasicForms;

include_once 'config.php';
include_once 'loader.php';

class BankSelectionAPIExample extends PaymentBasicForms
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
        $form = $this->getBankSelectionForm([], false, true, 'TransactionApiExample.php');

        echo $form;
    }
}

(new BankSelectionAPIExample())->getBankForm();
