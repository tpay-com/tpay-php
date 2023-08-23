<?php

namespace Tpay\OriginApi\PaymentOptions;

use Tpay\OriginApi\Dictionaries\FieldsConfigDictionary;
use Tpay\OriginApi\Utilities\ObjectsHelper;
use Tpay\OriginApi\Utilities\TException;

class CardOptions extends ObjectsHelper
{
    /** @var string */
    public $cardsApiURL = 'https://secure.tpay.com/api/cards/';

    /** @var int|string */
    public $currency = 985;

    /** @var string */
    protected $orderID = '';

    /** @var bool */
    protected $oneTimer = true;

    /** @var string */
    protected $lang = 'pl';

    /** @var bool */
    protected $enablePowUrl = false;

    /** @var string */
    protected $powUrl = '';

    /** @var string */
    protected $powUrlBlad = '';

    /** @var null|string */
    protected $cardData;

    /** @var string */
    protected $method = 'register_sale';

    /** @var string */
    protected $clientAuthCode = '';

    /** @var string */
    protected $amount;

    /** @var string */
    protected $moduleName;

    public function __construct()
    {
        $this->isNotEmptyString($this->cardApiKey, 'Card API key');
        $this->isNotEmptyString($this->cardApiPass, 'Card API password');
        $this->validateCardHashAlg($this->cardHashAlg);
        $this->validateCardCode($this->cardVerificationCode);
    }

    /**
     * @param string $token
     *
     * @return $this
     */
    public function setClientToken($token)
    {
        if (!is_string($token) || 40 !== strlen($token)) {
            throw new TException('invalid token');
        }
        $this->clientAuthCode = $token;

        return $this;
    }

    /**
     * @param int|string $currency
     *
     * @return $this
     */
    public function setCurrency($currency)
    {
        $this->currency = $this->validateCardCurrency($currency);

        return $this;
    }

    /**
     * @param string $orderID
     *
     * @return $this
     */
    public function setOrderID($orderID)
    {
        $this->orderID = $orderID;

        return $this;
    }

    /**
     * @param string $oneTimer
     *
     * @return $this
     */
    public function setOneTimer($oneTimer)
    {
        $this->oneTimer = $oneTimer;

        return $this;
    }

    /**
     * @param string $lang
     *
     * @return $this
     */
    public function setLanguage($lang)
    {
        $this->lang = strtolower($this->validateCardLanguage($lang));

        return $this;
    }

    /**
     * @param string $enablePowUrl
     *
     * @return $this
     */
    public function setEnablePowUrl($enablePowUrl)
    {
        $this->enablePowUrl = $enablePowUrl;

        return $this;
    }

    /**
     * @param string $successUrl
     * @param string $errorUrl
     *
     * @return $this
     */
    public function setReturnUrls($successUrl, $errorUrl)
    {
        $this->powUrl = $successUrl;
        $this->powUrlBlad = $errorUrl;

        return $this;
    }

    /**
     * @param string $data
     *
     * @return $this
     */
    public function setCardData($data)
    {
        $this->cardData = $data;

        return $this;
    }

    /**
     * @param string $method
     *
     * @return $this
     */
    public function setMethod($method)
    {
        $this->method = $method;

        return $this;
    }

    /**
     * @param string $amount
     *
     * @return $this
     */
    public function setAmount($amount)
    {
        $this->validateNumeric($amount);
        $this->amount = $amount;

        return $this;
    }

    /**
     * @param string $name
     *
     * @throws TException
     */
    public function setModuleName($name)
    {
        $this->validateMaxLength($name, FieldsConfigDictionary::MAXLENGTH_32, 'module');
        $this->moduleName = $name;

        return $this;
    }
}
