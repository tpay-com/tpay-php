<?php

require_once dirname(dirname(__FILE__)) . '/src/_class_tpay/paymentCard.php';

class CardDirect
{
public function __construct()
{
    $this->getCardDirectHtml();
}
public function getCardDirectHtml()
{
$tpay = new tpay\PaymentCard();
tpay\Lang::setLang('pl');

$staticFilesURL = '/src/';
$handleFormURL = '/examples/payment_card_direct.php';

$cardGateHTML = $tpay->getDirectCardForm($staticFilesURL, $handleFormURL);

$exampleCardData = array(
    'number' => '4532823576358083',
    'csc'    => '976',
    'exp'    => '03 / 18',
    'name'   => 'Jan Kowalsky',
    'email'  => 'kowalsky@wp.pl',
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
<?php
}
}
