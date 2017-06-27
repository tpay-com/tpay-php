<?php

/*
 * Created by tpay.com.
 * Date: 19.06.2017
 * Time: 14:39
 */
namespace tpayLibs\src\_class_tpay\Validators\VariableTypes;

use tpayLibs\src\_class_tpay\Utilities\TException;
use tpayLibs\src\_class_tpay\Validators\VariableTypesInterface;

class BooleanType implements VariableTypesInterface
{

    public function validateType($value, $name)
    {
        if (!is_bool($value)) {
            throw new TException(sprintf('Field "%s" must be a boolean', $name));
        }
    }
}
