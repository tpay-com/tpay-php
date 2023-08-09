<?php

namespace tpayLibs\src\Dictionaries\Payments;

use tpayLibs\src\Dictionaries\FieldsConfigDictionary;

class CardFieldsDictionary
{
    /**
     * List of supported fields for card payment request
     */
    const REQUEST_FIELDS = [
        /**
         * Transaction amount
         */
        FieldsConfigDictionary::AMOUNT => [
            FieldsConfigDictionary::REQUIRED => true,
            FieldsConfigDictionary::VALIDATION => [FieldsConfigDictionary::FLOAT],
        ],
        /**
         * Client name
         */
        'name' => [
            FieldsConfigDictionary::REQUIRED => true,
            FieldsConfigDictionary::VALIDATION => [
                FieldsConfigDictionary::STRING,
                FieldsConfigDictionary::MAXLENGTH_64,
            ],
        ],
        /**
         * Client email
         */
        FieldsConfigDictionary::EMAIL => [
            FieldsConfigDictionary::REQUIRED => true,
            FieldsConfigDictionary::VALIDATION => [
                FieldsConfigDictionary::STRING,
                FieldsConfigDictionary::EMAIL_LIST,
            ],
        ],
        /**
         * Sale description
         */
        'desc' => [
            FieldsConfigDictionary::REQUIRED => true,
            FieldsConfigDictionary::VALIDATION => [
                FieldsConfigDictionary::STRING,
                FieldsConfigDictionary::MAXLENGTH_128,
            ],
        ],
        /**
         * Value from partner system
         */
        FieldsConfigDictionary::ORDER_ID => [
            FieldsConfigDictionary::REQUIRED => false,
            FieldsConfigDictionary::VALIDATION => [
                FieldsConfigDictionary::STRING,
                FieldsConfigDictionary::MAXLENGTH_40,
            ],
        ],
        /**
         * 3ds return url enabled
         */
        'enable_pow_url' => [
            FieldsConfigDictionary::REQUIRED => false,
            FieldsConfigDictionary::VALIDATION => [FieldsConfigDictionary::INT],
        ],
        /**
         * 3ds success return url
         */
        'pow_url' => [
            FieldsConfigDictionary::REQUIRED => false,
            FieldsConfigDictionary::VALIDATION => [FieldsConfigDictionary::STRING],
        ],

        'card' => [
            FieldsConfigDictionary::REQUIRED => false,
            FieldsConfigDictionary::VALIDATION => [FieldsConfigDictionary::STRING],
        ],
        'method' => [
            FieldsConfigDictionary::REQUIRED => true,
            FieldsConfigDictionary::VALIDATION => [FieldsConfigDictionary::STRING],
        ],
        'sign' => [
            FieldsConfigDictionary::REQUIRED => true,
            FieldsConfigDictionary::VALIDATION => [FieldsConfigDictionary::STRING],
        ],
        'api_password' => [
            FieldsConfigDictionary::REQUIRED => true,
            FieldsConfigDictionary::VALIDATION => [FieldsConfigDictionary::STRING],
        ],
        /**
         * 3ds failure return url
         */
        'pow_url_blad' => [
            FieldsConfigDictionary::REQUIRED => false,
            FieldsConfigDictionary::VALIDATION => [FieldsConfigDictionary::STRING],
        ],
        /**
         * language
         */
        'language' => [
            FieldsConfigDictionary::REQUIRED => false,
            FieldsConfigDictionary::VALIDATION => [FieldsConfigDictionary::STRING],
        ],
        /**
         * Sale description
         */
        'currency' => [
            FieldsConfigDictionary::REQUIRED => true,
            FieldsConfigDictionary::VALIDATION => [
                FieldsConfigDictionary::INT,
                'maxlength_3',
            ],
        ],
        /**
         * If this parameter is present, card token will not be generated
         */
        'onetimer' => [
            FieldsConfigDictionary::REQUIRED => false,
            FieldsConfigDictionary::TYPE => FieldsConfigDictionary::BOOLEAN,
            FieldsConfigDictionary::VALIDATION => [FieldsConfigDictionary::BOOLEAN],
        ],
        /**
         * Module/integration name. Used for statistics.
         */
        'module' => BasicFieldsDictionary::REQUEST_FIELDS['module'],
    ];

