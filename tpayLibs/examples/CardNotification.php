<?php

/*
 * Created by tpay.com
 */

namespace tpayLibs\examples;

use tpayLibs\src\_class_tpay\Notifications\CardNotificationHandler;

include_once 'config.php';
include_once 'loader.php';

class CardNotification extends CardNotificationHandler
{
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

    public function init()
    {
        //response contains array of data https://docs.tpay.com/#!/Tpay/tpay_elavon_notifications
        $notification = $this->getTpayNotification();
        if (isset($notification['status']) && $notification['status'] === 'correct') {
            $this->setOrderAsConfirmed($notification);
        }
    }

    private function getTpayNotification()
    {
        //If you want to disable server IP validation, run this command (not recommended):
        $this->disableValidationServerIP();
        //If you use proxy communication and want to check for Tpay server IP at HTTP_X_FORWARDED_FOR, fun this command:
        $this->enableForwardedIPValidation();
        //Check Tpay server IP and validate parameters
        $notification =  $this->handleNotification();
        //Get order details from your DB
        $shopOrderData = $this->getOrderDetailsFromDatabase($notification['order_id']);
        $testMode = isset($notification['test_mode']) ? $notification['test_mode'] : '';
        //Validate notification sign correctness
        $this
            ->setAmount($shopOrderData['amount'])
            ->setCurrency($shopOrderData['currency'])
            ->setOrderID($notification['order_id']);
        $this->validateCardSign($notification['sign'], $notification['sale_auth'], $notification['card'],
            $notification['date'], $notification['status'], $testMode);

        return $notification;
    }

    private function setOrderAsConfirmed($params)
    {
        //update your order status
        //save transaction ID (sale_auth) and if exists, client token (cli_auth) for later use

        //if the transaction was processed only to register customer card, you can make automatic refund:
        $this->refundPayment($params['sale_auth'], 'Transaction refund');
    }

    private function getOrderDetailsFromDatabase($orderId)
    {
        //Code getting order amount and currency from your DB
        //This is an example of returned values
        return [
            'amount' => 123.00,
            'currency' => 985,
        ];
    }

    private function refundPayment($transactionId, $refundDescription)
    {
        $RefundClass = new CardRefundExample();
        $RefundClass->refund($transactionId, $refundDescription);
    }

}

(new CardNotification())->init();
