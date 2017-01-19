<?php

require_once dirname(dirname(__FILE__)) . '/src/_class_tpay/paymentBasic.php';

/**
 * Class TpayBasicBankSelection
 *
 * Class returns bank selection form
 *
 * @package tpay
 */
class TpayBasicBankSelection
{

    public function __construct()
    {
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
            'wyn_url'   => 'http://example.pl/examples/payment_basic_bank_selection.php?transaction_confirmation',
            'wyn_email' => 'shop@example.com',
            'pow_url'   => 'http://example.pl/examples/payment_basic_bank_selection.php',
            'email'     => 'customer@example.com',
            'imie'      => 'Jan',
            'nazwisko'  => 'Kowalski',
        );

        $tpay = new tpay\PaymentBasic();
        echo $tpay->getBankSelectionForm($config, true, true);
        ?>

        <button id="go-to-payment" type="button">Pay</button>

        <script>
            var button = document.getElementById('go-to-payment');
            button.onclick = function () {
                document.getElementById('tpay-payment-submit').click();
            }
        </script>
        <?php
    }
}
