<?php

namespace Tpay\OriginApi\Dictionaries\Payments;

use Tpay\OriginApi\Dictionaries\FieldsConfigDictionary;

class BasicFieldsDictionary
{
    /** List of supported request fields for basic payment */
    const REQUEST_FIELDS = [
        // Transaction amount with dot as decimal separator.
        'amount' => [
            FieldsConfigDictionary::REQUIRED => true,
            FieldsConfigDictionary::VALIDATION => [FieldsConfigDictionary::FLOAT],
        ],
        // Transaction description
        'description' => [
            FieldsConfigDictionary::REQUIRED => true,
            FieldsConfigDictionary::VALIDATION => [
                FieldsConfigDictionary::STRING,
                FieldsConfigDictionary::MAXLENGTH_128,
            ],
            FieldsConfigDictionary::FILTER => FieldsConfigDictionary::TEXT,
        ],
        /*
         * The secondary parameter to the transaction identification.
         * After the transaction returned as a parameter tr_crc.
         */
        'crc' => [
            FieldsConfigDictionary::REQUIRED => false,
            FieldsConfigDictionary::VALIDATION => [
                FieldsConfigDictionary::STRING,
                FieldsConfigDictionary::MAXLENGTH_128,
            ],
        ],
        /*
         * Allow only online payment.
         * Prevents the channel selection, which at the moment is not able to post real-time payment.
         */
        'online' => [
            FieldsConfigDictionary::REQUIRED => false,
            FieldsConfigDictionary::VALIDATION => [FieldsConfigDictionary::OPTIONS],
            FieldsConfigDictionary::OPTIONS => [0, 1],
        ],
        /*
         * Imposing the customer the pre-payment channel.
         * Could be changed manually by customer.
         * Required for register transaction by transaction API
         * Customer will be presented only the selected group.
         */
        'group' => [
            FieldsConfigDictionary::REQUIRED => false,
            FieldsConfigDictionary::VALIDATION => [FieldsConfigDictionary::INT],
        ],
        /*
         * If this parameter is set, the payer will always be redirected to step 2 in tpay.com panel
         *
         * @deprecated
         */
        'choice' => [
            FieldsConfigDictionary::REQUIRED => false,
            FieldsConfigDictionary::VALIDATION => [FieldsConfigDictionary::OPTIONS],
            FieldsConfigDictionary::OPTIONS => [0, 1],
        ],
        /*
         * Customer will be redirected to bank login page.
         *
         * @deprecated
         */
        'direct' => [
            FieldsConfigDictionary::REQUIRED => false,
            FieldsConfigDictionary::VALIDATION => [FieldsConfigDictionary::INT],
        ],
        // The resulting URL return address that will send the result of a transaction in the form POST parameters.
        'result_url' => [
            FieldsConfigDictionary::REQUIRED => false,
            FieldsConfigDictionary::VALIDATION => [
                FieldsConfigDictionary::STRING,
                FieldsConfigDictionary::MAXLENGTH_512,
            ],
            FieldsConfigDictionary::FILTER => 'url',
        ],
        // E-mail address to which you will be notified about the status of the transaction.
        'result_email' => [
            FieldsConfigDictionary::REQUIRED => false,
            FieldsConfigDictionary::VALIDATION => [FieldsConfigDictionary::EMAIL_LIST],
        ],
        // Description payees during the transaction.
        'merchant_description' => [
            FieldsConfigDictionary::REQUIRED => false,
            FieldsConfigDictionary::VALIDATION => [
                FieldsConfigDictionary::STRING,
                FieldsConfigDictionary::MAXLENGTH_128,
            ],
            FieldsConfigDictionary::FILTER => FieldsConfigDictionary::TEXT,
        ],
        /*
         * Optional field used during card transactions processed through Elavon.
         * The value of the field is passed to Elavon as „TEKST REF. TRANSAKCJI”.
         * Acceptable characters are a-z, AZ (without Polish), 0-9 and space.
         * All others will be removed.
         * Max 32 signs.
         */
        'custom_description' => [
            FieldsConfigDictionary::REQUIRED => false,
            FieldsConfigDictionary::VALIDATION => [
                FieldsConfigDictionary::CUSTOM_DESCRIPTION,
                FieldsConfigDictionary::MAXLENGTH_32,
            ],
            FieldsConfigDictionary::FILTER => 'mixed',
        ],
        // The URL to which the customer will be transferred after successful completion of the transaction.
        'return_url' => [
            FieldsConfigDictionary::REQUIRED => false,
            FieldsConfigDictionary::VALIDATION => [
                FieldsConfigDictionary::STRING,
                FieldsConfigDictionary::MAXLENGTH_512,
            ],
            FieldsConfigDictionary::FILTER => 'url',
        ],
        /*
         * The URL to which the client will be transferred in the event of an error.
         * Default is return_url
         */
        'return_error_url' => [
            FieldsConfigDictionary::REQUIRED => false,
            FieldsConfigDictionary::VALIDATION => [
                FieldsConfigDictionary::STRING,
                FieldsConfigDictionary::MAXLENGTH_512,
            ],
            FieldsConfigDictionary::FILTER => 'url',
        ],
        /*
         * Transactional panel language.
         * Default is PL
         */
        'language' => [
            FieldsConfigDictionary::REQUIRED => false,
            FieldsConfigDictionary::VALIDATION => [FieldsConfigDictionary::OPTIONS],
            FieldsConfigDictionary::OPTIONS => ['PL', 'EN', 'DE', 'IT', 'ES', 'FR', 'RU'],
        ],
        // Customer email address.
        'email' => [
            FieldsConfigDictionary::REQUIRED => false,
            FieldsConfigDictionary::VALIDATION => [
                FieldsConfigDictionary::STRING,
                FieldsConfigDictionary::MAXLENGTH_64,
            ],
            FieldsConfigDictionary::FILTER => 'mail',
        ],
        // Customer surname.
        'name' => [
            FieldsConfigDictionary::REQUIRED => false,
            FieldsConfigDictionary::VALIDATION => [
                FieldsConfigDictionary::STRING,
                FieldsConfigDictionary::MAXLENGTH_64,
            ],
            FieldsConfigDictionary::FILTER => 'name',
        ],
        // Customer address.
        'address' => [
            FieldsConfigDictionary::REQUIRED => false,
            FieldsConfigDictionary::VALIDATION => [
                FieldsConfigDictionary::STRING,
                FieldsConfigDictionary::MAXLENGTH_64,
            ],
            FieldsConfigDictionary::FILTER => FieldsConfigDictionary::TEXT,
        ],
        // Customer city.
        'city' => [
            FieldsConfigDictionary::REQUIRED => false,
            FieldsConfigDictionary::VALIDATION => [
                FieldsConfigDictionary::STRING,
                FieldsConfigDictionary::MAXLENGTH_32,
            ],
            FieldsConfigDictionary::FILTER => 'name',
        ],
        // Customer postal code.
        'zip' => [
            FieldsConfigDictionary::REQUIRED => false,
            FieldsConfigDictionary::VALIDATION => [FieldsConfigDictionary::STRING, 'maxlength_10'],
            FieldsConfigDictionary::FILTER => FieldsConfigDictionary::TEXT,
        ],
        /*
         * Country code.
         * Alphanumeric, 2 or 3 signs compatible with ISO 3166-1
         */
        'country' => [
            FieldsConfigDictionary::REQUIRED => false,
            FieldsConfigDictionary::VALIDATION => ['country_code'],
        ],
        // Customer phone.
        'phone' => [
            FieldsConfigDictionary::REQUIRED => false,
            FieldsConfigDictionary::VALIDATION => [FieldsConfigDictionary::STRING, 'maxlength_16'],
            FieldsConfigDictionary::FILTER => FieldsConfigDictionary::PHONE,
        ],
        // The parameter indicating acceptance of Terms tpay if it is available on the payee.
        'accept_tos' => [
            FieldsConfigDictionary::REQUIRED => false,
            FieldsConfigDictionary::VALIDATION => [FieldsConfigDictionary::OPTIONS],
            FieldsConfigDictionary::OPTIONS => [0, 1],
        ],
        // Description payees during the transaction.
        'expiration_date' => [
            FieldsConfigDictionary::REQUIRED => false,
            FieldsConfigDictionary::VALIDATION => [
                FieldsConfigDictionary::STRING,
                FieldsConfigDictionary::MAXLENGTH_128,
            ],
        ],
        // Description payees during the transaction.
        'timehash' => [
            FieldsConfigDictionary::REQUIRED => false,
            FieldsConfigDictionary::VALIDATION => [
                FieldsConfigDictionary::STRING,
                FieldsConfigDictionary::MAXLENGTH_128,
            ],
        ],
        // Module/integration name. Used for statistics.
        'module' => [
            FieldsConfigDictionary::REQUIRED => false,
            FieldsConfigDictionary::VALIDATION => [
                FieldsConfigDictionary::STRING,
                FieldsConfigDictionary::MAXLENGTH_32,
            ],
        ],
    ];

