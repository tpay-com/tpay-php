<?php

namespace Tpay\OriginApi\Validators\PaymentTypes;

use Tpay\OriginApi\Dictionaries\Payments\CardDeregisterFieldsDictionary;
use Tpay\OriginApi\Validators\PaymentTypesInterface;

class PaymentTypeCardDeregister implements PaymentTypesInterface
{
    public function getRequestFields()
    {
        return CardDeregisterFieldsDictionary::REQUEST_FIELDS;
    }

    public function getResponseFields()
    {
        return CardDeregisterFieldsDictionary::RESPONSE_FIELDS;
    }
}
