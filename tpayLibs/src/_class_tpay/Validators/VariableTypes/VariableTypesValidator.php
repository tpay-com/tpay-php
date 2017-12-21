<?php

/*
 * Created by tpay.com.
 * Date: 26.06.2017
 * Time: 12:28
 */

namespace tpayLibs\src\_class_tpay\Validators\VariableTypes;

use tpayLibs\src\_class_tpay\Utilities\TException;
use tpayLibs\src\Dictionaries\FieldsConfigDictionary;

class VariableTypesValidator
{


    public function __construct($type, $value, $name)
    {
        $this->validateType($type, $value, $name);
    }

    /**
     * @param string $type
     * @param $value
     * @param string $name
     * @throws TException
     */
    private function validateType($type, $value, $name)
    {
        $a = [
            FieldsConfigDictionary::FLOAT          => new FloatType(),
            FieldsConfigDictionary::STRING         => new StringType(),
            FieldsConfigDictionary::INT            => new IntType(),
            FieldsConfigDictionary::EMAIL_LIST     => new EmailListType(),
            FieldsConfigDictionary::ARR            => new ArrayType(),
            FieldsConfigDictionary::BOOLEAN        => new BooleanType(),
            FieldsConfigDictionary::CUSTOM_DESCRIPTION => new DescriptionType(),
            'CountryCode'                          => new CountryCodeType(),
        ];
        if (array_key_exists($type, $a)) {
            foreach ($a as $key => $value2) {
                if ($key === $type) {
                    $value2->validateType($value, $name);
                }
            }
        }
    }
}
