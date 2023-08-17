<?php

namespace Tpay\Validators\PaymentTypes;

use Tpay\Dictionaries\Payments\BlikFieldsDictionary;
use Tpay\Validators\PaymentTypesInterface;

class PaymentTypeT6Register implements PaymentTypesInterface
{
    public function getRequestFields()
    {
        return BlikFieldsDictionary::REQUEST_FIELDS;
    }

    public function getResponseFields()
    {
        return null;
    }
}
