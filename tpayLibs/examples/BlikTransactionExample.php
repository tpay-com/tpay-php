<?php

/*
 * Created by tpay.com
 */

namespace tpayLibs\examples;

use tpayLibs\src\_class_tpay\PaymentBlik;
use tpayLibs\src\_class_tpay\Utilities\TException;
use tpayLibs\src\_class_tpay\Utilities\Util;

include_once 'config.php';
include_once 'loader.php';

class BlikTransactionExample extends PaymentBlik
{
    public function __construct()
    {
        $this->merchantSecret = 'demo';
        $this->merchantId = 1010;
        $this->trApiKey = '75f86137a6635df826e3efe2e66f7c9a946fdde1';
        $this->trApiPass = 'p@$$w0rd#@!';
        parent::__construct();
        $this->init();
    }

    public function init()
    {
        if (isset($_POST['blik_code'])) {
            $this->blikTransaction($_POST['blik_code']);
        } else {
            echo $this->getBlikForm();
        }
    }

    private function getBlikForm()
    {
        return $this->getBlikSelectionForm('BlikTransactionExample.php');
    }

    /**
     * Pass BLIK code to created transaction
     * Bank group for create method must be 150
     * @param string $blikCode
     */
    private function blikTransaction($blikCode)
    {
        $config = array(
            'description' => 'Test API transaction',
            'amount' => 0.20,
            'crc' => 'test',
            'group' => 150,
            'name' => 'John Doe',
            'email' => 'customer@example.com',
            'accept_tos' => 1,
            'result_url' => 'https://example.com/notify.php',
        );
        $transaction = $this->create($config);
        $title = $transaction['title'];

        try {
            $responseBlik = $this->blik($title, $blikCode);
            var_dump($responseBlik);
        } catch (TException $e) {
            var_dump($e);
        }
    }

}

new BlikTransactionExample;
