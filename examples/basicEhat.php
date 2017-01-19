<?php

/*
 * Created by tpay.com
 */

class BasicEhat
{
    private $tpay;

    public function __construct(tpay\PaymentBasic $object)
    {
        $this->tpay = $object;
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

        /*
         * This method return HTML form
         */
        $paymentForm = $this->tpay->getEHatForm($config) . '<button id="go-to-payment" type="button">Pay</button>';
        $paymentForm .= "
        <script>
            var button = document.getElementById('go-to-payment');
            button.onclick = function () {
                document.getElementById('tpay-payment').submit();
            }
        </script>";
        echo $paymentForm;
    }
}

