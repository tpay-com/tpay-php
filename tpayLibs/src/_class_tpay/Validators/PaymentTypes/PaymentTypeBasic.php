<?php

namespace tpayLibs\src\_class_tpay\Validators\PaymentTypes;

use tpayLibs\src\_class_tpay\Validators\PaymentTypesInterface;
use tpayLibs\src\Dictionaries\Payments\BasicFieldsDictionary;

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
