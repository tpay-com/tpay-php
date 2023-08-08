<?php

namespace tpayLibs\src\_class_tpay\Validators\PaymentTypes;

use tpayLibs\src\_class_tpay\Validators\PaymentTypesInterface;
use tpayLibs\src\Dictionaries\Payments\CardFieldsDictionary;

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
