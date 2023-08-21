<?php

namespace Tpay\Validators\VariableTypes;

use Tpay\Utilities\TException;
use Tpay\Validators\VariableTypesInterface;

class StringType implements VariableTypesInterface
{
    public function validateType($value, $name)
    {
        if (!is_string($value)) {
            throw new TException(sprintf('Field "%s" must be a string, type given: '.gettype($value), $name));
        }
    }
}
