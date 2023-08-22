<?php

namespace Tpay\OriginApi\Validators\VariableTypes;

use Tpay\OriginApi\Dictionaries\FieldsConfigDictionary;
use Tpay\OriginApi\Utilities\TException;

class VariableTypesValidator
{
    public function __construct($type, $value, $name)
    {
        $this->validateType($type, $value, $name);
    }

    /**
     * @param string $type
     * @param mixed  $value
     * @param string $name
     *
     * @throws TException
     */
    private function validateType($type, $value, $name)
    {
        $a = [
            FieldsConfigDictionary::FLOAT => new FloatType(),
            FieldsConfigDictionary::STRING => new StringType(),
            FieldsConfigDictionary::INT => new IntType(),
            FieldsConfigDictionary::EMAIL_LIST => new EmailListType(),
            FieldsConfigDictionary::ARR => new ArrayType(),
            FieldsConfigDictionary::BOOLEAN => new BooleanType(),
            FieldsConfigDictionary::CUSTOM_DESCRIPTION => new DescriptionType(),
            'CountryCode' => new CountryCodeType(),
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
