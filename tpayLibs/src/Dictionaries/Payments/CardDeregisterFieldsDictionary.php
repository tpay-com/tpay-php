<?php

namespace tpayLibs\src\Dictionaries\Payments;

use tpayLibs\src\Dictionaries\FieldsConfigDictionary;

class CardDeregisterFieldsDictionary
{
    /**
     * List of fields available in card deregistration
     */
    const REQUEST_FIELDS = [
        /**
         * client authorization ID, sent if oneTimer option is not set
         * when creating client and client has not been deregistered (himFieldsConfigDictionary or by api)
         */
        'cli_auth' => [
            FieldsConfigDictionary::REQUIRED => true,
            FieldsConfigDictionary::TYPE => FieldsConfigDictionary::STRING,
            FieldsConfigDictionary::VALIDATION => [
                FieldsConfigDictionary::STRING,
                FieldsConfigDictionary::MAXLENGTH_40,
                FieldsConfigDictionary::MINLENGTH_40,
            ],
        ],
        /**
         * carry value of 1 if account has test mode, otherwise parameter not sent
         */
        FieldsConfigDictionary::LANGUAGE => [
            FieldsConfigDictionary::REQUIRED => false,
            FieldsConfigDictionary::TYPE => FieldsConfigDictionary::STRING,
            FieldsConfigDictionary::VALIDATION => [FieldsConfigDictionary::STRING],
        ],
        /**
         * Message checksum
         */
        'sign' => [
            FieldsConfigDictionary::REQUIRED => true,
            FieldsConfigDictionary::TYPE => FieldsConfigDictionary::STRING,
            FieldsConfigDictionary::VALIDATION => [
                FieldsConfigDictionary::STRING,
                'maxlength_128',
                FieldsConfigDictionary::MINLENGTH_40,
            ],
        ],
    ];

    const RESPONSE_FIELDS = [
        /**
         * Method type
         */
        FieldsConfigDictionary::TYPE => [
            FieldsConfigDictionary::REQUIRED => true,
            FieldsConfigDictionary::TYPE => FieldsConfigDictionary::STRING,
            FieldsConfigDictionary::VALIDATION => [FieldsConfigDictionary::OPTIONS],
            FieldsConfigDictionary::OPTIONS => ['deregister'],
        ],
        /**
         * client authorization ID, sent if oneTimer option is not set
         * when creating client and client has not been deregistered (himFieldsConfigDictionary or by api)
         */
        'cli_auth' => [
            FieldsConfigDictionary::REQUIRED => true,
            FieldsConfigDictionary::TYPE => FieldsConfigDictionary::STRING,
            FieldsConfigDictionary::VALIDATION => [
                FieldsConfigDictionary::STRING,
                FieldsConfigDictionary::MAXLENGTH_40,
                FieldsConfigDictionary::MINLENGTH_40,
            ],
        ],
        /**
         * carry value of 1 if account has test mode, otherwise parameter not sent
         */
        FieldsConfigDictionary::TEST_MODE => [
            FieldsConfigDictionary::REQUIRED => false,
            FieldsConfigDictionary::TYPE => FieldsConfigDictionary::INT,
            FieldsConfigDictionary::VALIDATION => [FieldsConfigDictionary::INT],
        ],
        /**
         * Date of accounting/deregistering
         */
        'date' => [
            FieldsConfigDictionary::REQUIRED => true,
            FieldsConfigDictionary::TYPE => FieldsConfigDictionary::STRING,
            FieldsConfigDictionary::VALIDATION => [FieldsConfigDictionary::STRING],
            FieldsConfigDictionary::FILTER => 'date',
        ],
        /**
         * Message checksum
         */
        'sign' => self::REQUEST_FIELDS['sign'],
    ];
}
