<?php
namespace Transferuj;

/**
 * Curl class which helps with CURL handling
 *
 * @package Transferuj
 */
class Curl
{
    /**
     * Last executed cURL info
     * @var array|null
     */
    private static $curlInfo;
    /**
     * Last executed cURL error
     * @var string
     */
    private static $curlError = '';

    /**
     * Last executed cURL errno
     * @var string
     */
    private static $curlErrno = '';
    /**
     * Get last info
     *
     * @return mixed
     */
    public static function getCurlLastInfo()
    {
        return self::$curlInfo;
    }

    /**
     * Execute cURL request
     *
     * @param string $url      action url
     * @param array  $postData array with post variables
     *
     * @return mixed
     * @throws TException
     */
    public static function doCurlRequest($url, $postData = array())
    {
        if(!function_exists('curl_init') || !function_exists('curl_exec')) {
            throw new TException('cURL function not available');
        }
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 15);
        curl_setopt($ch, CURLOPT_TIMEOUT, 20);
        curl_setopt($ch, CURLOPT_VERBOSE, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FAILONERROR, true);
        curl_setopt($ch, CURLOPT_URL, $url);
        $curlRes = curl_exec($ch);

        self::$curlInfo = curl_getinfo($ch);
        self::$curlError = curl_error($ch);
        self::$curlErrno = curl_errno($ch);

        self::checkResponse();

        curl_close($ch);

        return $curlRes;
    }

    /**
     * List of http response codes the occurrence of which results in throw exception
     *
     * @var array
     */
    private static $httpCodes = array(
        500 => '500: Internal Server Error',
        501 => '501: Not Implemented',
        502 => '502: Bad Gateway',
        503 => '503: Service Unavailable',
        504 => '504: Gateway Timeout',
        505 => '505: HTTP Version Not Supported',
    );

    /**
     * Check cURL response and throw exception if code is not allowed
     *
     * @throws TException
     */
    private static function checkResponse()
    {
        $responseCode = self::$curlInfo['http_code'];
        if ($responseCode !== 200){
            if (isset(self::$httpCodes[$responseCode])){
                throw new TException(sprintf('Transferuj.pl server return %s', self::$httpCodes[$responseCode]));
            } else {
                throw new TException('Unexpected response from Transferuj server');
            }
        }
    }
}