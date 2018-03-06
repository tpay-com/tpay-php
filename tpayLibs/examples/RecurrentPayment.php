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
    private $transactionId = null;

    public function __construct()
    {
        //This is pre-configured sandbox access. You should use your own data in production mode.
        $this->cardApiKey = 'bda5eda723bf1ae71a82e90a249803d3f852248d';
        $this->cardApiPass = 'IhZVgraNcZoWPLgA';
        $this->cardKeyRSA = 'LS0tLS1CRUdJTiBQVUJMSUMgS0VZLS0tLS0NCk1JR2ZNQTBHQ1NxR1NJYjNEUUVCQVFVQUE0R05BRENCaVFLQmdRQ2NLRTVZNU1Wemd5a1Z5ODNMS1NTTFlEMEVrU2xadTRVZm1STS8NCmM5L0NtMENuVDM2ekU0L2dMRzBSYzQwODRHNmIzU3l5NVpvZ1kwQXFOVU5vUEptUUZGVyswdXJacU8yNFRCQkxCcU10TTVYSllDaVQNCmVpNkx3RUIyNnpPOFZocW9SK0tiRS92K1l1YlFhNGQ0cWtHU0IzeHBhSUJncllrT2o0aFJDOXk0WXdJREFRQUINCi0tLS0tRU5EIFBVQkxJQyBLRVktLS0tLQ';
        $this->cardVerificationCode = '6680181602d396e640cb091ea5418171';
        $this->cardHashAlg = 'sha1';
        parent::__construct();
    }

    public function init(
        $saleDescription,
        $clientToken,
        $amount,
        $orderId = null,
        $currency = 985,
        $language = 'pl'
    ) {
        //Prepare transaction data
        $this
            ->setAmount($amount)
            ->setCurrency($currency)
            ->setOrderID($orderId)
            ->setLanguage($language)
            ->setClientToken($clientToken);
        //Prepare unpaid transaction
        $transaction = $this->presaleMethod($saleDescription);
        $this->transactionId = $transaction['sale_auth'];

        return $this;
    }

    public function payBySavedCreditCard()
    {
        //Try to execute payment
        //In test mode this method has 50% probability of success
        $result = $this->saleMethod($this->transactionId);
        if (isset($result['status']) && $result['status'] === 'correct') {
            return $this->setOrderAsConfirmed();
        } else {
            //Log rejection code
            return $result['reason'];
        }
    }

    private function setOrderAsConfirmed()
    {
        //Code updating order ($this->orderID) status as paid at your DB
        //Save transaction ID for later use
    }

}

(new RecurrentPayment())
    ->init('payment for order xyz', 't5a96d292cd0a5c63a14c30adeae55cb200df087', 12.50, 'order_123456', 985, 'pl')
    ->payBySavedCreditCard();
