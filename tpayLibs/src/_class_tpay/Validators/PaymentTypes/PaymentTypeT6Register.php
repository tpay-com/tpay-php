<?php

namespace tpayLibs\src\_class_tpay\Validators\PaymentTypes;

use tpayLibs\src\_class_tpay\Validators\PaymentTypesInterface;
use tpayLibs\src\Dictionaries\Payments\BlikFieldsDictionary;

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
