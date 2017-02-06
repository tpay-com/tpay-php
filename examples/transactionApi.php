<?php

/*
 * Created by tpay.com
 */

class TransactionApi
{

    const TRID = 'TR-C7K-9E5VFX';
    private $api;

    public function __construct(tpay\TransactionAPI $object)
    {
        $this->api = $object;
    }

    public function listMasspayment()
    {

        /**
         * Masspayment list packs
         */

        $packId = false;
        $from = '2014-01-01';
        $to = '2015-01-01';

        try {
            $result = $this->api->masspaymentPacks($packId, $from, $to);
            print_r($result);
        } catch (\tpay\TException $e) {
            var_dump($e);
        }


    }


    public function transferMasspayment()
    {
        /**
         * Masspayment transfer
         */

        $packId = '123123';
        $transactionId = static::TRID;

        try {
            $result = $this->api->masspaymentTransfers($packId, $transactionId);
            print_r($result);
        } catch (\tpay\TException $e) {
            var_dump($e);
        }

    }

    public function authorizeMasspayment()
    {
        /**
         * Masspayment Authorizee
         */

        $packId = '123123123';

        try {
            $result = $this->api->masspaymentAuthorize($packId);
            print_r($result);
        } catch (\tpay\TException $e) {
            var_dump($e);
        }

    }

    public function createMasspayment()
    {
        /**
         * Masspayment create
         */


        $csv = file_get_contents('masspayment.csv');

        try {
            $result = $this->api->masspaymentCreate($csv);
            print_r($result);
        } catch (\tpay\TException $e) {
            var_dump($e);
        }

    }

    public function refundAnyTransaction()
    {
        /**
         * Refund custom amount
         */


        $transactionId = static::TRID;
        $amount = 100.00;

        try {
            $result = $this->api->refundAny($transactionId, $amount);
            print_r($result);
        } catch
        (\tpay\TException $e) {
            var_dump($e);
        }

    }


    public function refundTransaction()
    {
        /**
         * Refund transaction
         */


        $transactionId = static::TRID;


        try {
            $result = $this->api->refund($transactionId);
            print_r($result);
        } catch (\tpay\TException $e) {
            var_dump($e);
        }

    }

    public function getReportTransaction()
    {
        /**
         * Get report
         */


        $from = '2014-01-01';

        try {
            $report = $this->api->report($from);
            print_r($report);
        } catch (\tpay\TException $e) {
            var_dump($e);
        }

    }

    public function getTransaction()
    {
        /**
         * Get info about transaction
         */


        $transactionId = static::TRID;


        try {
            $transaction = $this->api->get($transactionId);
            print_r($transaction);
        } catch (\tpay\TException $e) {
            var_dump($e);
        }

    }

    public function createTransaction()
    {
        /**
         * Create new transaction
         */


        $config = array(
            'kwota'     => 999.99,
            'opis'      => 'Transaction description',
            'crc'       => '100020003000',
            'wyn_url'   => 'http://example.pl/examples/transactionApi.php?transaction_confirmation',
            'wyn_email' => 'shop@example.com',
            'pow_url'   => 'http://example.pl/examples/transactionApi.php',
            'email'     => 'customer@example.com',
            'imie'      => 'Jan',
            'nazwisko'  => 'Kowalski',
            'kanal'     => 23,
        );
        try {
            $res = $this->api->create($config);
            echo '<a href="' . $res['url'] . '">go to payment</a>';
        } catch (\tpay\TException $e) {
            var_dump($e);
        }

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
            $responseBlik = $this->api->blik($code, $title);
            if ($responseBlik->result[0] === 1) {
                echo 'success!';
            } else {
                echo 'invalid code or transaction not accepted on time';
            }

        } catch (\tpay\TException $e) {
            var_dump($e);
        }

    }

}
