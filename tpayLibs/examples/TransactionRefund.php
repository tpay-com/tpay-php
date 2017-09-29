<?php

/*
 * Created by tpay.com
 */

namespace tpayLibs\examples;

use tpayLibs\src\_class_tpay\Refunds\BasicRefunds;
use tpayLibs\src\_class_tpay\Utilities\TException;

include_once 'config.php';
include_once 'loader.php';

class TransactionRefund extends BasicRefunds
{
    const TRID = 'TR-C4Y-HKR3HX';

    public function __construct()
    {
        $this->merchantSecret = 'demo';
        $this->merchantId = 1010;
        $this->trApiKey = '75f86137a6635df826e3efe2e66f7c9a946fdde1';
        $this->trApiPass = 'p@$$w0rd#@!';
        parent::__construct();
    }

    public function refundAnyTransaction()
    {
        /**
         * Refund custom amount
         */

        $amount = 100.00;

        try {
            $this->transactionID = static::TRID;
            $result = $this->refundAny($amount);
            print_r($result);
        } catch
        (TException $e) {
            var_dump($e);
        }

    }

    public function refundTransaction()
    {
        /**
         * Refund transaction
         */

        try {
            $this->transactionID = static::TRID;
            $result = $this->refund();
            print_r($result);
        } catch (TException $e) {
            var_dump($e);
        }

    }

}

(new TransactionRefund())->refundTransaction();
