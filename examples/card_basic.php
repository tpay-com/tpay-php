<?php

require_once dirname(dirname(__FILE__)).'/src/_class_transferuj/payment_card.php';

if (isset($_GET['card_notification'])) {
    $transferuj = new Transferuj\PaymentCard();
    $cardData = $transferuj->handleNotification();
    die;
}

$config = array(
    'name'       => 'Jan Kowalski',
    'email'      => 'jan.kowalski@example.com',
    'amount'     => 99.99,
    'order_id'   => '100020003000',
    'desc'       => 'Transaction description',
);

$transferuj = new Transferuj\PaymentCard();
echo $transferuj->getTransactionForm($config);
?>