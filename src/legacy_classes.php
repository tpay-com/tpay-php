<?php

namespace tpayLibs\src\_class_tpay {
    class CardApi extends \Tpay\OriginApi\CardApi {}
    class MassPayments extends \Tpay\OriginApi\MassPayments {}
    class PaymentBlik extends \Tpay\OriginApi\PaymentBlik {}
    class PaymentCard extends \Tpay\OriginApi\PaymentCard {}
    class PaymentSMS extends \Tpay\OriginApi\PaymentSMS {}
    class TransactionApi extends \Tpay\OriginApi\TransactionApi {}
}

namespace tpayLibs\src\_class_tpay\Curl {
    class Curl extends \Tpay\OriginApi\Curl\Curl {}
    class CurlOptions extends \Tpay\OriginApi\Curl\CurlOptions {}
}

namespace tpayLibs\src\_class_tpay\Notifications {
    class BasicNotificationHandler extends \Tpay\OriginApi\Notifications\BasicNotificationHandler {}
    class BlikAliasNotificationHandler extends \Tpay\OriginApi\Notifications\BlikAliasNotificationHandler {}
    class CardNotificationHandler extends \Tpay\OriginApi\Notifications\CardNotificationHandler {}
}

namespace tpayLibs\src\_class_tpay\PaymentForms {
    class PaymentBasicForms extends \Tpay\OriginApi\PaymentForms\PaymentBasicForms {}
    class PaymentCardForms extends \Tpay\OriginApi\PaymentForms\PaymentCardForms {}
}

namespace tpayLibs\src\_class_tpay\PaymentOptions {
    class BasicPaymentOptions extends \Tpay\OriginApi\PaymentOptions\BasicPaymentOptions {}
    class CardOptions extends \Tpay\OriginApi\PaymentOptions\CardOptions {}
}

namespace tpayLibs\src\_class_tpay\Refunds {
    class BasicRefunds extends \Tpay\OriginApi\Refunds\BasicRefunds {}
    class CardRefunds extends \Tpay\OriginApi\Refunds\CardRefunds {}
}

namespace tpayLibs\src\_class_tpay\Reports {
    class BasicReports extends \Tpay\OriginApi\Reports\BasicReports {}
}

namespace tpayLibs\src\_class_tpay\Utilities {
    class Lang extends \Tpay\OriginApi\Utilities\Lang {}
    class ObjectsHelper extends \Tpay\OriginApi\Utilities\ObjectsHelper {}
    class ServerValidator extends \Tpay\OriginApi\Utilities\ServerValidator {}
    class TException extends \Tpay\OriginApi\Utilities\TException {}
    class Util extends \Tpay\OriginApi\Utilities\Util {}
}

namespace tpayLibs\src\_class_tpay\Validators {
    interface PaymentTypesInterface extends \Tpay\OriginApi\Validators\PaymentTypesInterface {}
    interface VariableTypesInterface extends \Tpay\OriginApi\Validators\VariableTypesInterface {}
    trait AccessConfigValidator
    {
        use \Tpay\OriginApi\Validators\AccessConfigValidator;
    }
    trait FieldsConfigValidator
    {
        use \Tpay\OriginApi\Validators\FieldsConfigValidator;
    }
    trait FieldsValidator
    {
        use \Tpay\OriginApi\Validators\FieldsValidator;
    }
    trait ResponseFieldsValidator
    {
        use \Tpay\OriginApi\Validators\ResponseFieldsValidator;
    }
}

