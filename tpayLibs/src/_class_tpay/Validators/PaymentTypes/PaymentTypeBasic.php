<?php

/*
 * Created by tpay.com.
 * Date: 19.06.2017
 * Time: 11:13
 */
namespace tpayLibs\src\_class_tpay\Validators\PaymentTypes;

use tpayLibs\src\_class_tpay\Validators\PaymentTypesInterface;
use tpayLibs\src\Dictionaries\Payments\StandardFieldsDictionary;

class PaymentTypeBasic implements PaymentTypesInterface
{

    public function getRequestFields()
    {
        return StandardFieldsDictionary::REQUEST_FIELDS;
    }

    public function getResponseFields()
    {
        return StandardFieldsDictionary::RESPONSE_FIELDS;
    }
}
