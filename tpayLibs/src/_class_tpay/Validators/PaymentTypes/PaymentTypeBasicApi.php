<?php

/*
 * Created by tpay.com.
 * Date: 19.06.2017
 * Time: 11:13
 */
namespace tpayLibs\src\_class_tpay\Validators\PaymentTypes;

use tpayLibs\src\_class_tpay\Validators\PaymentTypesInterface;
use tpayLibs\src\Dictionaries\FieldsConfigDictionary;
use tpayLibs\src\Dictionaries\Payments\StandardFieldsDictionary;

class PaymentTypeBasicApi implements PaymentTypesInterface
{

    public function getRequestFields()
    {
        $fields = StandardFieldsDictionary::REQUEST_FIELDS;
        $fields[FieldsConfigDictionary::GROUP][FieldsConfigDictionary::REQUIRED] = true;
        $fields[FieldsConfigDictionary::NAME][FieldsConfigDictionary::REQUIRED] = true;
        return $fields;
    }

    public function getResponseFields()
    {
        return StandardFieldsDictionary::RESPONSE_FIELDS;
    }
}
