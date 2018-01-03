<?php

/*
 * Created by tpay.com.
 * Date: 20.06.2017
 * Time: 17:49
 */

namespace tpayLibs\src\_class_tpay\Validators;


use tpayLibs\src\_class_tpay\Utilities\TException;
use tpayLibs\src\_class_tpay\Utilities\Util;
use tpayLibs\src\Dictionaries\FieldsConfigDictionary;

trait ResponseFieldsValidator
{
    /**
     * Check all variables required in response
     * Parse variables to valid types
     *
     * @param object $paymentType
     *
     * @return array
     * @throws TException
     */
    public function getResponse($paymentType)
    {
        $ready = array();
        $missed = array();

        $responseFields = $paymentType->getResponseFields();

        foreach ($responseFields as $fieldName => $field) {
            if (Util::post($fieldName, FieldsConfigDictionary::STRING) === false) {
                if ($field[FieldsConfigDictionary::REQUIRED] === true) {
                    $missed[] = $fieldName;
                }
            } else {
                $val = Util::post($fieldName, FieldsConfigDictionary::STRING);
                switch ($field[FieldsConfigDictionary::TYPE]) {
                    case FieldsConfigDictionary::STRING:
                        $val = (string)$val;
                        break;
                    case FieldsConfigDictionary::INT:
                        $val = (int)$val;
                        break;
                    case FieldsConfigDictionary::FLOAT:
                        $val = (float)$val;
                        break;
                    case FieldsConfigDictionary::ARR:
                        $val = (array)$val;
                        break;
                    default:
                        throw new TException(sprintf('unknown field type in getResponse - field name= %s', $fieldName));
                }
                $ready[$fieldName] = $val;
            }
        }

        if (count($missed) > 0) {
            throw new TException(sprintf('Missing fields in tpay response: %s', implode(',', $missed)));
        }
        $this->setPaymentFields($paymentType, false);
        foreach ($ready as $fieldName => $fieldVal) {
            $this->isValidField($fieldName, $fieldVal);
        }

        return $ready;
    }
}
