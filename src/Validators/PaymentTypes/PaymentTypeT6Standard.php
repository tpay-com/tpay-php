<?php

namespace Tpay\Validators\PaymentTypes;

use Tpay\Dictionaries\FieldsConfigDictionary;
use Tpay\Dictionaries\Payments\BlikFieldsDictionary;
use Tpay\Validators\PaymentTypesInterface;

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
