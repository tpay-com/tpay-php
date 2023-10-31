<?php

namespace Tpay\OriginApi\Webhook;

use Tpay\OriginApi\Utilities\phpseclib\Crypt\RSA;
use Tpay\OriginApi\Utilities\phpseclib\File\X509;
use Tpay\OriginApi\Utilities\TException;
use Tpay\OriginApi\Utilities\Util;
use Tpay\OriginApi\Validators\FieldsConfigValidator;
use Tpay\OriginApi\Validators\PaymentTypes\PaymentTypeBasic;

class JWSVerifiedPaymentNotification
{
    use FieldsConfigValidator;

    const PRODUCTION_PREFIX = 'https://secure.tpay.com';
    const SANDBOX_PREFIX = 'https://secure.sandbox.tpay.com';

    /** @var bool */
    private $productionMode;

    /** @var string */
    private $merchantSecret;

    /**
     * @param string $merchantSecret string Merchant notification check secret
     * @param bool   $productionMode bool is prod or sandbox flag
     */
    public function __construct($merchantSecret, $productionMode = true)
    {
        $this->productionMode = $productionMode;
        $this->merchantSecret = $merchantSecret;
    }

    /**
     * Get checked notification object.
     * If exception occurs it means that something went wrong with notification verification process.
     *
     * @throws TException
     *
     * @return array
     */
    public function getNotification()
    {
        $notification = $this->getNotificationObject();

        $this->checkMd5($notification);
        $this->checkJwsSignature();

        return $notification;
    }

    protected function checkJwsSignature()
    {
        $jws = isset($_SERVER['HTTP_X_JWS_SIGNATURE']) ? $_SERVER['HTTP_X_JWS_SIGNATURE'] : null;

        if (null === $jws) {
            throw new TException('Missing JSW header');
        }

        $jwsData = explode('.', $jws);
        $headers = isset($jwsData[0]) ? $jwsData[0] : null;
        $signature = isset($jwsData[2]) ? $jwsData[2] : null;

        if (null === $headers || null === $signature) {
            throw new TException('Invalid JWS header');
        }

        $headersJson = base64_decode(strtr($headers, '-_', '+/'));

        /** @var array $headersData */
        $headersData = json_decode($headersJson, true);

        /** @var null|string $x5u */
        $x5u = isset($headersData['x5u']) ? $headersData['x5u'] : null;

        if (null === $x5u) {
            throw new TException('Missing x5u header');
        }

        $prefix = $this->getResourcePrefix();

        if (substr($x5u, 0, strlen($prefix)) !== $prefix) {
            throw new TException('Wrong x5u url');
        }

        $certificate = file_get_contents($x5u);
        $trusted = file_get_contents($this->getResourcePrefix().'/x509/tpay-jws-root.pem');

        $x509 = new X509();
        $x509->loadX509($certificate);
        $x509->loadCA($trusted);

        if (!$x509->validateSignature()) {
            throw new TException('Signing certificate is not signed by Tpay CA certificate');
        }

        $body = file_get_contents('php://input');
        $payload = str_replace('=', '', strtr(base64_encode($body), '+/', '-_'));
        $decodedSignature = base64_decode(strtr($signature, '-_', '+/'));
        $publicKey = $x509->getPublicKey();
        $publicKey = $x509->withSettings($publicKey, 'sha256', RSA::SIGNATURE_PKCS1);
        if (!$publicKey->verify($headers.'.'.$payload, $decodedSignature)) {
            throw new TException('FALSE - Invalid JWS signature');
        }
    }

    /**
     * @param int    $id
     * @param string $transactionId
     * @param string $amount
     * @param string $orderId
     * @param string $merchantSecret
     * @param string $requestMd5
     *
     * @throws TException
     */
    private function checkMd5Validity($id, $transactionId, $amount, $orderId, $merchantSecret, $requestMd5)
    {
        if (md5($id.$transactionId.$amount.$orderId.$merchantSecret) !== $requestMd5) {
            throw new TException('MD5 checksum is invalid');
        }
    }

    /**
     * @param mixed $notification
     *
     * @throws TException
     */
    private function checkMd5($notification)
    {
        $this->checkMd5Validity(
            $notification['id'],
            $notification['tr_id'],
            Util::numberFormat($notification['tr_amount']),
            $notification['tr_crc'],
            $this->merchantSecret,
            $notification['md5sum']
        );
    }

    /** @return string */
    private function getResourcePrefix()
    {
        if ($this->productionMode) {
            return self::PRODUCTION_PREFIX;
        }

        return self::SANDBOX_PREFIX;
    }

    private function getNotificationObject()
    {
        if (!isset($_POST['tr_id'])) {
            throw new TException('Not recognised or invalid notification type. POST: '.json_encode($_POST));
        }

        return $this->getResponse(new PaymentTypeBasic());
    }
}
