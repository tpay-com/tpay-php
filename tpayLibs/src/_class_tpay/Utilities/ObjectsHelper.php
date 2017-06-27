<?php

/*
 * Created by tpay.com.
 * Date: 12.06.2017
 * Time: 17:49
 */

namespace tpayLibs\src\_class_tpay\Utilities;

use tpayLibs\src\_class_tpay\Curl\Curl;
use tpayLibs\src\_class_tpay\Validators\FieldsConfigValidator;

class ObjectsHelper
{
    use FieldsConfigValidator;
    const REMOTE_ADDRESS = 'REMOTE_ADDR';

    /**
     * Api key
     * @var string
     */
    protected $trApiKey = '[TR_API_KEY]';

    /**
     * Api pass
     * @var string
     */
    protected $trApiPass = '[TR_API_PASS]';

    /**
     * Merchant id
     * @var int
     */
    protected $merchantId = '[MERCHANT_ID]';

    /**
     * Merchant secret
     * @var string
     */
    protected $merchantSecret = '[MERCHANT_SECRET]';

    /**
     * Card API key
     * @var string
     */
    protected $cardApiKey = '[CARD_API_KEY]';

    /**
     * Card API password
     * @var string
     */
    protected $cardApiPass = '[CARD_API_PASSWORD]';

    /**
     * Card API code
     * @var string
     */
    protected $cardVerificationCode = '[CARD_API_CODE]';

    /**
     * Card RSA key
     * @var string
     */
    protected $cardKeyRSA = '[CARD_RSA_KEY]';

    /**
     * Card hash algorithm
     * @var string
     */
    protected $cardHashAlg = '[CARD_HASH_ALG]';
    /**
     * API login
     * @var string
     */
    protected $szkwalApiLogin = '[SZKWAL_LOGIN]';
    /**
     * API password
     * @var string
     */
    protected $szkwalApiPass = '[SZKWAL_API_PASSWORD]';
    /**
     * API hash
     * @var string
     */
    protected $szkwalApiHash = '[SZKWAL_API_HASH]';
    /**
     * API partner unique address
     * @var string
     */
    protected $szkwalPartnerUniqueAddress = '[SZKWAL_PARTNER_ADDRESS]';
    /**
     * API title format
     * @var string
     */
    protected $szkwalTitleFormat = '[SZKWAL_TITLE_FORMAT]';

    protected $secureIP;
    protected $validateServerIP = true;
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
    }

    /**
     * Enabling validation of payment notification server IP
     */
    public function enableValidationServerIP()
    {
        $this->validateServerIP = true;
    }

    /**
     * Check if request is called from secure tpay server
     *
     * @return bool
     */
    public function isTpayServer()
    {
        if (!isset($_SERVER[static::REMOTE_ADDRESS]) && !isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            return false;
        }
        return (in_array($_SERVER[static::REMOTE_ADDRESS], $this->secureIP)
            || in_array($_SERVER['HTTP_X_FORWARDED_FOR'], $this->secureIP));
    }
}
