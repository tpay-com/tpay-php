<?php

require_once dirname(dirname(__FILE__)) . '/src/_class_tpay/paymentBasic.php';

class BasicEhat
{

    public function __construct()
    {
        $this->getEhatForm();
    }

    public function getEhatForm()
    {
        $config = array(
            'kwota'     => 999.99,
            'opis'      => 'Transaction description',
            'crc'       => '100020003000',
            'wyn_url'   => 'http://example.pl/examples/paymentBasic.php?transaction_confirmation',
            'wyn_email' => 'shop@example.com',
            'pow_url'   => 'http://example.pl/examples/paymentBasic.php',
            'email'     => 'customer@example.com',
            'imie'      => 'Jan',
            'nazwisko'  => 'Kowalski',
        );

        $tpay = new tpay\PaymentBasic();

        /*
         * This method return HTML form
         */
        $paymentForm = $tpay->getEHatForm($config);

        echo $paymentForm;

        ?>

        <button id="go-to-payment" type="button">Pay</button>

        <script>
            var button = document.getElementById('go-to-payment');
            button.onclick = function () {
                document.getElementById('tpay-payment').submit();
            }
        </script>
        <?php
    }
}

