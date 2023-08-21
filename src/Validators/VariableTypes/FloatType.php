<?php

namespace Tpay\OriginApi\Validators\VariableTypes;

use Tpay\OriginApi\Utilities\TException;
use Tpay\OriginApi\Validators\VariableTypesInterface;

class FloatType implements VariableTypesInterface
{
    public function validateType($value, $name)
    {
        if (!is_numeric($value) && !is_int($value)) {
            throw new TException(sprintf('Field "%s" must be a float|int number', $name));
        }
        if ($value < 0) {
            throw new TException(sprintf('Field "%s" must be higher than zero', $name));
        }
    }
}
