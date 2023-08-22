<?php

namespace Tpay\OriginApi;

use Tpay\OriginApi\Curl\Curl;
use Tpay\OriginApi\Utilities\ObjectsHelper;
use Tpay\OriginApi\Utilities\TException;
use Tpay\OriginApi\Utilities\Util;

class PaymentSMS extends ObjectsHelper
{
    /**
     * Url to verify SMS code
     *
     * @var string
     */
    private $secureURL = 'https://sms.tpay.com/widget/verifyCode.php';

    /**
     * Get code sent by from tpay SMS widget.
     * FieldsConfigValidator code by sending cURL to tpay server.
     *
     * @throws TException
     */
    public function doSmsRequest()
    {
        $codeToCheck = Util::post('tfCodeToCheck', 'string');
        $hash = Util::post('tfHash', 'string');

        if (false === $codeToCheck || false === $hash) {
            throw new TException('Invalid input data');
        }

        $postData = [
            'tfCodeToCheck' => $codeToCheck,
            'tfHash' => $hash,
        ];
        Util::log('Sms verification request', json_encode($postData));
        $response = $this->requests($this->secureURL, $postData);
        Util::log('Sms verification response', print_r($response, true));

        return $this->isValidCode($response);
    }

    public function requests($url, $params)
    {
        $this->curl = new Curl();

        return $this->curl
            ->setRequestUrl($url)
            ->setPostData($params)
            ->doRequest()
            ->getResult();
    }

    /**
     * @param mixed $response
     *
     * @return bool
     */
    private function isValidCode($response)
    {
        $data = explode("\n", $response);

        $status = (int) $data[0];

        return (bool) $status;
    }
}
