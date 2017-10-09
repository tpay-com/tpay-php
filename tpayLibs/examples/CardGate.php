<?php

/*
 * Created by tpay.com
 */

namespace tpayLibs\examples;

use tpayLibs\src\_class_tpay\PaymentForms\PaymentCardForms;

include_once 'config.php';
include_once 'loader.php';

class CardGate extends PaymentCardForms
{
    public function __construct()
    {
        $this->cardApiKey = '';
        $this->cardApiPass = '';
        $this->cardKeyRSA = '';
        $this->cardVerificationCode = '';
        $this->cardHashAlg = 'sha1';
        parent::__construct();
    }

    public function getCardDirectHtml()
    {
        $cardGateHTML = $this->getOnSiteCardForm('SecureSalePayment.php');

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
(new CardGate())->getCardDirectHtml();
