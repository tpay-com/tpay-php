<?php

/*
 * Created by tpay.com
 */

namespace tpayLibs\src\_class_tpay\Validators;


use tpayLibs\src\_class_tpay\Utilities\TException;
use tpayLibs\src\_class_tpay\Utilities\Util;
use tpayLibs\src\_class_tpay\Validators\VariableTypes\VariableTypesValidator;
use tpayLibs\src\Dictionaries\FieldsConfigDictionary;
use tpayLibs\src\Dictionaries\FieldValueFilters;

trait FieldsConfigValidator
{
    use AccessConfigValidator;
    use FieldsValidator;
    use ResponseFieldsValidator;

    private $requestFields;
    private $dirPath;

    /**
     * FieldsConfigValidator payment config
     *
     * @param  object $paymentType
     * @param  array $config
     * @return array
     *
     * @throws TException
     */
    public function validateConfig($paymentType, $config)
    {
        if (!is_array($config)) {
            throw new TException('Config is not an array');
        } else {
            if (count($config) === 0) {
                throw new TException('Config is empty');
            }
        }
        $this->dirPath = $_SERVER["DOCUMENT_ROOT"] . '/' . str_replace("\\", '/', __NAMESPACE__);
        $ready = array();
        $this->setPaymentFields($paymentType);
        $config = $this->checkDeprecatedFields($paymentType, $config);
        foreach ($config as $key => $value) {
            $ready[$key] = $this->isValidField($key, $value);
        }
        $this->isSetRequiredPaymentFields($ready);

        return $ready;
    }

    /**
     * Check and rename deprecated parameters
     * @param object $paymentType payment type
     * @param array $config
     * @return array $config
     */

    private function checkDeprecatedFields($paymentType, $config)
    {
        if (method_exists($paymentType, 'getOldRequestFields')) {
            $deprecatedList = $paymentType->getOldRequestFields();
            foreach ($config as $key => $value) {
                if (array_key_exists($key, $deprecatedList)) {
                    trigger_error('Use of deprecated parameter: ' . $key, E_USER_DEPRECATED);
                    unset($config[$key]);
                    $config[$deprecatedList[$key]] = $value;
                }
            }
        }
        return $config;
    }

    /**
     * Set payment fields dictionary for validation
     * @param object $paymentType payment type
     * @param bool $notResp is it not response value
     */

    public function setPaymentFields($paymentType, $notResp = true)
    {
        $this->requestFields = $notResp ? $paymentType->getRequestFields() : $paymentType->getResponseFields();
        $this->requestFields['json'][FieldsConfigDictionary::REQUIRED] = false;
        $this->requestFields['json'][FieldsConfigDictionary::VALIDATION] = array(FieldsConfigDictionary::BOOLEAN);
    }

    /**
     * Check one field form
     * @param string $name field name
     * @param mixed $value field value
     * @return bool
     */

    private function isValidField($name, $value)
    {
        $this->checkFieldName($name, $this->requestFields);
        $fieldConfig = $this->requestFields[$name];
        if ($fieldConfig[FieldsConfigDictionary::REQUIRED] === false && (is_null($value) || $value === false)) {
            return true;
        }
        $this->validateFields($name, $value, $fieldConfig);
        return (isset($fieldConfig[FieldsConfigDictionary::FILTER])) ? $this->filterValues($value, $fieldConfig, $name)
            : $value;

    }

    /**
     * @param $name
     * @param $requestFields
     * @throws TException
     */
    private function checkFieldName($name, $requestFields)
    {
        if (!is_string($name)) {
            throw new TException('Invalid field name');
        }
        if (!array_key_exists($name, $requestFields)) {
            throw new TException('Field with this name is not supported ' . $name);
        }
    }

    /**
     * @param $name
     * @param $value
     * @param $fieldConfig
     * @throws TException
     */
    private function validateFields($name, $value, $fieldConfig)
    {
        if (isset($fieldConfig[FieldsConfigDictionary::VALIDATION]) === true) {
            foreach ($fieldConfig[FieldsConfigDictionary::VALIDATION] as $validator) {
                if (strpos($validator, 'maxlength') === 0) {
                    $this->validateMaxLength($value, $validator, $name);
                } elseif (strpos($validator, 'minlength!') === 0) {
                    $this->validateMinLength($value, $validator, $name);
                } elseif ($validator === FieldsConfigDictionary::OPTIONS) {
                    $this->validateOptions($value, $fieldConfig[FieldsConfigDictionary::OPTIONS], $name);
                } else {
                    new VariableTypesValidator($validator, $value, $name);
                }
            }
        }
    }

    /**
     * RegExp filter for fields validation
     * @param string $value
     * @param array $fieldConfig
     * @param $name
     * @return string
     * @throws TException
     */
    private function filterValues($value, $fieldConfig, $name)
    {
        $filters = FieldValueFilters::FILTERS;


        $filterName = $fieldConfig[FieldsConfigDictionary::FILTER];
        if (array_key_exists($filterName, $filters)) {
            $filteredValue = preg_replace($filters[$filterName], '', $value, -1,
                $count);
            if ($count > 0) {
                Util::log('Variable Warning!', 'Unsupported signs has been trimmed from '
                    . $value . ' to ' . $filteredValue . ' in field ' . $name);
            }
            return $filteredValue;
        }
        if ((($filterName === 'mail') && !filter_var($value, FILTER_VALIDATE_EMAIL))
            ||
            (($filterName === 'url') && !((preg_match('/http:/', $value)) || preg_match('/https:/', $value)))
        ) {
            throw new TException(
                sprintf('Value of field "%s" contains illegal characters. Value: ' . $value, $name)
            );
        }


        return $value;
    }

    /**
     * Check if all required fields isset in config
     *
     * @param array $config
     *
     * @throws TException
     */
    private function isSetRequiredPaymentFields($config)
    {
        $missing = array();

        foreach ($this->requestFields as $fieldName => $field) {
            if ($field[FieldsConfigDictionary::REQUIRED] === true && !isset($config[$fieldName])) {
                $missing[] = $fieldName;
            }
        }
        if (count($missing) !== 0) {
            throw new TException(sprintf('Missing mandatory fields: %s', implode(',', $missing)));
        }
    }
}
