<?php
namespace tpayLibs\examples;

use tpayLibs\src\_class_tpay\PaymentForms\PaymentCardForms;
use tpayLibs\src\_class_tpay\Utilities\TException;

include_once 'config.php';
include_once 'loader.php';

class CardPaymentLinkBuilder extends PaymentCardForms
{
    const REQUIRED_FIELDS = [
        'name',
        'desc',
        'email',
        'amount',
        'currency',
    ];

    const ALLOWED_CURRENCIES = [
        '985' => 'PLN',
        '826' => 'GBP',
        '840' => 'USD',
        '978' => 'EUR',
        '203' => 'CZK',
        '578' => 'NOK',
        '208' => 'DKK',
        '752' => 'SEK',
        '756' => 'CHF',
        '980' => 'UAH',
        '643' => 'RUB',
        '36' => 'AUD',
        '348' => 'HUF',
        '554' => 'NZD',
        '702' => 'SGD',
        '682' => 'SAR',
        '124' => 'CAD',
        '344' => 'HKD',
    ];

    const ALLOWED_LANGUAGES = [
        'PL',
        'EN',
    ];

    public function __construct()
    {
        $this->cardApiKey = 'bda5eda723bf1ae71a82e90a249803d3f852248d';
        $this->cardApiPass = 'IhZVgraNcZoWPLgA';
        $this->cardKeyRSA = 'LS0tLS1CRUdJTiBQVUJMSUMgS0VZLS0tLS0NCk1JR2ZNQTBHQ1NxR1NJYjNEUUVCQVFVQUE0R05BRENCaVFLQmdRQ2NLRTVZNU1Wemd5a1Z5ODNMS1NTTFlEMEVrU2xadTRVZm1STS8NCmM5L0NtMENuVDM2ekU0L2dMRzBSYzQwODRHNmIzU3l5NVpvZ1kwQXFOVU5vUEptUUZGVyswdXJacU8yNFRCQkxCcU10TTVYSllDaVQNCmVpNkx3RUIyNnpPOFZocW9SK0tiRS92K1l1YlFhNGQ0cWtHU0IzeHBhSUJncllrT2o0aFJDOXk0WXdJREFRQUINCi0tLS0tRU5EIFBVQkxJQyBLRVktLS0tLQ';
        $this->cardVerificationCode = '6680181602d396e640cb091ea5418171';
        $this->cardHashAlg = 'sha1';
        parent::__construct();
    }

    public function init()
    {
        if (!empty($_POST)) {
            $this->getCardPaymentLink();
        } else {
            $this->showBuilderForm();
        }
    }

    public function showBuilderForm()
    {
        $data['currencies'] = static::ALLOWED_CURRENCIES;
        $data['languages'] = static::ALLOWED_LANGUAGES;
        $data['actionPath'] = '';
        echo $this->getCardPaymentLinkBuilderForm($data);
    }

    public function getCardPaymentLink()
    {
        try {
            foreach (static::REQUIRED_FIELDS as $fieldName) {
                if (!isset($_POST[$fieldName])) {
                    throw new TException(sprintf('Required field %s is missing', $fieldName));
                }
            }
            $_POST['amount'] = str_replace(',', '.', $_POST['amount']);
            $this
                ->setAmount((double)$_POST['amount'])
                ->setCurrency((int)$_POST['currency']);
            $this->setNotRequiredFields();
            $transaction = $this->registerSale($_POST['name'], $_POST['email'], $_POST['desc']);
            if (isset($transaction['sale_auth']) === false) {
                echo sprintf('Error generating transaction. Tpay server response: %s', $transaction['err_desc']);
            }
            $transactionId = $transaction['sale_auth'];
            echo sprintf(
                'Build successful. Transaction link: https://secure.tpay.com/cards/?sale_auth=%s',
                $transactionId
            );
        } catch (TException $e) {
            echo 'Unable to generate transaction. Reason: '.$e->getMessage();
        }
    }

    private function setNotRequiredFields()
    {
        if (isset($_POST['language']) && !empty($_POST['language'])) {
            $this->setLanguage(strtoupper($_POST['language']));
        } else {
            $this->setLanguage('EN');
        }
        if (isset($_POST['order_id']) && !empty($_POST['order_id'])) {
            $this->setOrderID($_POST['order_id']);
        }
        if (isset($_POST['return_url_success'], $_POST['return_url_error'])) {
            $this->setReturnUrls($_POST['return_url_success'], $_POST['return_url_error']);
        }
    }

}

(new CardPaymentLinkBuilder)->init();
