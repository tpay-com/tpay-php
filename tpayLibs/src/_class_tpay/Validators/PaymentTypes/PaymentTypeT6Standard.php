<?php

namespace tpayLibs\src\_class_tpay\Validators\PaymentTypes;

use tpayLibs\src\_class_tpay\Validators\PaymentTypesInterface;
use tpayLibs\src\Dictionaries\FieldsConfigDictionary;
use tpayLibs\src\Dictionaries\Payments\BlikFieldsDictionary;

class PaymentTypeT6Standard implements PaymentTypesInterface
{
    public function getRequestFields()
    {
        $fields = BlikFieldsDictionary::REQUEST_FIELDS;
        $fields['alias'][FieldsConfigDictionary::REQUIRED] = false;
        return $fields;
    }

    public function getResponseFields()
    {
        return null;
    }
}
