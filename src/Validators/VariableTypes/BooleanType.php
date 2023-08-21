<?php

namespace Tpay\OriginApi\Validators\VariableTypes;

use Tpay\OriginApi\Utilities\TException;
use Tpay\OriginApi\Validators\VariableTypesInterface;

class BooleanType implements VariableTypesInterface
{
    public function validateType($value, $name)
    {
        if (!is_bool($value)) {
            throw new TException(sprintf('Field "%s" must be a boolean', $name));
        }
    }
}
