<?php

namespace Tpay\OriginApi\Validators\VariableTypes;

use Tpay\OriginApi\Utilities\TException;
use Tpay\OriginApi\Validators\VariableTypesInterface;

class IntType implements VariableTypesInterface
{
    public function validateType($value, $name)
    {
        if (!is_int($value)) {
            throw new TException(sprintf('Field "%s" must be an integer', $name));
        }
        if ($value <= 0) {
            throw new TException(sprintf('Field "%s" must be higher than zero', $name));
        }
    }
}
