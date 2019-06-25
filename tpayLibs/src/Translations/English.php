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
        'fee_info' => 'Fee for using this payment method: ',
        'pay' => 'Pay with Tpay',
        'merchant_info' => 'Merchant info',
        'amount' => 'Amount',
        'name' => 'Name and surname',
        'address' => 'Street',
        'city' => 'City',
        'zip' => 'Postal code',
        'country' => 'Country',
        'phone' => 'Phone number',
        'email' => 'Email address',
        'order' => 'Order',
        // BLIK
        'blik_code_error' => 'The BLIK code should contain 6 digits!',
        'blik_info' => 'Type in 6 digit code and press pay to commit blik payment.',
        'blik_info2' => 'If you want to pay with standard method, leave this field blank.',
        'blik_accept' => 'By using this method you confirm acceptance',
        'codeInputText' => 'BLIK code',

        // BANK SELECTION
        'cards_and_transfers' => 'Credit cards and bank transfers',
        'other_methods' => 'Others',
        'accept' => 'I accept the',
        'regulations_url' => 'regulations',
        'regulations' => 'of Tpay service',
        'acceptance_is_required' => 'Acceptance of regulations is required before payment',

        // CARD

        'card_number' => 'Card number',
        'expiration_date' => 'Expiration date',
        'signature' => 'For MasterCard, Visa or Discover, it\'s the last three digits
             in the signature area on the back of your card.',
        'name_on_card' => 'Name on card',
        'name_surname' => 'Name and surname',
        'save_card' => 'Save my card',
        'save_card_info' => 'Let the Tpay save your card to allow faster payments in future. Card data is stored on Tpay safe server.',
        'processing' => 'Processing data, please wait...',
        'debit' => 'Please debit my account',
        'not_supported_card' => 'Sorry, your credit card is currently not supported. Please try another payment card or payment method.',
        'not_valid_card' => 'Sorry, your credit card number is invalid. Please enter the valid card number',
        'saved_card_label' => 'Pay by saved card ',
        'new_card_label' => 'Pay by a new card',
    ];

}
