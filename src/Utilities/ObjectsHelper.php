<?php

namespace Tpay\OriginApi\Utilities;

use Tpay\OriginApi\Curl\Curl;
use Tpay\OriginApi\Validators\FieldsConfigValidator;

class ObjectsHelper
{
    use FieldsConfigValidator;

    /**
     * Api key
     *
     * @var string
     */
    protected $trApiKey;

    /**
     * Api pass
     *
     * @var string
     */
    protected $trApiPass;

    /**
     * Merchant id
     *
     * @var int
     */
    protected $merchantId;

    /**
     * Merchant secret
     *
     * @var string
     */
    protected $merchantSecret;

    /**
     * Card API key
     *
     * @var string
     */
    protected $cardApiKey;

    /**
     * Card API password
     *
     * @var string
     */
    protected $cardApiPass;

    /**
     * Card API code
     *
     * @var string
     */
    protected $cardVerificationCode;

    /**
     * Card RSA key
     *
     * @var string
     */
    protected $cardKeyRSA;

    /**
     * Card hash algorithm
     *
     * @var string
     */
    protected $cardHashAlg = 'sha1';

    protected $curl;

    /**
     * @param string $url
     *
     * @param array  $params
     *
     * @return array
     */
    public function requests($url, $params)
    {
        $this->curl = new Curl();

        return $this->curl->setRequestUrl($url)
            ->setPostData($params)
            ->enableJSONResponse()
            ->doRequest()
            ->getResult();
    }
}
