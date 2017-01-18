<?php

require_once dirname(dirname(__FILE__)) . '/src/_class_transferuj/payment_basic.php';

/*
 * Handle payment confirmation sent by Transferuj.pl server
 */
if (isset($_GET['transaction_confirmation'])) {
    $transferuj = new Transferuj\PaymentBasic();
    $paymentDetails = $transferuj->checkPayment();

    /*
     * Example $paymentDetails response
    Array
    (
        [id] => 12345
        [tr_id] => TR-B7K-79FR0X
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

$config = array(
    'kwota'     => 999.99,
    'opis'      => 'Transaction description',
    'crc'       => '100020003000',
    'wyn_url'   => 'http://example.pl/examples/payment_basic.php?transaction_confirmation',
    'wyn_email' => 'shop@example.com',
    'pow_url'   => 'http://example.pl/examples/payment_basic.php',
    'email'     => 'customer@example.com',
    'imie'      => 'Jan',
    'nazwisko'  => 'Kowalski',
);

$transferuj = new Transferuj\PaymentBasic();

/*
 * This method return HTML form
 */
$paymentForm = $transferuj->getTransactionForm($config);

echo $paymentForm;
