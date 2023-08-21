<?php

namespace Tpay\Validators\PaymentTypes;

use Tpay\Dictionaries\Payments\CardFieldsDictionary;
use Tpay\Validators\PaymentTypesInterface;

class PaymentTypeCard implements PaymentTypesInterface
{
    public function getRequestFields()
    {
        return CardFieldsDictionary::REQUEST_FIELDS;
    }

    public function getResponseFields()
    {
        return CardFieldsDictionary::RESPONSE_FIELDS;
    }
}
