<?php

/*
 * Created by tpay.com
 */

namespace tpayLibs\examples;

use tpayLibs\src\_class_tpay\PaymentSzkwal;

include_once 'config.php';
include_once 'loader.php';

class SzkwalExample extends PaymentSzkwal
{
    public function __construct()
    {
        $this->szkwalApiLogin = '';
        $this->szkwalApiPass = '';
        $this->szkwalApiHash = '';
        $this->szkwalPartnerUniqueAddress = '';
        $this->szkwalTitleFormat = '';
        parent::__construct();
    }

    public function getSzkwalHtml()
    {
        /**
         * Register new client
         */

        $clientName = 'John Doe';
        $clientEmail = 'customer@example.com';
        $clientPhone = '126354789';
        $crc = '100020003000';
        $clientBankAccount = '48079682082787844636363553';

        $szkwalResult = $this->registerClient($clientName, $clientEmail, $clientPhone, $crc, $clientBankAccount);

        $merchantData = 'Sklep ze zdrową żywnością<br>ul. Świdnicka 26, 50-345 Wrocław';
        $amount = 123.45;
        $html = $this->getConfirmationBlock($szkwalResult['title'], $amount, $merchantData);

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
        return $this->registerIncome($clientTitle, $amount);

        /*
         * string(82) " correct "
         */

    }

    public function updateNotificationUrl()
    {

        /**
         * Update notification URL
         */
        $notificationURL = 'http://example.pl?szkwal_notification';

        return $this->changeSellerData($notificationURL);

        /*
         * bool(true)
         */

    }
}