namespace tpayLibs\src\_class_tpay\Validators\PaymentTypes {
    class PaymentTypeBasic extends \Tpay\OriginApi\Validators\PaymentTypes\PaymentTypeBasic {}
    class PaymentTypeBasicApi extends \Tpay\OriginApi\Validators\PaymentTypes\PaymentTypeBasicApi {}
    class PaymentTypeBlikAlias extends \Tpay\OriginApi\Validators\PaymentTypes\PaymentTypeBlikAlias {}
    class PaymentTypeCard extends \Tpay\OriginApi\Validators\PaymentTypes\PaymentTypeCard {}
    class PaymentTypeCardDeregister extends \Tpay\OriginApi\Validators\PaymentTypes\PaymentTypeCardDeregister {}
    class PaymentTypeT6Register extends \Tpay\OriginApi\Validators\PaymentTypes\PaymentTypeT6Register {}
    class PaymentTypeT6Standard extends \Tpay\OriginApi\Validators\PaymentTypes\PaymentTypeT6Standard {}
}

namespace tpayLibs\src\_class_tpay\Validators\VariableTypes {
    class ArrayType extends \Tpay\OriginApi\Validators\VariableTypes\ArrayType {}
    class BooleanType extends \Tpay\OriginApi\Validators\VariableTypes\BooleanType {}
    class CountryCodeType extends \Tpay\OriginApi\Validators\VariableTypes\CountryCodeType {}
    class DescriptionType extends \Tpay\OriginApi\Validators\VariableTypes\DescriptionType {}
    class EmailListType extends \Tpay\OriginApi\Validators\VariableTypes\EmailListType {}
    class FloatType extends \Tpay\OriginApi\Validators\VariableTypes\FloatType {}
    class IntType extends \Tpay\OriginApi\Validators\VariableTypes\IntType {}
    class StringType extends \Tpay\OriginApi\Validators\VariableTypes\StringType {}
    class VariableTypesValidator extends \Tpay\OriginApi\Validators\VariableTypes\VariableTypesValidator {}
}

namespace tpayLibs\src\Dictionaries {
    class CardDictionary extends \Tpay\OriginApi\Dictionaries\CardDictionary {}
    class FieldsConfigDictionary extends \Tpay\OriginApi\Dictionaries\FieldsConfigDictionary {}
    class FieldValueFilters extends \Tpay\OriginApi\Dictionaries\FieldValueFilters {}
    class HttpCodesDictionary extends \Tpay\OriginApi\Dictionaries\HttpCodesDictionary {}
    class NotificationsIP extends \Tpay\OriginApi\Dictionaries\NotificationsIP {}
    class PaymentTypesDictionary extends \Tpay\OriginApi\Dictionaries\PaymentTypesDictionary {}
}

namespace tpayLibs\src\Dictionaries\ErrorCodes {
    class TransactionApiErrors extends \Tpay\OriginApi\Dictionaries\ErrorCodes\TransactionApiErrors {}
}

namespace tpayLibs\src\Dictionaries\ISO_codes {
    class CountryCodesDictionary extends \Tpay\OriginApi\Dictionaries\ISO_codes\CountryCodesDictionary {}
    class CurrencyCodesDictionary extends \Tpay\OriginApi\Dictionaries\ISO_codes\CurrencyCodesDictionary {}
}

namespace tpayLibs\src\Dictionaries\Localization{
    class CardPaymentLanguagesDictionary extends \Tpay\OriginApi\Dictionaries\Localization\CardPaymentLanguagesDictionary {}
}

namespace tpayLibs\src\Dictionaries\Payments {
    class BasicFieldsDictionary extends \Tpay\OriginApi\Dictionaries\Payments\BasicFieldsDictionary {}
    class BlikFieldsDictionary extends \Tpay\OriginApi\Dictionaries\Payments\BlikFieldsDictionary {}
    class CardDeregisterFieldsDictionary extends \Tpay\OriginApi\Dictionaries\Payments\CardDeregisterFieldsDictionary {}
    class CardFieldsDictionary extends \Tpay\OriginApi\Dictionaries\Payments\CardFieldsDictionary {}
}

namespace tpayLibs\src\Translations {
    class English extends \Tpay\OriginApi\Translations\English {}
    class Keys extends \Tpay\OriginApi\Translations\Keys {}
    class Polish extends \Tpay\OriginApi\Translations\Polish {}
}
