<?php

namespace Tpay\Validators\PaymentTypes;

use Tpay\Dictionaries\FieldsConfigDictionary;
use Tpay\Dictionaries\Payments\BlikFieldsDictionary;
use Tpay\Validators\PaymentTypesInterface;

class PaymentTypeBlikAlias implements PaymentTypesInterface
{
    public function getRequestFields()
    {
        $fields = BlikFieldsDictionary::REQUEST_FIELDS;
        $fields['code'][FieldsConfigDictionary::REQUIRED] = false;
        return $fields;
    }

    public function getResponseFields()
    {
        return BlikFieldsDictionary::ALIAS_RESPONSE_FIELDS;
    }
}
