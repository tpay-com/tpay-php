<?php

namespace Tpay\Validators;

use Tpay\Dictionaries\FieldsConfigDictionary;
use Tpay\Utilities\TException;
use Tpay\Utilities\Util;

trait ResponseFieldsValidator
{
    /**
     * Check all variables required in response
     * Parse variables to valid types
     *
     * @param object $paymentType
     *
     * @throws TException
     *
     * @return array
     */
    public function getResponse($paymentType)
    {
        $ready = [];
        $missed = [];

        $responseFields = $paymentType->getResponseFields();

        foreach ($responseFields as $fieldName => $field) {
            if (false === Util::post($fieldName, FieldsConfigDictionary::STRING)) {
                if (true === $field[FieldsConfigDictionary::REQUIRED]) {
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
