<?php

namespace tpayLibs\examples;

use tpayLibs\src\_class_tpay\TransactionApi;
use tpayLibs\src\_class_tpay\Utilities\TException;

include_once 'config.php';
include_once 'loader.php';

class TransactionApiExample extends TransactionApi
{
    private $trId;

    public function __construct()
    {
        $this->merchantSecret = 'demo';
        $this->merchantId = 1010;
        $this->trApiKey = '75f86137a6635df826e3efe2e66f7c9a946fdde1';
        $this->trApiPass = 'p@$$w0rd#@!';
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
        $config = [
            'amount' => 999.99,
            'description' => 'Transaction description',
            'crc' => '100020003000',
            'result_url' => 'http://example.pl/examples/TransactionApiExample.php?transaction_confirmation',
            'result_email' => 'shop@example.com',
            'return_url' => 'http://example.pl/examples/TransactionApiExample.php',
            'email' => 'customer@example.com',
            'name' => 'John Doe',
            'group' => isset($_POST['group']) ? (int)$_POST['group'] : 150,
            'accept_tos' => 1,
        ];
        try {
            $res = $this->create($config);
            $this->trUrl = $res['url'];
            echo '<a href='.$this->trUrl.'>go to payment</a>';

        } catch (TException $e) {
            var_dump($e);
        }

    }
}

(new TransactionApiExample())->createTransaction();
