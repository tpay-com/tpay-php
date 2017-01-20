<?php

/*
 * Created by tpay.com
 */

use tpay\PaymentBasic;

class TpayBasicBankSelection
{
    private $tpay;

    public function __construct(tpay\PaymentBasic $object)
    {
        $this->tpay = $object;
        $this->getBankForm();
    }

    /*
     *Get bank selection by sending data array
     */
    public function getBankForm()
    {

        $config = array(
            'kwota'     => 999.99,
            'opis'      => 'Transaction description',
            'crc'       => '100020003000',
            'wyn_url'   => 'http://example.pl/examples/notificationBasic.php?transaction_confirmation',
            'wyn_email' => 'shop@example.com',
            'pow_url'   => 'http://example.pl/examples/success.html',
            'email'     => 'customer@example.com',
            'imie'      => 'Jan',
            'nazwisko'  => 'Kowalski',
        );

        $form = $this->tpay->getBankSelectionForm($config, true, true) .
            '<button id="go-to-payment" type="button">Pay</button>';
        $form .= "
        <script>
            var button = document.getElementById('go-to-payment');
            button.onclick = function () {
                document.getElementById('tpay-payment-submit').click();
            }
        </script>";
        echo $form;
    }
}
