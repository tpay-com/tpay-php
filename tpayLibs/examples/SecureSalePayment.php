<?php

/*
 * Created by tpay.com
 */

namespace tpayLibs\examples;

use tpayLibs\src\_class_tpay\PaymentCard;
use tpayLibs\src\_class_tpay\Utilities\Util;
use tpayLibs\src\Dictionaries\FieldsConfigDictionary;

include_once 'config.php';
include_once 'loader.php';

/**
 * Process received data from TGate
 *
 * @see CardGate
 */
class SecureSalePayment extends PaymentCard
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

    public function makeCardPayment()
    {
        $cardData = Util::post('carddata', FieldsConfigDictionary::STRING);
        $clientName = Util::post('client_name', FieldsConfigDictionary::STRING);
        $clientEmail = Util::post('client_email', FieldsConfigDictionary::STRING);
        $saveCard = Util::post('card_save', FieldsConfigDictionary::STRING);
        Util::log('Secure Sale post params', print_r($_POST, true));
        if ($saveCard === 'on') {
            $this->setOneTimer(false);
        }
        /**
         * Some of those sets are optional
         * @see CardOptions
         */
        $this->setAmount(123)->setCurrency(985)->setOrderID('test payment 123');
        $this->setLanguage('en')->setReturnUrls('https://tpay.com', 'https://google.pl');

        $response = $this->registerSale($clientName, $clientEmail, 'test sale', $cardData);
        var_dump($response);
        if (isset($response['3ds_url'])) {
            header("Location: " . $response['3ds_url']);
        }
    }
}

(new SecureSalePayment())->makeCardPayment();
