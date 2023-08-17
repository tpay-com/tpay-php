<?php

namespace Tpay\Validators\VariableTypes;

use Tpay\Utilities\TException;
use Tpay\Validators\VariableTypesInterface;

class EmailListType implements VariableTypesInterface
{
    public function validateType($value, $name)
    {
        if (!is_string($value)) {
            throw new TException(sprintf('Field "%s" must be a string', $name));
        }
        $emails = explode(',', $value);
        foreach ($emails as $email) {
            if (false === filter_var($email, FILTER_VALIDATE_EMAIL) && strlen($email) > 0) {
                throw new TException(
                    sprintf('Field "%s" contains invalid email address', $name)
                );
            }
        }
    }
}
