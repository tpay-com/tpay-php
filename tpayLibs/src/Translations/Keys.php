<?php
/**
 * Created by tpay.com.
 * Date: 28.09.2017
 * Time: 12:13
 */

namespace tpayLibs\src\Translations;


use tpayLibs\src\_class_tpay\Utilities\TException;

class Keys
{

    protected $translations;
    private $keys = [
        // GLOBALS
        'fee_info',
        'pay',
        'merchant_info',
        'amount',
        'order',
        // BLIK
        'blik_info',
        'blik_info2',
        'blik_accept',

        // BANK SELECTION
        'cards_and_transfers',
        'other_methods',
        'accept',
        'regulations_url',
        'regulations',
        'acceptance_is_required',

        // CARD
        'card_number',
        'expiration_date',
        'signature',
        'name_on_card',
        'name_surname',
        'save_card',
        'save_card_info',
        'processing',
        'card_payment',
        'debit',
        'not_supported_card',

        // DAC
        'transfer_details',
        'payment_amount',
        'disposable_account',
        // SZKWAL
        'account_number',
        'payment_title',
        'payment_method',
        'szkwal_info',

        // WHITE LABEL
        'go_to_bank',
    ];

    public function __construct()
    {
        $this->translations = [
            'pl' => (new Polish())->translations,
            'en' => (new English())->translations,
        ];
        $this->checkKeysTranslations();
    }

    private function checkKeysTranslations()
    {
        foreach ($this->keys as $key) {
            foreach ($this->translations as $key1 => $value) {
                if (!array_key_exists($key, $value)) {
                    throw new TException('Translation for key ' . $key . ' does not exist in ' . $key1 .
                        ' translator.');
                }
            }
        }
        foreach ($this->translations as $key => $value) {
            foreach ($value as $item => $item2) {
                if (!in_array($item, $this->keys)) {
                    throw new TException('Translation for key ' . $item . ' exists in ' . $key .
                        ' translator but is not declared in keys array.');
                }
            }
        }

    }

}