    /**
     * List of fields available in card payment response
     */
    const RESPONSE_FIELDS = [
        /**
         * Method type
         */
        FieldsConfigDictionary::TYPE => [
            FieldsConfigDictionary::REQUIRED => true,
            FieldsConfigDictionary::TYPE => FieldsConfigDictionary::STRING,
            FieldsConfigDictionary::VALIDATION => [FieldsConfigDictionary::OPTIONS],
            FieldsConfigDictionary::OPTIONS => ['sale', 'refund', 'deregister'],
        ],
        /**
         * Merchant optional value
         */
        FieldsConfigDictionary::ORDER_ID => [
            FieldsConfigDictionary::REQUIRED => true,
            FieldsConfigDictionary::TYPE => FieldsConfigDictionary::STRING,
            FieldsConfigDictionary::VALIDATION => [
                FieldsConfigDictionary::STRING,
                FieldsConfigDictionary::MAXLENGTH_40,
            ],
        ],
        /**
         * Payment status
         */
        'status' => [
            FieldsConfigDictionary::REQUIRED => true,
            FieldsConfigDictionary::TYPE => FieldsConfigDictionary::STRING,
            FieldsConfigDictionary::VALIDATION => [FieldsConfigDictionary::OPTIONS],
            FieldsConfigDictionary::OPTIONS => ['correct', 'declined', 'done'],
        ],
        /**
         * Message checksum
         */
        'sign' => [
            FieldsConfigDictionary::REQUIRED => true,
            FieldsConfigDictionary::TYPE => FieldsConfigDictionary::STRING,
            FieldsConfigDictionary::VALIDATION => [
                FieldsConfigDictionary::STRING,
                FieldsConfigDictionary::MAXLENGTH_128,
                FieldsConfigDictionary::MINLENGTH_40,
            ],
        ],
        /**
         * Created sale/refund id
         */
        'sale_auth' => [
            FieldsConfigDictionary::REQUIRED => true,
            FieldsConfigDictionary::TYPE => FieldsConfigDictionary::STRING,
            FieldsConfigDictionary::VALIDATION => [
                FieldsConfigDictionary::STRING,
                FieldsConfigDictionary::MAXLENGTH_40,
            ],
        ],
        /**
         * Created client token
         */
        'cli_auth' => [
            FieldsConfigDictionary::REQUIRED => false,
            FieldsConfigDictionary::TYPE => FieldsConfigDictionary::STRING,
            FieldsConfigDictionary::VALIDATION => [
                FieldsConfigDictionary::STRING,
                FieldsConfigDictionary::MAXLENGTH_40,
            ],
        ],
        /**
         * Date of accounting/deregistering
         */
        'date' => [
            FieldsConfigDictionary::REQUIRED => true,
            FieldsConfigDictionary::TYPE => FieldsConfigDictionary::STRING,
            FieldsConfigDictionary::VALIDATION => [FieldsConfigDictionary::STRING],
        ],
        /**
         * carry value of 1 if account has test mode, otherwise parameter not sent
         */
        FieldsConfigDictionary::TEST_MODE => [
            FieldsConfigDictionary::REQUIRED => false,
            FieldsConfigDictionary::TYPE => FieldsConfigDictionary::INT,
            FieldsConfigDictionary::VALIDATION => [FieldsConfigDictionary::INT],
            FieldsConfigDictionary::OPTIONS => [0, 1],
        ],
        /**
         * shortcut for client card number, eg ****5678
         */
        'card' => [
            FieldsConfigDictionary::REQUIRED => true,
            FieldsConfigDictionary::TYPE => FieldsConfigDictionary::STRING,
            FieldsConfigDictionary::VALIDATION => [FieldsConfigDictionary::STRING, 'maxlength_8', 'minlength_8'],
        ],
        /**
         * shortcut for client card number, eg ****5678
         */
        'amount' => [
            FieldsConfigDictionary::REQUIRED => true,
            FieldsConfigDictionary::TYPE => FieldsConfigDictionary::FLOAT,
            FieldsConfigDictionary::VALIDATION => [FieldsConfigDictionary::FLOAT],
        ],
        /**
         * payment currency
         */
        FieldsConfigDictionary::CURRENCY => [
            FieldsConfigDictionary::REQUIRED => true,
            FieldsConfigDictionary::TYPE => FieldsConfigDictionary::INT,
            FieldsConfigDictionary::VALIDATION => [FieldsConfigDictionary::FLOAT, 'maxlength_3', 'minlength_3'],
        ],
        'reason' => [
            FieldsConfigDictionary::REQUIRED => false,
            FieldsConfigDictionary::TYPE => FieldsConfigDictionary::STRING,
            FieldsConfigDictionary::VALIDATION => [FieldsConfigDictionary::STRING],
        ],
    ];
}
