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
        //This is pre-configured sandbox access. You should use your own data in production mode.
        $this->cardApiKey = 'bda5eda723bf1ae71a82e90a249803d3f852248d';
        $this->cardApiPass = 'IhZVgraNcZoWPLgA';
        $this->cardKeyRSA = 'LS0tLS1CRUdJTiBQVUJMSUMgS0VZLS0tLS0NCk1JR2ZNQTBHQ1NxR1NJYjNEUUVCQVFVQUE0R05BRENCaVFLQmdRQ2NLRTVZNU1Wemd5a1Z5ODNMS1NTTFlEMEVrU2xadTRVZm1STS8NCmM5L0NtMENuVDM2ekU0L2dMRzBSYzQwODRHNmIzU3l5NVpvZ1kwQXFOVU5vUEptUUZGVyswdXJacU8yNFRCQkxCcU10TTVYSllDaVQNCmVpNkx3RUIyNnpPOFZocW9SK0tiRS92K1l1YlFhNGQ0cWtHU0IzeHBhSUJncllrT2o0aFJDOXk0WXdJREFRQUINCi0tLS0tRU5EIFBVQkxJQyBLRVktLS0tLQ';
        $this->cardVerificationCode = '6680181602d396e640cb091ea5418171';
        $this->cardHashAlg = 'sha1';
        parent::__construct();
    }

    public function getCardDirectHtml()
    {
        $cardGateHTML = $this->getOnSiteCardForm('SecureSalePayment.php');

        $exampleCardData = array(
            'number' => '4532823576358083',
            'csc' => '976',
            'exp' => '03 / 18',
            'name' => 'John Doe',
            'email' => 'customer@example.com',
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
