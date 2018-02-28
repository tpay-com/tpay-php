<?php

/*
 * Created by tpay.com
 */

namespace tpayLibs\examples;

use tpayLibs\src\_class_tpay\PaymentCard;

include_once 'config.php';
include_once 'loader.php';

class RecurrentPayment extends PaymentCard
{
    private $saleDescription;

    public function __construct()
    {
        $this->cardApiKey = 'bda5eda723bf1ae71a82e90a249803d3f852248d';
        $this->cardApiPass = 'IhZVgraNcZoWPLgA';
        $this->cardKeyRSA = 'LS0tLS1CRUdJTiBQVUJMSUMgS0VZLS0tLS0NCk1JR2ZNQTBHQ1NxR1NJYjNEUUVCQVFVQUE0R05BRENCaVFLQmdRQ2NLRTVZNU1Wemd5a1Z5ODNMS1NTTFlEMEVrU2xadTRVZm1STS8NCmM5L0NtMENuVDM2ekU0L2dMRzBSYzQwODRHNmIzU3l5NVpvZ1kwQXFOVU5vUEptUUZGVyswdXJacU8yNFRCQkxCcU10TTVYSllDaVQNCmVpNkx3RUIyNnpPOFZocW9SK0tiRS92K1l1YlFhNGQ0cWtHU0IzeHBhSUJncllrT2o0aFJDOXk0WXdJREFRQUINCi0tLS0tRU5EIFBVQkxJQyBLRVktLS0tLQ';
        $this->cardVerificationCode = '6680181602d396e640cb091ea5418171';
        $this->cardHashAlg = 'sha1';
        parent::__construct();
    }

    public function payBySavedCreditCard(
        $clientToken,
        $saleDescription,
        $amount,
        $currency,
        $orderId = null,
        $language = 'pl'
    ) {
        $this
            ->setAmount($amount)
            ->setCurrency($currency)
            ->setClientToken($clientToken)
            ->setOrderID($orderId)
            ->setLanguage($language);
        $this->saleDescription = $saleDescription;

        $transaction = $this->prepareTransaction();
        $transactionId = $transaction['sale_auth'];
        $saleResult = $this->sale($transactionId, $this->clientAuthCode);
        //In test mode this method has 50% probability of success
        var_dump($saleResult);
    }

    private function prepareTransaction()
    {
        return $this->presale($this->saleDescription, $this->clientAuthCode);
    }

}

(new RecurrentPayment())->payBySavedCreditCard('t5a96d292cd0a5c63a14c30adeae55cb200df087', 'payment for order xyz',
    12.50, 985, 'order_123456', 'pl');
