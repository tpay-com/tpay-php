<?php

namespace Tpay\OriginApi\Validators\VariableTypes;

use Tpay\OriginApi\Dictionaries\ISO_codes\CountryCodesDictionary;
use Tpay\OriginApi\Utilities\TException;
use Tpay\OriginApi\Validators\VariableTypesInterface;

class CountryCodeType implements VariableTypesInterface
{
    public function validateType($value, $name)
    {
        if (!is_string($value)
            || (2 !== strlen($value) && 3 !== strlen($value))
            || (!in_array($value, CountryCodesDictionary::CODES))
        ) {
            throw new TException(
                sprintf('Field "%s" has invalid country code', $name)
            );
        }
    }
}
