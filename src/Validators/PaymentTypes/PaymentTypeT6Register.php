<?php

namespace Tpay\OriginApi\Validators\PaymentTypes;

use Tpay\OriginApi\Dictionaries\Payments\BlikFieldsDictionary;
use Tpay\OriginApi\Validators\PaymentTypesInterface;

class PaymentTypeT6Register implements PaymentTypesInterface
{
    public function getRequestFields()
    {
        return BlikFieldsDictionary::REQUEST_FIELDS;
    }

    public function getResponseFields() {}
}
