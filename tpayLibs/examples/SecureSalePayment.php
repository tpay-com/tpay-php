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
        $this->cardApiKey = '';
        $this->cardApiPass = '';
        $this->cardKeyRSA = '';
        $this->cardVerificationCode = '';
        $this->cardHashAlg = 'sha1';
        parent::__construct();
        $this->makeCardPayment();
    }

    private function makeCardPayment()
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

new SecureSalePayment();
