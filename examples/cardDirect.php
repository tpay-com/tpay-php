<?php

/*
 * Created by tpay.com
 */

class CardDirect
{
    private $tpay;

    public function __construct(\tpay\PaymentCard $object)
    {
        $this->tpay = $object;
        $this->getCardDirectHtml();

    }

    public function getCardDirectHtml()
    {
        tpay\Lang::setLang('pl');

        $staticFilesURL = '/src/';
        $handleFormURL = '/examples/payment_card_direct.php';

        $cardGateHTML = $this->tpay->getDirectCardForm($staticFilesURL, $handleFormURL);

        $exampleCardData = array(
            'number' => '4532823576358083',
            'csc'    => '976',
            'exp'    => '03 / 18',
            'name'   => 'Jan Kowalsky',
            'email'  => 'kowalsky@wp.pl',
        );

        echo '<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Card payment</title>
    <meta name="description" content="Card payment">
</head>
<body>
' . $cardGateHTML . '
<pre>' . print_r($exampleCardData, true) . '</pre>
</body>
</html>';

    }
}
