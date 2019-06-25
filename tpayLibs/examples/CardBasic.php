<?php

/*
 * Created by tpay.com
 */

namespace tpayLibs\examples;

use tpayLibs\src\_class_tpay\PaymentForms\PaymentCardForms;
use tpayLibs\src\_class_tpay\Utilities\TException;

include_once 'config.php';
include_once 'loader.php';

class CardBasic extends PaymentCardForms
{
    public function __construct()
    {
        $this->cardApiKey = 'bda5eda723bf1ae71a82e90a249803d3f852248d';
        $this->cardApiPass = 'IhZVgraNcZoWPLgA';
        $this->cardKeyRSA = 'LS0tLS1CRUdJTiBQVUJMSUMgS0VZLS0tLS0NCk1JR2ZNQTBHQ1NxR1NJYjNEUUVCQVFVQUE0R05BRENCaVFLQmdRQ2NLRTVZNU1Wemd5a1Z5ODNMS1NTTFlEMEVrU2xadTRVZm1STS8NCmM5L0NtMENuVDM2ekU0L2dMRzBSYzQwODRHNmIzU3l5NVpvZ1kwQXFOVU5vUEptUUZGVyswdXJacU8yNFRCQkxCcU10TTVYSllDaVQNCmVpNkx3RUIyNnpPOFZocW9SK0tiRS92K1l1YlFhNGQ0cWtHU0IzeHBhSUJncllrT2o0aFJDOXk0WXdJREFRQUINCi0tLS0tRU5EIFBVQkxJQyBLRVktLS0tLQ';
        $this->cardVerificationCode = '6680181602d396e640cb091ea5418171';
        $this->cardHashAlg = 'sha1';
        parent::__construct();

    }

    public function getCardTransactionForm()
    {
        try {
            $config = [
                'name' => 'John Doe',
                'email' => 'customer@example.com',
                'desc' => 'Transaction description',
            ];
            $this->setAmount(99.15);

            echo $this->getTransactionForm($config);

        } catch (TException $e) {
            var_dump($e);
        }
    }

    public function getRedirectTransaction()
    {
        try {
            $config = [
                'name' => 'John Doe',
                'email' => 'customer@example.com',
                'desc' => 'Transaction description',
            ];
            $this
                ->setAmount(99.15)
                ->setCurrency(985)
                ->setOrderID('123')
                ->setReturnUrls('https://shop.com/success', 'https://shop.com/error');
            $transaction =  $this->registerSale($config['name'], $config['email'], $config['desc']);
            if (isset($transaction['sale_auth']) === false) {
                throw new TException('Error generating transaction: ' . $transaction['err_desc']);
            }
            $transactionId = $transaction['sale_auth'];
            header("Location: https://secure.tpay.com/cards/?sale_auth=$transactionId");
        } catch (TException $e) {
            echo 'Unable to generate transaction. Reason: ' . $e->getMessage();
        }
    }

}

(new CardBasic())->getRedirectTransaction();
