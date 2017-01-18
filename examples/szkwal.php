<?php

require_once dirname(dirname(__FILE__)) . '/src/_class_transferuj/payment_szkwal.php';

$transferuj = new Transferuj\PaymentSzkwal();
Transferuj\Lang::setLang('pl');
/**
 * Register new client
 */

$clientName = 'Jan Kowalski';
$clientEmail = 'jan.kowalski@example.com';
$clientPhone = '126354789';
$crc = '100020003000';
$clientBankAccount = '48079682082787844636363553';

$szkwalResult = $transferuj->registerClient($clientName, $clientEmail, $clientPhone, $crc, $clientBankAccount);

$staticFilesURL = 'http://example.pl/src/';
$merchantData = 'Sklep ze zdrową żywnością<br>ul. Świdnicka 26, 50-345 Wrocław';
$amount = 123.45;
$html = $transferuj->getConfirmationBlock($szkwalResult['title'], $amount, $staticFilesURL, $merchantData);

echo $html;

/**
 * array(2) {
 * ["client_id"]=> int(658901)
 * ["title"]=> string(12) "KIP438010354"
 * }
 */


die;


if (isset($_GET['szkwal_notification'])) {
    $szkwalData = $transferuj->handleNotification();
    die;
}

/**
 * Register client income in test mode.
 */

$clientTitle = 'KIP438010354';
$amount = 100;

$result = $transferuj->registerIncome($clientTitle, $amount);

/*
 * string(82) " correct "
 */

die;

/**
 * Update notification URL
 */

$notificationURL = 'http://example.pl?szkwal_notification';

$result = $transferuj->changeSellerData($notificationURL);

/*
 * bool(true)
 */

die;


