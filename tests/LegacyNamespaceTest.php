<?php

namespace Tpay\OriginApi\Tests;

use PHPUnit\Framework\TestCase;
use ReflectionClass;

/**
 * @coversNothing
 */
class LegacyNamespaceTest extends TestCase
{
    /**
     * @dataProvider getLegacyClassNamesFromArray
     */
    public function testClassesExist($classNames)
    {
        foreach ($classNames as $className) {
            $this->assertTrue(
                class_exists($className) || interface_exists($className) || trait_exists($className),
                sprintf('Class, interface or trait %s not found.', $className)
            );
        }
    }

    /**
     * @dataProvider getLegacyClassNamesFromArray
     */
    public function testClassesHaveUniqueNames($classNames)
    {
        $legacyClassShortNames = array_map(
            function ($className) {
                return (new ReflectionClass($className))->getShortName();
            },
            $classNames
        );

        $this->assertSame(
            array_unique($legacyClassShortNames),
            $legacyClassShortNames
        );
    }

    private static function getLegacyClassNamesFromArray()
    {
        return [
            [
                [
                    'tpayLibs\\src\\Dictionaries\\CardDictionary',
                    'tpayLibs\\src\\Dictionaries\\ErrorCodes\\TransactionApiErrors',
                    'tpayLibs\\src\\Dictionaries\\FieldValueFilters',
                    'tpayLibs\\src\\Dictionaries\\FieldsConfigDictionary',
                    'tpayLibs\\src\\Dictionaries\\HttpCodesDictionary',
                    'tpayLibs\\src\\Dictionaries\\ISO_codes\\CountryCodesDictionary',
                    'tpayLibs\\src\\Dictionaries\\ISO_codes\\CurrencyCodesDictionary',
                    'tpayLibs\\src\\Dictionaries\\Localization\\CardPaymentLanguagesDictionary',
                    'tpayLibs\\src\\Dictionaries\\NotificationsIP',
                    'tpayLibs\\src\\Dictionaries\\PaymentTypesDictionary',
                    'tpayLibs\\src\\Dictionaries\\Payments\\BasicFieldsDictionary',
                    'tpayLibs\\src\\Dictionaries\\Payments\\BlikFieldsDictionary',
                    'tpayLibs\\src\\Dictionaries\\Payments\\CardDeregisterFieldsDictionary',
                    'tpayLibs\\src\\Dictionaries\\Payments\\CardFieldsDictionary',
                    'tpayLibs\\src\\Translations\\English',
                    'tpayLibs\\src\\Translations\\Keys',
                    'tpayLibs\\src\\Translations\\Polish',
                    'tpayLibs\\src\\_class_tpay\\CardApi',
                    'tpayLibs\\src\\_class_tpay\\Curl\\Curl',
                    'tpayLibs\\src\\_class_tpay\\Curl\\CurlOptions',
                    'tpayLibs\\src\\_class_tpay\\MassPayments',
                    'tpayLibs\\src\\_class_tpay\\Notifications\\BasicNotificationHandler',
                    'tpayLibs\\src\\_class_tpay\\Notifications\\BlikAliasNotificationHandler',
                    'tpayLibs\\src\\_class_tpay\\Notifications\\CardNotificationHandler',
                    'tpayLibs\\src\\_class_tpay\\PaymentBlik',
                    'tpayLibs\\src\\_class_tpay\\PaymentCard',
                    'tpayLibs\\src\\_class_tpay\\PaymentForms\\PaymentBasicForms',
                    'tpayLibs\\src\\_class_tpay\\PaymentForms\\PaymentCardForms',
                    'tpayLibs\\src\\_class_tpay\\PaymentOptions\\BasicPaymentOptions',
                    'tpayLibs\\src\\_class_tpay\\PaymentOptions\\CardOptions',
                    'tpayLibs\\src\\_class_tpay\\PaymentSMS',
                    'tpayLibs\\src\\_class_tpay\\Refunds\\BasicRefunds',
                    'tpayLibs\\src\\_class_tpay\\Refunds\\CardRefunds',
                    'tpayLibs\\src\\_class_tpay\\Reports\\BasicReports',
                    'tpayLibs\\src\\_class_tpay\\TransactionApi',
                    'tpayLibs\\src\\_class_tpay\\Utilities\\Lang',
                    'tpayLibs\\src\\_class_tpay\\Utilities\\ObjectsHelper',
                    'tpayLibs\\src\\_class_tpay\\Utilities\\ServerValidator',
                    'tpayLibs\\src\\_class_tpay\\Utilities\\TException',
                    'tpayLibs\\src\\_class_tpay\\Utilities\\Util',
                    'tpayLibs\\src\\_class_tpay\\Validators\\AccessConfigValidator',
                    'tpayLibs\\src\\_class_tpay\\Validators\\FieldsConfigValidator',
                    'tpayLibs\\src\\_class_tpay\\Validators\\FieldsValidator',
                    'tpayLibs\\src\\_class_tpay\\Validators\\PaymentTypesInterface',
                    'tpayLibs\\src\\_class_tpay\\Validators\\PaymentTypes\\PaymentTypeBasic',
                    'tpayLibs\\src\\_class_tpay\\Validators\\PaymentTypes\\PaymentTypeBasicApi',
                    'tpayLibs\\src\\_class_tpay\\Validators\\PaymentTypes\\PaymentTypeBlikAlias',
                    'tpayLibs\\src\\_class_tpay\\Validators\\PaymentTypes\\PaymentTypeCard',
                    'tpayLibs\\src\\_class_tpay\\Validators\\PaymentTypes\\PaymentTypeCardDeregister',
                    'tpayLibs\\src\\_class_tpay\\Validators\\PaymentTypes\\PaymentTypeT6Register',
                    'tpayLibs\\src\\_class_tpay\\Validators\\PaymentTypes\\PaymentTypeT6Standard',
                    'tpayLibs\\src\\_class_tpay\\Validators\\ResponseFieldsValidator',
                    'tpayLibs\\src\\_class_tpay\\Validators\\VariableTypesInterface',
                    'tpayLibs\\src\\_class_tpay\\Validators\\VariableTypes\\ArrayType',
                    'tpayLibs\\src\\_class_tpay\\Validators\\VariableTypes\\BooleanType',
                    'tpayLibs\\src\\_class_tpay\\Validators\\VariableTypes\\CountryCodeType',
                    'tpayLibs\\src\\_class_tpay\\Validators\\VariableTypes\\DescriptionType',
                    'tpayLibs\\src\\_class_tpay\\Validators\\VariableTypes\\EmailListType',
                    'tpayLibs\\src\\_class_tpay\\Validators\\VariableTypes\\FloatType',
                    'tpayLibs\\src\\_class_tpay\\Validators\\VariableTypes\\IntType',
                    'tpayLibs\\src\\_class_tpay\\Validators\\VariableTypes\\StringType',
                    'tpayLibs\\src\\_class_tpay\\Validators\\VariableTypes\\VariableTypesValidator',
                ]
            ]
        ];
    }
}
