<?php

namespace Tpay\Validators\VariableTypes;

use Tpay\Utilities\TException;
use Tpay\Validators\VariableTypesInterface;

class DescriptionType implements VariableTypesInterface
{
    public function validateType($value, $name)
    {
        if (0 !== preg_match('/[^a-zA-Z0-9 ]/', $value)) {
            throw new TException(
                sprintf('Field "%s" contains invalid characters. Only a-z A-Z 0-9 and space', $name)
            );
        }
    }
}
