<?php

/*
 * Created by tpay.com
 */

namespace tpayLibs\examples;

use tpayLibs\src\_class_tpay\Utilities\TException;
use tpayLibs\src\_class_tpay\TransactionApi;

include_once 'config.php';
include_once 'loader.php';

class TransactionApiExample extends TransactionApi
{
    const TRID = 'TR-C4Y-HJVWYX';
    private $trId;

    public function __construct()
    {
        $this->merchantSecret = 'demo';
        $this->merchantId = 1010;
        $this->trApiKey = '';
        $this->trApiPass = '';
        parent::__construct();
    }

    public function getTransaction()
    {
        /**
         * Get info about transaction
         */

        $transactionId = $this->trId;

        try {
            $transaction = $this->setTransactionID($transactionId)->get();
            print_r($transaction);
        } catch (TException $e) {
            var_dump($e);
        }

    }

    public function createTransaction()
    {
        /**
         * Create new transaction
         */


        $config = array(
            'kwota'               => 999.99,
            'opis'                => 'Transaction description',
            'crc'                 => '100020003000',
            'wyn_url'             => 'http://example.pl/examples/TransactionApiExample.php?transaction_confirmation',
            'wyn_email'           => 'shop@example.com',
            'pow_url'             => 'http://example.pl/examples/TransactionApiExample.php',
            'email'               => 'customer@example.com',
            'imie'                => 'Jan123',
            'nazwisko'            => 'Kowalski',
            'kanal'               => 21,
            'wybor'               => 1,
            'akceptuje_regulamin' => 1,
        );
        try {
            $res = $this->create($config);
            $this->trId = $res['title'];
            echo '<a href="https://secure.tpay.com/?gtitle=' . $this->trId . '">go to payment</a>';

        } catch (TException $e) {
            var_dump($e);
        }

    }

}

(new TransactionApiExample())->createTransaction();
