<?php

namespace tpayLibs\src\_class_tpay {
    class CardApi extends \Tpay\CardApi {}
    class MassPayments extends \Tpay\MassPayments {}
    class PaymentBlik extends \Tpay\PaymentBlik {}
    class PaymentCard extends \Tpay\PaymentCard {}
    class PaymentSMS extends \Tpay\PaymentSMS {}
    class TransactionApi extends \Tpay\TransactionApi {}
}

namespace tpayLibs\src\_class_tpay\Curl {
    class Curl extends \Tpay\Curl\Curl {}
    class CurlOptions extends \Tpay\Curl\CurlOptions {}
}

namespace tpayLibs\src\_class_tpay\Notifications {
    class BasicNotificationHandler extends \Tpay\Notifications\BasicNotificationHandler {}
    class BlikAliasNotificationHandler extends \Tpay\Notifications\BlikAliasNotificationHandler {}
    class CardNotificationHandler extends \Tpay\Notifications\CardNotificationHandler {}
}

namespace tpayLibs\src\_class_tpay\PaymentForms {
    class PaymentBasicForms extends \Tpay\PaymentForms\PaymentBasicForms {}
    class PaymentCardForms extends \Tpay\PaymentForms\PaymentCardForms {}
}

namespace tpayLibs\src\_class_tpay\PaymentOptions {
    class BasicPaymentOptions extends \Tpay\PaymentOptions\BasicPaymentOptions {}
    class CardOptions extends \Tpay\PaymentOptions\CardOptions {}
}

namespace tpayLibs\src\_class_tpay\Refunds {
    class BasicRefunds extends \Tpay\Refunds\BasicRefunds {}
    class CardRefunds extends \Tpay\Refunds\CardRefunds {}
}

namespace tpayLibs\src\_class_tpay\Reports {
    class BasicReports extends \Tpay\Reports\BasicReports {}
}

namespace tpayLibs\src\_class_tpay\Utilities {
    class Lang extends \Tpay\Utilities\Lang {}
    class ObjectsHelper extends \Tpay\Utilities\ObjectsHelper {}
    class ServerValidator extends \Tpay\Utilities\ServerValidator {}
    class TException extends \Tpay\Utilities\TException {}
    class Util extends \Tpay\Utilities\Util {}
}

namespace tpayLibs\src\_class_tpay\Validators {
    interface PaymentTypesInterface extends \Tpay\Validators\PaymentTypesInterface {}
    interface VariableTypesInterface extends \Tpay\Validators\VariableTypesInterface {}
    trait AccessConfigValidator
    {
        use \Tpay\Validators\AccessConfigValidator;
    }
    trait FieldsConfigValidator
    {
        use \Tpay\Validators\FieldsConfigValidator;
    }
    trait FieldsValidator
    {
        use \Tpay\Validators\FieldsValidator;
    }
    trait ResponseFieldsValidator
    {
        use \Tpay\Validators\ResponseFieldsValidator;
    }
}

namespace tpayLibs\src\_class_tpay\Validators\PaymentTypes {
    class PaymentTypeBasic extends \Tpay\Validators\PaymentTypes\PaymentTypeBasic {}
    class PaymentTypeBasicApi extends \Tpay\Validators\PaymentTypes\PaymentTypeBasicApi {}
    class PaymentTypeBlikAlias extends \Tpay\Validators\PaymentTypes\PaymentTypeBlikAlias {}
    class PaymentTypeCard extends \Tpay\Validators\PaymentTypes\PaymentTypeCard {}
    class PaymentTypeCardDeregister extends \Tpay\Validators\PaymentTypes\PaymentTypeCardDeregister {}
    class PaymentTypeT6Register extends \Tpay\Validators\PaymentTypes\PaymentTypeT6Register {}
    class PaymentTypeT6Standard extends \Tpay\Validators\PaymentTypes\PaymentTypeT6Standard {}
}

namespace tpayLibs\src\_class_tpay\Validators\VariableTypes {
    class ArrayType extends \Tpay\Validators\VariableTypes\ArrayType {}
    class BooleanType extends \Tpay\Validators\VariableTypes\BooleanType {}
    class CountryCodeType extends \Tpay\Validators\VariableTypes\CountryCodeType {}
    class DescriptionType extends \Tpay\Validators\VariableTypes\DescriptionType {}
    class EmailListType extends \Tpay\Validators\VariableTypes\EmailListType {}
    class FloatType extends \Tpay\Validators\VariableTypes\FloatType {}
    class IntType extends \Tpay\Validators\VariableTypes\IntType {}
    class StringType extends \Tpay\Validators\VariableTypes\StringType {}
    class VariableTypesValidator extends \Tpay\Validators\VariableTypes\VariableTypesValidator {}
}

namespace tpayLibs\src\Dictionaries {
    class CardDictionary extends \Tpay\Dictionaries\CardDictionary {}
    class FieldsConfigDictionary extends \Tpay\Dictionaries\FieldsConfigDictionary {}
    class FieldValueFilters extends \Tpay\Dictionaries\FieldValueFilters {}
    class HttpCodesDictionary extends \Tpay\Dictionaries\HttpCodesDictionary {}
    class NotificationsIP extends \Tpay\Dictionaries\NotificationsIP {}
    class PaymentTypesDictionary extends \Tpay\Dictionaries\PaymentTypesDictionary {}
}

namespace tpayLibs\src\Dictionaries\ErrorCodes {
    class TransactionApiErrors extends \Tpay\Dictionaries\ErrorCodes\TransactionApiErrors {}
}

namespace tpayLibs\src\Dictionaries\ISO_codes {
    class CountryCodesDictionary extends \Tpay\Dictionaries\ISO_codes\CountryCodesDictionary {}
    class CurrencyCodesDictionary extends \Tpay\Dictionaries\ISO_codes\CurrencyCodesDictionary {}
}

namespace tpayLibs\src\Dictionaries\Localization{
    class CardPaymentLanguagesDictionary extends \Tpay\Dictionaries\Localization\CardPaymentLanguagesDictionary {}
}

namespace tpayLibs\src\Dictionaries\Payments {
    class BasicFieldsDictionary extends \Tpay\Dictionaries\Payments\BasicFieldsDictionary {}
    class BlikFieldsDictionary extends \Tpay\Dictionaries\Payments\BlikFieldsDictionary {}
    class CardDeregisterFieldsDictionary extends \Tpay\Dictionaries\Payments\CardDeregisterFieldsDictionary {}
    class CardFieldsDictionary extends \Tpay\Dictionaries\Payments\CardFieldsDictionary {}
}

namespace tpayLibs\src\Translations {
    class English extends \Tpay\Translations\English {}
    class Keys extends \Tpay\Translations\Keys {}
    class Polish extends \Tpay\Translations\Polish {}
}
