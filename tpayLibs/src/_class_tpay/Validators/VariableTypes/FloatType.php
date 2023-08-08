<?php

namespace tpayLibs\src\_class_tpay\Validators\VariableTypes;

use tpayLibs\src\_class_tpay\Utilities\TException;
use tpayLibs\src\_class_tpay\Validators\VariableTypesInterface;

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
