<?php

$apiKey = '[TRANSACTION_API_KEY]';
$apiPass = '[TRANSACTION_API_PASS]';
$merchantId = '[MERCHANT_ID]';
$merchantSecret = '[MERCHANT_SECRET]';
require_once dirname(dirname(__FILE__)).'/src/_class_transferuj/transaction_api.php';

$api = new \Transferuj\TransactionAPI($apiKey, $apiPass, $merchantId, $merchantSecret);

/*
 * Handle payment confirmation sent by Transferuj.pl server
 */
if (isset($_GET['transaction_confirmation'])) {
    $transferuj = new Transferuj\PaymentBasic();
    $paymentDetails = $transferuj->checkPayment();


    print_r($paymentDetails);
    /*
     * Example $paymentDetails response
    Array
    (
        [id] => 12345
        [tr_id] => TR-C8K-25FR0X
        [tr_date] => 2015-07-22 08:45:23
        [tr_crc] => order_200
        [tr_amount] => 40.96
        [tr_paid] => 40.96
        [tr_desc] => Sklep transferuj.pl
        [tr_status] => TRUE
        [tr_error] => none
        [tr_email] => kowalsky@example.com
        [test_mode] => 1
        [md5sum] => 0d1cf3083e2fe3b49d046c28e28d120c
    )
     */
    die;
}

/**
 * Masspayment list packs
 */

$pack_id = false;
$from = '2014-01-01';
$to = '2015-01-01';

try {
    $result = $api->masspaymentPacks($pack_id, $from, $to);
    print_r($result);
} catch(\Transferuj\TException $e){
    var_dump($e);
}

die;

/**
 * Masspayment transfer
 */

$pack_id = '123123';
$transaction_id = 'TR-C7K-9E5VFX';

try {
    $result = $api->masspaymentTransfers($pack_id, $transaction_id);
    print_r($result);
} catch(\Transferuj\TException $e){
    var_dump($e);
}

die;



/**
 * Masspayment Authorizee
 */

$pack_id = '123123123';

try {
    $result = $api->masspaymentAuthorize($pack_id);
    print_r($result);
} catch(\Transferuj\TException $e){
    var_dump($e);
}

die;


/**
 * Masspayment create
 */


$csv = file_get_contents('masspayment.csv');

try {
    $result = $api->masspaymentCreate($csv);
    print_r($result);
} catch(\Transferuj\TException $e){
    var_dump($e);
}

die;

/**
 * Refund custom amount
 */


$transaction_id = 'TR-C7K-9E5VFX';


try {
    $result = $api->refundAny($transaction_id);
    print_r($result);
} catch(\Transferuj\TException $e){
    var_dump($e);
}



die;

/**
 * Refund transaction
 */


$transaction_id = 'TR-C7K-9E5VFX';


try {
    $result = $api->refund($transaction_id);
    print_r($result);
} catch(\Transferuj\TException $e){
    var_dump($e);
}



die;
/**
 * Get report
 */


$from = '2014-01-01';

try {
    $report = $api->report($from);
    print_r($report);
} catch(\Transferuj\TException $e){
    var_dump($e);
}


die;





/**
 * Get info about transaction
 */


$transaction_id = 'TR-C7K-9E5VFX';


try {
    $transaction = $api->get($transaction_id);
    print_r($transaction);
} catch(\Transferuj\TException $e){
    var_dump($e);
}

die;

/**
 * Create new transaction
 */


$config = array(
    'kwota'             => 999.99,
    'opis'              => 'Transaction description',
    'crc'               => '100020003000',
    'wyn_url'           => 'http://example.pl/examples/transaction_api.php?transaction_confirmation',
    'wyn_email'         => 'shop@example.com',
    'pow_url'           => 'http://example.pl/examples/transaction_api.php',
    'email'             => 'customer@example.com',
    'imie'              => 'Jan',
    'nazwisko'          => 'Kowalski',
    'kanal'             => 23,
);
try {
    $res = $api->create($config);
} catch(\Transferuj\TException $e){
    var_dump($e);
    die;
}

echo '<a href="'.$res['url'].'">go to payment</a>';
