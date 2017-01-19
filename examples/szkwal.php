<?php

require_once dirname(dirname(__FILE__)) . '/src/_class_tpay/paymentSzkwal.php';

class Szkwal
{

    public function __construct()
    {

    }

    public function getSzkwalHtml()
    {


        /**
         * Register new client
         */

        $clientName = 'Jan Kowalski';
        $clientEmail = 'jan.kowalski@example.com';
        $clientPhone = '126354789';
        $crc = '100020003000';
        $clientBankAccount = '48079682082787844636363553';
        $tpay = new tpay\PaymentSzkwal();
        tpay\Lang::setLang('pl');
        $szkwalResult = $tpay->registerClient($clientName, $clientEmail, $clientPhone, $crc, $clientBankAccount);

        $staticFilesURL = 'http://example.pl/src/';
        $merchantData = 'Sklep ze zdrową żywnością<br>ul. Świdnicka 26, 50-345 Wrocław';
        $amount = 123.45;
        $html = $tpay->getConfirmationBlock($szkwalResult['title'], $amount, $staticFilesURL, $merchantData);

        echo $html;

        /**
         *array(2) {
         *["client_id"]=> int(658901)
         *["title"]=> string(12) "KIP438010354"
         *}
         */


    }


    public function registerClientIncomeTest()
    {
        /**
         * Register client income in test mode.
         */

        $clientTitle = 'KIP438010354';
        $amount = 100;
        $tpay = new tpay\PaymentSzkwal();
        return $tpay->registerIncome($clientTitle, $amount);

        /*
         * string(82) " correct "
         */

    }

    public function updateNotificationUrl()
    {

        /**
         * Update notification URL
         */
        $tpay = new tpay\PaymentSzkwal();
        $notificationURL = 'http://example.pl?szkwal_notification';

        return $tpay->changeSellerData($notificationURL);

        /*
         * bool(true)
         */

    }
}
