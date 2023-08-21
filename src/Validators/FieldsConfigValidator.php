<?php

namespace Tpay\OriginApi\Validators;

use Tpay\OriginApi\Dictionaries\FieldsConfigDictionary;
use Tpay\OriginApi\Dictionaries\FieldValueFilters;
use Tpay\OriginApi\Utilities\TException;
use Tpay\OriginApi\Utilities\Util;
use Tpay\OriginApi\Validators\VariableTypes\VariableTypesValidator;

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
     * @param object $paymentType
     * @param array  $config
     *
     * @throws TException
     *
     * @return array
     */
    public function validateConfig($paymentType, $config)
    {
        if (!is_array($config)) {
            throw new TException('Config is not an array');
        }
        if (0 === count($config)) {
            throw new TException('Config is empty');
        }

        $this->dirPath = $_SERVER['DOCUMENT_ROOT'].'/'.str_replace('\\', '/', __NAMESPACE__);
        $ready = [];
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
     *
     * @param object $paymentType payment type
     * @param array  $config
     *
     * @return array $config
     */
    private function checkDeprecatedFields($paymentType, $config)
    {
        if (method_exists($paymentType, 'getOldRequestFields')) {
            $deprecatedList = $paymentType->getOldRequestFields();
            foreach ($config as $key => $value) {
                if (array_key_exists($key, $deprecatedList)) {
                    trigger_error('Use of deprecated parameter: '.$key, E_USER_DEPRECATED);
                    unset($config[$key]);
                    $config[$deprecatedList[$key]] = $value;
                }
            }
        }
        return $config;
    }

    /**
     * Set payment fields dictionary for validation
     *
     * @param object $paymentType payment type
     * @param bool   $notResp     is it not response value
     */
    public function setPaymentFields($paymentType, $notResp = true)
    {
        $this->requestFields = $notResp ? $paymentType->getRequestFields() : $paymentType->getResponseFields();
        $this->requestFields['json'][FieldsConfigDictionary::REQUIRED] = false;
        $this->requestFields['json'][FieldsConfigDictionary::VALIDATION] = [FieldsConfigDictionary::BOOLEAN];
    }

    /**
     * Check one field form
     *
     * @param string $name  field name
     * @param mixed  $value field value
     *
     * @return bool
     */
    private function isValidField($name, $value)
    {
        $this->checkFieldName($name, $this->requestFields);
        $fieldConfig = $this->requestFields[$name];
        if (false === $fieldConfig[FieldsConfigDictionary::REQUIRED] && (is_null($value) || false === $value)) {
            return true;
        }
        $this->validateFields($name, $value, $fieldConfig);
        return (isset($fieldConfig[FieldsConfigDictionary::FILTER])) ? $this->filterValues($value, $fieldConfig, $name)
            : $value;
    }

    /**
     * @throws TException
     */
    private function checkFieldName($name, $requestFields)
    {
        if (!is_string($name)) {
            throw new TException('Invalid field name');
        }
        if (!array_key_exists($name, $requestFields)) {
            throw new TException('Field with this name is not supported '.$name);
        }
    }

    /**
     * @throws TException
     */
    private function validateFields($name, $value, $fieldConfig)
    {
        if (true === isset($fieldConfig[FieldsConfigDictionary::VALIDATION])) {
            foreach ($fieldConfig[FieldsConfigDictionary::VALIDATION] as $validator) {
                if (0 === strpos($validator, 'maxlength')) {
                    $this->validateMaxLength($value, $validator, $name);
                } elseif (0 === strpos($validator, 'minlength!')) {
                    $this->validateMinLength($value, $validator, $name);
                } elseif (FieldsConfigDictionary::OPTIONS === $validator) {
                    $this->validateOptions($value, $fieldConfig[FieldsConfigDictionary::OPTIONS], $name);
                } else {
                    new VariableTypesValidator($validator, $value, $name);
                }
            }
        }
    }

    /**
     * RegExp filter for fields validation
     *
     * @param string $value
     * @param array  $fieldConfig
     *
     * @throws TException
     *
     * @return string
     */
    private function filterValues($value, $fieldConfig, $name)
    {
        $filters = FieldValueFilters::FILTERS;

        $filterName = $fieldConfig[FieldsConfigDictionary::FILTER];
        if (array_key_exists($filterName, $filters)) {
            $filteredValue = preg_replace(
                $filters[$filterName],
                '',
                $value,
                -1,
                $count
            );
            if ($count > 0) {
                Util::log('Variable Warning!', 'Unsupported signs has been trimmed from '
                    .$value.' to '.$filteredValue.' in field '.$name);
            }
            return $filteredValue;
        }
        if ((('mail' === $filterName) && !filter_var($value, FILTER_VALIDATE_EMAIL))
            || (('url' === $filterName) && !((preg_match('/http:/', $value)) || preg_match('/https:/', $value)))
        ) {
            throw new TException(
                sprintf('Value of field "%s" contains illegal characters. Value: '.$value, $name)
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
        $missing = [];

        foreach ($this->requestFields as $fieldName => $field) {
            if (true === $field[FieldsConfigDictionary::REQUIRED] && !isset($config[$fieldName])) {
                $missing[] = $fieldName;
            }
        }
        if (0 !== count($missing)) {
            throw new TException(sprintf('Missing mandatory fields: %s', implode(',', $missing)));
        }
    }
}
