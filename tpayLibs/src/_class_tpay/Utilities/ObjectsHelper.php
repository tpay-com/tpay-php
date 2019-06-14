<?php

/*
 * Created by tpay.com.
 * Date: 12.06.2017
 * Time: 17:49
 */

namespace tpayLibs\src\_class_tpay\Utilities;

use tpayLibs\src\_class_tpay\Curl\Curl;
use tpayLibs\src\_class_tpay\Validators\FieldsConfigValidator;
use tpayLibs\src\Dictionaries\NotificationsIP;

class ObjectsHelper
{
    use FieldsConfigValidator;

    /**
     * Api key
     * @var string
     */
    protected $trApiKey;

    /**
     * Api pass
     * @var string
     */
    protected $trApiPass;

    /**
     * Merchant id
     * @var int
     */
    protected $merchantId;

    /**
     * Merchant secret
     * @var string
     */
    protected $merchantSecret;

    /**
     * Card API key
     * @var string
     */
    protected $cardApiKey;

    /**
     * Card API password
     * @var string
     */
    protected $cardApiPass;

    /**
     * Card API code
     * @var string
     */
    protected $cardVerificationCode;

    /**
     * Card RSA key
     * @var string
     */
    protected $cardKeyRSA;

    /**
     * Card hash algorithm
     * @var string
     */
    protected $cardHashAlg = 'sha1';

    protected $secureIP = NotificationsIP::SECURE_IPS;
    protected $validateServerIP = true;
    protected $validateForwardedIP = false;
    protected $transactionApi;
    protected $cardsApi;
    protected $basicClient;
    protected $validator;
    protected $curl;

    public function requests($url, $params)
    {
        $this->curl = new Curl();
        return $this->curl->setRequestUrl($url)
            ->setPostData($params)
            ->enableJSONResponse()
            ->doRequest()
            ->getResult();
    }

    /**
     * Disabling validation of payment notification server IP
     * Validation of tpay server ip is very important.
     * Use this method only in test mode and be sure to enable validation in production.
     */
    public function disableValidationServerIP()
    {
        $this->validateServerIP = false;
        return $this;
    }

    /**
     * Enabling validation of payment notification server IP
     */
    public function enableValidationServerIP()
    {
        $this->validateServerIP = true;
        return $this;
    }

    /**
     * CloudFlare protected servers will be validated like all others
     * It is default behavior
     */
    public function disableForwardedIPValidation()
    {
        $this->validateForwardedIP = false;
        return $this;
    }

    /**
     * Enabling validation for CloudFlare protected servers
     */
    public function enableForwardedIPValidation()
    {
        $this->validateForwardedIP = true;
        return $this;
    }

    /**
     * Check if request is called from secure tpay server
     *
     * @return bool
     */
    public function isTpayServer()
    {
        return (new ServerValidator(
            $this->validateServerIP,
            $this->validateForwardedIP,
            $this->secureIP)
        )->isValid();
    }

}
