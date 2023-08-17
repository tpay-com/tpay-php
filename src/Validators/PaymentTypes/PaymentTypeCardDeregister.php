<?php

namespace Tpay\Validators\PaymentTypes;

use Tpay\Dictionaries\Payments\CardDeregisterFieldsDictionary;
use Tpay\Validators\PaymentTypesInterface;

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
