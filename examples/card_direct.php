<?php

require_once dirname(dirname(__FILE__)).'/src/_class_transferuj/payment_card.php';

$transferuj = new Transferuj\PaymentCard();
Transferuj\Lang::setLang('pl');

/*
* Handle card payment form
*/
if (isset($_POST['carddata'])) {
    $orderAmount = (float) rand(10, 100);
    $orderID = '12312311';
    $orderDesc = 'Transaction description';
    $respons = $transferuj->directSale($orderAmount, $orderID, $orderDesc);

    echo '<h2>CARD DIRECT SALE RESPONSE</h2><pre>'.print_r($respons, true).'</pre>';
    die;
}

$staticFilesURL = '/src/';
$handleFormURL = '/examples/payment_card_direct.php';

$cardGateHTML = $transferuj->getDirectCardForm($staticFilesURL, $handleFormURL);

$exampleCardData = array(
    'number' => '4532823576358083',
    'csc' => '976',
    'exp' => '03 / 18',
    'name' => 'Jan Kowalsky',
    'email' => 'kowalsky@wp.pl',
);

?><!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Card payment</title>
    <meta name="description" content="Card payment">
</head>
<body>
<?php echo $cardGateHTML ?>
<pre><?php echo print_r($exampleCardData, true) ?></pre>
</body>
</html>