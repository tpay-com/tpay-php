<?php

namespace Tpay\Validators\VariableTypes;

use Tpay\Utilities\TException;
use Tpay\Validators\VariableTypesInterface;

class ArrayType implements VariableTypesInterface
{
    public function validateType($value, $name)
    {
        if (!is_array($value)) {
            throw new TException(sprintf('Field "%s" must be an array', $name));
        }
        if (count($value) <= 0) {
            throw new TException(sprintf('Array "%s" must not be empty', $name));
        }
    }
}