    /** List of deprecated parameters */
    const OLD_REQUEST_FIELDS = [
        'kwota' => 'amount',
        'opis' => 'description',
        'grupa' => 'group',
        'wybor' => 'choice',
        'wyn_url' => 'result_url',
        'wyn_email' => 'result_email',
        'opis_sprzed' => 'merchant_description',
        'opis_dodatkowy' => 'custom_description',
        'pow_url' => 'return_url',
        'pow_url_blad' => 'return_error_url',
        'jezyk' => 'language',
        'nazwisko' => 'name',
        'adres' => 'address',
        'miasto' => 'city',
        'kod' => 'zip',
        'kraj' => 'country',
        'telefon' => 'phone',
        'akceptuje_regulamin' => 'accept_tos',
    ];

    const RESPONSE_FIELDS = [
        // The merchant ID assigned by the system tpay
        'id' => [
            FieldsConfigDictionary::REQUIRED => true,
            FieldsConfigDictionary::TYPE => FieldsConfigDictionary::FLOAT,
            FieldsConfigDictionary::VALIDATION => [FieldsConfigDictionary::FLOAT],
        ],
        // The transaction ID assigned by the system tpay
        'tr_id' => [
            FieldsConfigDictionary::REQUIRED => true,
            FieldsConfigDictionary::TYPE => FieldsConfigDictionary::STRING,
            FieldsConfigDictionary::VALIDATION => [FieldsConfigDictionary::STRING],
        ],
        // Date of transaction.
        'tr_date' => [
            FieldsConfigDictionary::REQUIRED => true,
            FieldsConfigDictionary::TYPE => FieldsConfigDictionary::STRING,
            FieldsConfigDictionary::VALIDATION => [FieldsConfigDictionary::STRING],
        ],
        // The secondary parameter to the transaction identification.
        'tr_crc' => [
            FieldsConfigDictionary::REQUIRED => true,
            FieldsConfigDictionary::TYPE => FieldsConfigDictionary::STRING,
            FieldsConfigDictionary::VALIDATION => [FieldsConfigDictionary::STRING],
        ],
        // Transaction amount.
        'tr_amount' => [
            FieldsConfigDictionary::REQUIRED => true,
            FieldsConfigDictionary::TYPE => FieldsConfigDictionary::FLOAT,
            FieldsConfigDictionary::VALIDATION => [FieldsConfigDictionary::FLOAT],
        ],
        // Transaction amount.
        'tr_channel' => [
            FieldsConfigDictionary::REQUIRED => false,
            FieldsConfigDictionary::TYPE => FieldsConfigDictionary::FLOAT,
            FieldsConfigDictionary::VALIDATION => [FieldsConfigDictionary::FLOAT],
        ],
        /*
         * The amount paid for the transaction.
         * Note: Depending on the settings, the amount paid can be different
         * than transactions eg. When the customer does overpayment.
         */
        'tr_paid' => [
            FieldsConfigDictionary::REQUIRED => true,
            FieldsConfigDictionary::TYPE => FieldsConfigDictionary::FLOAT,
            FieldsConfigDictionary::VALIDATION => [FieldsConfigDictionary::FLOAT],
        ],
        // Description of the transaction.
        'tr_desc' => [
            FieldsConfigDictionary::REQUIRED => true,
            FieldsConfigDictionary::TYPE => FieldsConfigDictionary::STRING,
            FieldsConfigDictionary::VALIDATION => [FieldsConfigDictionary::STRING],
        ],
        /*
         * Transaction status: TRUE after successful payment, CHARGEBACK after refund.
         * FALSE and PAID statuses may be obtained in two-step payment acceptance mode.
         * Note: Depending on the settings, the transaction may be correct status,
         * even if the amount paid is different from the amount of the transaction!
         * Eg. If the Seller accepts the overpayment or underpayment threshold is set.
         */
        'tr_status' => [
            FieldsConfigDictionary::REQUIRED => true,
            FieldsConfigDictionary::TYPE => FieldsConfigDictionary::STRING,
            FieldsConfigDictionary::VALIDATION => [FieldsConfigDictionary::OPTIONS],
            FieldsConfigDictionary::OPTIONS => [0, 1, true, false, 'TRUE', 'FALSE', 'PAID', 'CHARGEBACK'],
        ],
        /*
         * Transaction error status.
         * Could have the following values:
         * - none
         * - overpay
         * - surcharge
         */
        'tr_error' => [
            FieldsConfigDictionary::REQUIRED => true,
            FieldsConfigDictionary::TYPE => FieldsConfigDictionary::STRING,
            FieldsConfigDictionary::VALIDATION => [FieldsConfigDictionary::OPTIONS],
            FieldsConfigDictionary::OPTIONS => ['none', 'overpay', 'surcharge'],
        ],
        // Customer email address.
        'tr_email' => [
            FieldsConfigDictionary::REQUIRED => true,
            FieldsConfigDictionary::TYPE => FieldsConfigDictionary::STRING,
            FieldsConfigDictionary::VALIDATION => [FieldsConfigDictionary::EMAIL_LIST],
        ],
        /*
         * The checksum verifies the data sent to the payee.
         * It is built according to the following scheme using the MD5 hash function:
         * MD5(id + tr_id + tr_amount + tr_crc + security code)
         */
        'md5sum' => [
            FieldsConfigDictionary::REQUIRED => true,
            FieldsConfigDictionary::TYPE => FieldsConfigDictionary::STRING,
            FieldsConfigDictionary::VALIDATION => [FieldsConfigDictionary::STRING, 'maxlength_32', 'minlength_32'],
        ],
        /*
         * Transaction marker indicates whether the transaction was executed in test mode:
         * 1 – in test mode
         * 0 – in normal mode
         */
        'test_mode' => [
            FieldsConfigDictionary::REQUIRED => false,
            FieldsConfigDictionary::TYPE => FieldsConfigDictionary::INT,
            FieldsConfigDictionary::VALIDATION => [FieldsConfigDictionary::OPTIONS],
            FieldsConfigDictionary::OPTIONS => [0, 1],
        ],
        /*
         * The parameter is sent only when you use a payment channel or MasterPass or V.me.
         * Could have the following values: „masterpass” or „vme”
         */
        'wallet' => [
            FieldsConfigDictionary::REQUIRED => false,
            FieldsConfigDictionary::TYPE => FieldsConfigDictionary::STRING,
        ],
    ];
}
