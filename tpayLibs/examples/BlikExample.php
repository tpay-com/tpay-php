<?php

/*
 * Created by tpay.com
 */

namespace tpayLibs\examples;

use tpayLibs\src\_class_tpay\PaymentBlik;
use tpayLibs\src\_class_tpay\Utilities\TException;

include_once 'config.php';
include_once 'loader.php';

class BlikExample extends PaymentBlik
{
    public function __construct()
    {
        $this->merchantSecret = 'demo';
        $this->merchantId = 1010;
        $this->trApiKey = '75f86137a6635df826e3efe2e66f7c9a946fdde1';
        $this->trApiPass = 'p@$$w0rd#@!';
        parent::__construct();
    }

    /**
     * pass blikcode to created transaction
     * channel for create method must be 150
     */

    public function blikTransaction()
    {
        $title = 'TR-C4Y-XXXXX';
        $code = 123456;

        try {
            $responseBlik = $this->blik($title, $code);
            if ((int)$responseBlik['result'] === 1) {
                echo 'success!';
            } else {
                echo 'invalid code or transaction not accepted on time';
            }

        } catch (TException $e) {
            var_dump($e);
        }

    }

}

(new BlikExample())->blikTransaction();
