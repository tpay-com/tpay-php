<?php

namespace Tpay\OriginApi\Validators\PaymentTypes;

use Tpay\OriginApi\Dictionaries\Payments\BasicFieldsDictionary;
use Tpay\OriginApi\Validators\PaymentTypesInterface;

class PaymentTypeBasic implements PaymentTypesInterface
{
    public function getRequestFields()
    {
        return BasicFieldsDictionary::REQUEST_FIELDS;
    }

    public function getResponseFields()
    {
        return BasicFieldsDictionary::RESPONSE_FIELDS;
    }

    public function getOldRequestFields()
    {
        return BasicFieldsDictionary::OLD_REQUEST_FIELDS;
    }
}
