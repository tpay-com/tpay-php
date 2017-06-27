<?php

/*
 * Created by tpay.com
 */

namespace tpayLibs\examples;

use tpayLibs\src\_class_tpay\MassPayments;
use tpayLibs\src\_class_tpay\Utilities\TException;

include_once 'config.php';
include_once 'loader.php';

class MassPaymentExample extends MassPayments
{
    const TRID = 'TR-C4Y-HJVWYX';

    public function __construct()
    {
        $this->merchantSecret = 'demo';
        $this->merchantId = 1010;
        $this->trApiKey = '';
        $this->trApiPass = '';
        parent::__construct();
    }

    public function listMassPayment()
    {

        /**
         * Masspayment list packs
         */

        $packId = false;
        $from = '2016-01-01';
        $to = '2017-01-01';

        try {
            $result = $this->massPaymentPacks($packId, $from, $to);
            print_r($result);
        } catch (TException $e) {
            var_dump($e);
        }


    }


    public function transferMassPayment()
    {
        /**
         * Masspayment transfer
         */

        $packId = '123123';
        $transactionId = static::TRID;

        try {
            $result = $this->massPaymentTransfers($packId, $transactionId);
            print_r($result);
        } catch (TException $e) {
            var_dump($e);
        }

    }

    public function authorizeMassPayment()
    {
        /**
         * Masspayment Authorizee
         */

        $packId = '123123123';

        try {
            $result = $this->massPaymentAuthorize($packId);
            print_r($result);
        } catch (TException $e) {
            var_dump($e);
        }

    }

    public function createMassPayment()
    {
        /**
         * Masspayment create
         */


        $csv = file_get_contents('masspayment.csv');

        try {
            $result = $this->massPaymentCreate($csv);
            print_r($result);
        } catch (TException $e) {
            var_dump($e);
        }

    }

}
(new MassPaymentExample())->listMassPayment();
