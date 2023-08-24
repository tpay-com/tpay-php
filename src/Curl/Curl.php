<?php

namespace Tpay\OriginApi\Curl;

use CurlHandle;
use Tpay\OriginApi\Dictionaries\HttpCodesDictionary;
use Tpay\OriginApi\Utilities\TException;

/**
 * Curl class which helps with CURL handling
 */
class Curl extends CurlOptions
{
    /**
     * Last executed cURL info
     *
     * @var null|array
     */
    private $curlInfo;

    /**
     * Last executed cURL error
     *
     * @var string
     */
    private $curlError = '';

    /**
     * Last executed cURL errno
     *
     * @var string
     */
    private $curlErrorNumber = '';

    /** @var string */
    private $url = '';

    /** @var array */
    private $postData = [];

    /** @var bool */
    private $json = false;

    private $result;

    public function __construct()
    {
        if (!function_exists('curl_init') || !function_exists('curl_exec')) {
            throw new TException('cURL function not available');
        }
    }

    /** Get last info */
    public function getCurlLastInfo()
    {
        return $this->curlInfo;
    }

    /** Get last Curl error info */
    public function getCurlLastError()
    {
        return $this->curlError;
    }

    /** Get last Curl error number info */
    public function getCurlLastErrorNo()
    {
        return $this->curlErrorNumber;
    }

    /**
     * Set Curl request url
     *
     * @param string $url
     *
     * @return $this
     */
    public function setRequestUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Set Curl request data
     *
     * @param array $postData
     *
     * @throws TException
     *
     * @return $this
     */
    public function setPostData($postData)
    {
        if (!is_array($postData) && !is_array(json_decode($postData, true))) {
            throw new TException('Parameters are not php or json array');
        }
        foreach ($postData as $key => $value) {
            $this->postData[$key] = $value;
        }

        return $this;
    }

    /**
     * Set Curl request data
     *
     * @return $this
     */
    public function enableJSONResponse()
    {
        $this->json = true;
        $this->postData['json'] = true;

        return $this;
    }

    /**
     * Set Curl timeout time
     *
     * @throws TException
     *
     * @return array
     */
    public function getResult()
    {
        $response = $this->json ? json_decode($this->result, true) : $this->result;
        if (null === $response) {
            throw new TException('Error decoding response to JSON');
        }

        return $response;
    }

    /** @return $this */
    public function doRequest()
    {
        $ch = $this->init();
        $curlRes = curl_exec($ch);
        $this->curlInfo = curl_getinfo($ch);
        $this->curlError = curl_error($ch);
        $this->curlErrorNumber = curl_errno($ch);
        $this->checkResponse();
        curl_close($ch);
        $this->result = $curlRes;

        return $this;
    }

    /**
     * Execute Curl request
     *
     * @return CurlHandle
     */
    public function init()
    {
        $ch = curl_init();
        foreach ($this->getOptionsArray() as $key => $value) {
            curl_setopt($ch, $key, $value);
        }
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($this->postData));
        curl_setopt($ch, CURLOPT_URL, $this->url);

        return $ch;
    }

    /**
     * Check cURL response and throw exception if code is not allowed
     *
     * @throws TException
     */
    private function checkResponse()
    {
        $responseCode = $this->curlInfo['http_code'];
        $successCall = $responseCode >= 200 && $responseCode <= 299;

        return $successCall ? true : $this->getResponseCode($responseCode);
    }

    /**
     * Check cURL response and throw exception
     *
     * @param int $code
     *
     * @throws TException
     */
    private function getResponseCode($code)
    {
        if (array_key_exists($code, HttpCodesDictionary::HTTP_CODES)) {
            $codeDescription = sprintf('tpay.com server return %s', HttpCodesDictionary::HTTP_CODES[$code]);
            throw new TException($codeDescription);
        }
        throw new TException(sprintf('Unexpected response from tpay server %s', $code));
    }
}
