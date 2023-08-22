<?php

namespace Tpay\OriginApi\Validators;

use Tpay\OriginApi\Dictionaries\ISO_codes\CurrencyCodesDictionary;
use Tpay\OriginApi\Dictionaries\Localization\CardPaymentLanguagesDictionary;
use Tpay\OriginApi\Utilities\TException;

trait FieldsValidator
{
    /**
     * FieldsConfigValidator card currency code
     *
     * @param string $currency
     *
     * @throws TException
     *
     * @return int
     */
    public function validateCardCurrency($currency)
    {
        if (strlen($currency) > 3 || strlen($currency) < 2) {
            throw new TException('Currency is invalid.');
        }

        switch (gettype($currency)) {
            case 'string':
                if (in_array($currency, CurrencyCodesDictionary::CODES)) {
                    $currency = array_search($currency, CurrencyCodesDictionary::CODES);
                } elseif (array_key_exists((int) $currency, CurrencyCodesDictionary::CODES)) {
                    $currency = (int) $currency;
                } else {
                    throw new TException(sprintf('Currency %s is not supported or invalid.', $currency));
                }

                break;
            case 'integer':
                if (!array_key_exists($currency, CurrencyCodesDictionary::CODES)) {
                    throw new TException(sprintf('Currency %s is not supported or invalid.', $currency));
                }
                break;
            default:
                throw new TException(sprintf('Currency variable type %s not supported.', gettype($currency)));
        }

        return $currency;
    }

    /**
     * FieldsConfigValidator card payment language
     *
     * @param string $language
     *
     * @throws TException
     *
     * @return string
     */
    public function validateCardLanguage($language)
    {
        if (!is_string($language)) {
            throw new TException('Invalid language value type.');
        }
        if (in_array($language, CardPaymentLanguagesDictionary::LANGUAGES)) {
            return CardPaymentLanguagesDictionary::LANGUAGES[array_search(
                $language,
                CardPaymentLanguagesDictionary::LANGUAGES
            )];
        }
        if (!array_key_exists($language, CardPaymentLanguagesDictionary::LANGUAGES)) {
            return 'en';
        }

        return $language;
    }

    /**
     * Check if variable has expected value
     *
     * @param mixed  $value   variable to check
     * @param array  $options available options
     * @param string $name    field name
     *
     * @throws TException
     */
    protected function validateOptions($value, $options, $name)
    {
        if (!in_array($value, $options, true)) {
            throw new TException(sprintf('Field "%s" has unsupported value', $name));
        }
    }

    /**
     * Check variable max length
     *
     * @param mixed  $value     variable to check
     * @param mixed  $validator
     * @param string $name      field name
     *
     * @throws TException
     *
     * @internal param int $max max length
     */
    protected function validateMaxLength($value, $validator, $name)
    {
        $max = explode('_', $validator);
        $max = (int) $max[1];
        if (strlen($value) > $max) {
            throw new TException(
                sprintf('Value of field "%s" is too long. Max %d characters', $name, $max)
            );
        }
    }

    /**
     * Check variable min length
     *
     * @param mixed  $value     variable to check
     * @param mixed  $validator
     * @param string $name      field name
     *
     * @throws TException
     *
     * @internal param int $min min length
     */
    protected function validateMinLength($value, $validator, $name)
    {
        $min = explode('_', $validator);
        $min = (int) $min[1];
        if (strlen($value) < $min) {
            throw new TException(
                sprintf('Value of field "%s" is too short. Min %d characters', $name, $min)
            );
        }
    }

    /**
     * Check if giver parameter is number
     *
     * @param mixed $number
     *
     * @throws TException
     *
     * @return bool
     */
    protected function validateNumeric($number)
    {
        if (is_numeric($number)) {
            return true;
        }
        throw new TException(sprintf('Value "%s" is not numeric.', $number));
    }
}
