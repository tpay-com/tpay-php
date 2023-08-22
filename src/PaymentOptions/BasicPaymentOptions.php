<?php

namespace Tpay\OriginApi\PaymentOptions;

use Tpay\OriginApi\Utilities\ObjectsHelper;
use Tpay\OriginApi\Utilities\TException;
use Tpay\OriginApi\Validators\FieldsConfigValidator;
use Tpay\OriginApi\Validators\PaymentTypes\PaymentTypeBasic;
use Tpay\OriginApi\Validators\PaymentTypes\PaymentTypeBasicApi;

/**
 * Class handles bank transfer payment through tpay panel
 */
class BasicPaymentOptions extends ObjectsHelper
{
    protected $transactionID;

    /**
     * BasicPaymentOptions class constructor for payment:
     * - basic from tpay panel
     * - with bank selection in merchant shop
     * - eHat
     */
    public function __construct()
    {
        $this->validateMerchantId($this->merchantId);
        $this->isNotEmptyString($this->merchantSecret, 'Merchant Secret');
    }

    public function setTransactionID($transactionID)
    {
        if (strpos($transactionID, 'TR-') > 0) {
            throw new TException('Invalid Transaction ID'.$transactionID);
        }
        $this->transactionID = $transactionID;

        return $this;
    }

    /**
     * FieldsConfigValidator passed payment config and add required elements with merchant id and md5 sum
     * More information about config fields @see FieldsConfigValidator::$panelPaymentRequestField
     *
     * @param array $config transaction config
     * @param bool  $isApi  set to get config fields for transaction API
     *
     * @return array
     */
    public function prepareConfig($config, $isApi = false)
    {
        $ready = $isApi ? $this->validateConfig(new PaymentTypeBasicApi(), $config)
            : $this->validateConfig(new PaymentTypeBasic(), $config);
        $crc = isset($ready['crc']) ? $ready['crc'] : '';

        $md5Params = [
            $this->merchantId,
            $ready['amount'],
            $crc,
            $this->merchantSecret,
        ];
        $ready['md5sum'] = md5(implode('&', $md5Params));
        $ready['id'] = $this->merchantId;

        return $ready;
    }
}
