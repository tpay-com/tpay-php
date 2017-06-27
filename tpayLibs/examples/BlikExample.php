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
        $this->trApiKey = '';
        $this->trApiPass = '';
        parent::__construct();
    }

    /**
     * pass blikcode to created transaction
     * channel for create method must be 64
     */

    public function blikTransaction()
    {
        $title = 'TR-C4Y-XXXXX';
        $code = 123456;

        try {
            $responseBlik = $this->blik($title, $code);
            if ($responseBlik->result[0] === 1) {
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
