<?php

namespace tpayLibs\src\_class_tpay\Validators\VariableTypes;

use tpayLibs\src\_class_tpay\Utilities\TException;
use tpayLibs\src\_class_tpay\Validators\VariableTypesInterface;

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
