<?php

namespace Tpay\OriginApi\Validators\PaymentTypes;

use Tpay\OriginApi\Dictionaries\Payments\CardFieldsDictionary;
use Tpay\OriginApi\Validators\PaymentTypesInterface;

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
