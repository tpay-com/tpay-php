<?php

namespace tpayLibs\examples;

use Tpay\Dictionaries\FieldsConfigDictionary;
use Tpay\PaymentForms\PaymentCardForms;
use Tpay\Utilities\Util;

include_once 'config.php';
include_once 'loader.php';

class CardGate extends PaymentCardForms
{
    public function __construct()
    {
        // This is pre-configured sandbox access. You should use your own data in production mode.
        $this->cardApiKey = 'bda5eda723bf1ae71a82e90a249803d3f852248d';
        $this->cardApiPass = 'IhZVgraNcZoWPLgA';
        $this->cardKeyRSA = 'LS0tLS1CRUdJTiBQVUJMSUMgS0VZLS0tLS0NCk1JR2ZNQTBHQ1NxR1NJYjNEUUVCQVFVQUE0R05BRENCaVFLQmdRQ2NLRTVZNU1Wemd5a1Z5ODNMS1NTTFlEMEVrU2xadTRVZm1STS8NCmM5L0NtMENuVDM2ekU0L2dMRzBSYzQwODRHNmIzU3l5NVpvZ1kwQXFOVU5vUEptUUZGVyswdXJacU8yNFRCQkxCcU10TTVYSllDaVQNCmVpNkx3RUIyNnpPOFZocW9SK0tiRS92K1l1YlFhNGQ0cWtHU0IzeHBhSUJncllrT2o0aFJDOXk0WXdJREFRQUINCi0tLS0tRU5EIFBVQkxJQyBLRVktLS0tLQ';
        $this->cardVerificationCode = '6680181602d396e640cb091ea5418171';
        $this->cardHashAlg = 'sha1';
        parent::__construct();
    }

    public function init()
    {
        if (empty($_POST)) {
            // Show new payment form
            echo $this->getOnSiteCardForm('CardGate.php', true, false);
        } else {
            // Try to sale with provided card data
            $response = $this->makeCardPayment();
            // Successful payment by card not protected by 3DS
            if (isset($response['result']) && 1 === (int)$response['result']) {
                $this->setOrderAsComplete($response);
                // Successfully generated 3DS link for payment authorization
            } elseif (isset($response['3ds_url'])) {
                header('Location: '.$response['3ds_url']);
            } else {
                // Invalid credit card data
                $this->tryToSaleAgain();
            }
        }
    }

    private function makeCardPayment($failOver = false)
    {
        // If you set the third getOnSiteCardForm() parameter true, you can get client name and email here. Otherwise, you must get those values from your DB.
        $clientEmail = 'customer@example.com';
        $clientName = 'John Doe';

        $cardData = Util::post('carddata', FieldsConfigDictionary::STRING);
        $saveCard = Util::post('card_save', FieldsConfigDictionary::STRING);
        Util::log('Secure Sale post params', print_r($_POST, true));
        if ('on' === $saveCard) {
            $this->setOneTimer(false);
        }
        $this->setAmount(123)->setCurrency(985)->setOrderID('test payment 123');
        $this->setLanguage('en')->setReturnUrls('https://tpay.com', 'https://google.pl');

        return false === $failOver
            ? $this->registerSale($clientName, $clientEmail, 'test sale', $cardData)
            : $this->setCardData(null)->registerSale($clientName, $clientEmail, 'test sale');
    }

    private function setOrderAsComplete($params)
    {
        var_dump($params);
    }

    private function tryToSaleAgain()
    {
        // Try to create new transaction and redirect customer to Tpay transaction panel
        $response = $this->makeCardPayment(true);
        if (isset($response['sale_auth'])) {
            header('Location: https://secure.tpay.com/cards/?sale_auth='.$response['sale_auth']);
        } else {
            echo $response['err_desc'];
        }
    }
}

(new CardGate())->init();
