<?php

/*
 * Created by tpay.com
 */

namespace tpayLibs\examples;

use tpayLibs\src\_class_tpay\PaymentDac;

include_once 'config.php';
include_once 'loader.php';

class DacExample extends PaymentDac
{

    public function __construct()
    {
        $this->merchantSecret = 'demo';
        $this->merchantId = 1010;
        $this->trApiKey = '75f86137a6635df826e3efe2e66f7c9a946fdde1';
        $this->trApiPass = 'p@$$w0rd#@!';
        parent::__construct();
    }

    public function processDacTransaction()
    {

        $config = array(
            'amount' => 200.99,
            'description' => 'Transaction description',
            'crc' => '100020003006',
            'result_url' => 'http://example.pl/examples/paymentBasic.php?transaction_confirmation',
            'email' => 'customer@example.com',
            'name' => 'John Doe',
        );

        /*
         * This method return HTML form
         */

        $merchantData = 'Sklep ze zdrową żywnością<br>ul. Świdnicka 26, 50-345 Wrocław';

        $data = $this->registerTransaction($config, $merchantData);

        /**
         * $data['transaction']
         * array(7) {
         * ["result"]=> string(1) "1"
         * ["title"]=> string(13) "TR-C7K-9A8AAX"
         * ["amount"]=> float(200.99)
         * ["account_number"]=> string(26) "12194010763052712000000000"
         * ["online"]=> string(1) "0"
         * ["url"]=> string(0) ""
         * ["desc"]=> string(0) ""
         * ["crc"]=> string(0) "100020003006"
         * }
         *
         * Save in your database transaction crc to handle payment confirmation in future
         */

        echo $data['html'];

    }
}

(new DacExample())->processDacTransaction();
