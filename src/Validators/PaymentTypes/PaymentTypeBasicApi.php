<?php

namespace Tpay\Validators\PaymentTypes;

use Tpay\Dictionaries\FieldsConfigDictionary;
use Tpay\Dictionaries\Payments\BasicFieldsDictionary;
use Tpay\Validators\PaymentTypesInterface;

class PaymentTypeBasicApi implements PaymentTypesInterface
{
    public function getRequestFields()
    {
        $fields = BasicFieldsDictionary::REQUEST_FIELDS;
        $fields[FieldsConfigDictionary::GROUP][FieldsConfigDictionary::REQUIRED] = true;
        $fields[FieldsConfigDictionary::NAME][FieldsConfigDictionary::REQUIRED] = true;
        return $fields;
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
