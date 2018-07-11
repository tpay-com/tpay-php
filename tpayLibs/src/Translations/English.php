<?php
/**
 * Created by tpay.com.
 * Date: 28.09.2017
 * Time: 12:02
 */

namespace tpayLibs\src\Translations;


class English
{
    public $translations = [

        // GLOBALS
        'fee_info'      => 'Fee for using this payment method: ',
        'pay'           => 'Pay with tpay.com',
        'merchant_info' => 'Merchant info',
        'amount'        => 'Amount',
        'order'         => 'Order',
        // BLIK

        'blik_info'              => 'Type in 6 digit code and press pay to commit blik payment.',
        'blik_info2'             => 'If you want to pay with standard method, leave this field blank.',
        'blik_accept'            => 'By using this method you confirm acceptance',

        // BANK SELECTION
        'cards_and_transfers'    => 'Credit cards and bank transfers',
        'other_methods'          => 'Others',
        'accept'                 => 'I accept the',
        'regulations_url'        => 'regulations',
        'regulations'            => 'of tpay.com service',
        'acceptance_is_required' => 'Acceptance of regulations is required before payment',

        // CARD

        'card_number'        => 'Card number',
        'expiration_date'    => 'Expiration date',
        'signature'          => 'For MasterCard, Visa or Discover, it\'s the last three digits
             in the signature area on the back of your card.',
        'name_on_card'       => 'Name on card',
        'name_surname'       => 'Name and surname',
        'save_card'          => 'Save my card',
        'save_card_info'     => 'Let faster payments in future. Card data is stored on external, save server.',
        'processing'         => 'Processing data, please wait...',
        'card_payment'       => 'Payment',
        'debit'              => 'Please debit my account',
        'not_supported_card' => 'Sorry, your credit card number is invalid or this type is currently not supported. Please try another payment card or payment method.',

        // DAC

        'transfer_details'   => 'Bank transfer details',
        'payment_amount'     => 'The amount of the payment',
        'disposable_account' => 'Disposable account number for the payment',

        // SZKWAL

        'account_number' => 'Account number',
        'payment_title'  => 'Payment title',
        'payment_method' => 'Payment method',
        'szkwal_info'    => 'Your title transfer is dedicated to you and very important for the identification of
             payment. You can create a transfer as defined in its bank to
              quickly and easily fund your account in the future',

        // WHITE LABEL

        'go_to_bank' => 'Go to bank',
    ];

}
