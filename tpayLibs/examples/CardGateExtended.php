<?php
namespace tpayLibs\examples;

use tpayLibs\src\_class_tpay\PaymentForms\PaymentCardForms;
use tpayLibs\src\_class_tpay\Utilities\Util;
use tpayLibs\src\Dictionaries\FieldsConfigDictionary;

include_once 'config.php';
include_once 'loader.php';

class CardGateExtended extends PaymentCardForms
{
    const SUPPORTED_CARD_VENDORS = [
        'visa',
        'mastercard',
        'maestro',
    ];

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
        if (isset($_POST['carddata'])) {
            $this->setPaymentParameters();
            if (isset($_POST['card_vendor']) && in_array($_POST['card_vendor'], static::SUPPORTED_CARD_VENDORS)) {
                $this->saveUserCardVendor($_POST['card_vendor']);
            }
            //Try to sale with provided card data
            $response = $this->makeCardPayment();
            //Successful payment by card not protected by 3DS
            if (isset($response['result']) && (int)$response['result'] === 1) {
                $this->setOrderAsComplete($response);
                //Successfully generated 3DS link for payment authorization
            } elseif (isset($response['3ds_url'])) {
                header("Location: ".$response['3ds_url']);
            } else {
                //Invalid credit card data
                $this->tryToSaleAgain();
            }
        } elseif (isset($_POST['savedId'])) {
            $this->setPaymentParameters();
            //Payment by saved card
            $this->processSavedCardPayment($_POST['savedId']);
        } else {
            $userCards = $this->getUserSavedCards($this->getCurrentUserId());
            //Show new payment form
            echo $this->getOnSiteCardForm('CardGateExtended.php', true, false, $userCards);
        }
    }

    private function setPaymentParameters()
    {
        $this->setAmount(1)->setCurrency(985)->setOrderID('test payment 123');
        $this->setLanguage('en')->setReturnUrls('https://tpay.com', 'https://google.pl');
    }

    private function saveUserCardVendor($cardVendor)
    {
        //Code saving the user card vendor name for later use
    }

    private function makeCardPayment($failOver = false)
    {
        //If you set the third getOnSiteCardForm() parameter true, you can get client name and email here. Otherwise, you must get those values from your DB.
//        $clientName = Util::post('client_name', FieldsConfigDictionary::STRING);
//        $clientEmail = Util::post('client_email', FieldsConfigDictionary::STRING);
        $clientEmail = 'customer@example.com';
        $clientName = 'John Doe';

        $cardData = Util::post('carddata', FieldsConfigDictionary::STRING);
        $saveCard = Util::post('card_save', FieldsConfigDictionary::STRING);
        Util::log('Secure Sale post params', print_r($_POST, true));
        if ($saveCard === 'on') {
            $this->setOneTimer(false);
        }

        return $failOver === false ?
            $this->registerSale($clientName, $clientEmail, 'test sale', $cardData) :
            $this->setCardData(null)->registerSale($clientName, $clientEmail, 'test sale');
    }

    private function processSavedCardPayment($savedCardId)
    {
        $exampleCurrentUserId = $this->getCurrentUserId();
        if (!is_numeric($savedCardId)) {
            Util::log('Invalid saved cardId', 'CardId: '.$savedCardId);

            return $this->tryToSaleAgain();
        }
        $requestedCardId = (int)$savedCardId;
        $currentUserCards = $this->getUserSavedCards($exampleCurrentUserId);
        $isValid = false;
        $cardToken = '';
        foreach ($currentUserCards as $card) {
            if (($card['cardId']) === $requestedCardId) {
                $isValid = true;
                $cardToken = $card['cli_auth'];
            }
        }
        if ($isValid === false) {
            Util::log(
                'Unauthorized payment try',
                sprintf('User %s has tried to pay by not owned cardId: %s', $exampleCurrentUserId, $requestedCardId)
            );

            //Reject current payment try and redirect user to tpay payment panel new card form
            return $this->tryToSaleAgain();
        } else {
            return $this->payBySavedCard($cardToken);
        }
    }

    private function payBySavedCard($cardToken)
    {
        $this->setClientToken($cardToken);
        $transaction = $this->presaleMethod('test sale');
        if (!isset($transaction['sale_auth'])) {
            return $this->tryToSaleAgain();
        }
        $transaction['sale_auth'];
        $result = $this->saleMethod($transaction['sale_auth']);
        if (isset($result['status']) && $result['status'] === 'correct') {
            return $this->setOrderAsComplete($result);
        } else {
            return $this->tryToSaleAgain();
        }
    }

    private function setOrderAsComplete($params)
    {
        //Code setting the order status and other details in your system
        var_dump($params);
    }

    private function tryToSaleAgain()
    {
        //Try to create new transaction and redirect customer to Tpay transaction panel
        $response = $this->makeCardPayment(true);
        if (isset($response['sale_auth'])) {
            header("Location: ".'https://secure.tpay.com/cards/?sale_auth='.$response['sale_auth']);
        } else {
            echo $response['err_desc'];
        }
    }

    /**
     * Returns stored cards by userId as array. Each row contains card details
     * @param int $userId
     * @return array
     */
    private function getUserSavedCards($userId = 0)
    {
        //Code getting current logged user cards from your DB. This is only an example of DB.
        $exampleDbUsersIdsWithCards = [
            0 => [],
            2 => [
                [
                    'cardId' => 1,
                    'vendor' => 'visa',
                    'shortCode' => '****1111',
                    'cli_auth' => 't5ca63654a3c44a8fac1dea7f1227b9f5d8dc4af',
                ],
                [
                    'cardId' => 2,
                    'vendor' => 'mastercard',
                    'shortCode' => '****4444',
                    'cli_auth' => 't5ca636697eebe24b5c2cf02f5d7723f1297f825',
                ],
            ],
            3 => [
                [
                    'cardId' => 3,
                    'vendor' => 'visa',
                    'shortCode' => '****3321',
                    'cli_auth' => 't5ca6367039f480aa9df557798b47748681f1f05',
                ],
            ],
        ];

        if (isset($exampleDbUsersIdsWithCards[$userId])) {
            return $exampleDbUsersIdsWithCards[$userId];
        }

        return [];
    }

    private function getCurrentUserId()
    {
        //Code getting the user Id from your system. This is only an example.
        return 2;
    }

}

(new CardGateExtended())->init();
