<?php

require_once dirname(dirname(__FILE__)) . '/src/_class_transferuj/payment_basic.php';

/*
 * Handle payment confirmation sent by Transferuj.pl server
 */
if (isset($_GET['transaction_confirmation'])) {
    $transferuj = new Transferuj\PaymentBasic();
    $data = $transferuj->checkPayment();
    die;
}

$config = array(
    'kwota'     => 999.99,
    'opis'      => 'Transaction description',
    'crc'       => '100020003000',
    'wyn_url'   => 'http://example.pl/examples/payment_basic_bank_selection.php?transaction_confirmation',
    'wyn_email' => 'shop@example.com',
    'pow_url'   => 'http://example.pl/examples/payment_basic_bank_selection.php',
    'email'     => 'customer@example.com',
    'imie'      => 'Jan',
    'nazwisko'  => 'Kowalski',
);

$transferuj = new Transferuj\PaymentBasic();
echo $transferuj->getBankSelectionForm($config, true, true);
?>

<button id="go-to-payment" type="button">Pay</button>

<script>
    var button = document.getElementById('go-to-payment');
    button.onclick = function () {
        document.getElementById('transferuj-payment-submit').click();
    }
</script>
