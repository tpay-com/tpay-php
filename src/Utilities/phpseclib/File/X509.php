<?php

namespace Tpay\OriginApi\Utilities\phpseclib\File;

use RuntimeException;

if (class_exists('phpseclib3\File\X509')) {
    class X509 extends \phpseclib3\File\X509
    {
        public function withSettings($publicKey, $hash, $signature)
        {
            return $publicKey->withHash($hash)->withPadding($signature);
        }
    }
} elseif (class_exists('phpseclib\File\X509')) {
    class X509 extends \phpseclib\File\X509
    {
        public function withSettings($publicKey, $hash, $signature)
        {
            $publicKey->setHash($hash);
            $publicKey->setSignatureMode($signature);

            return $publicKey;
        }
    }
} else {
    throw new RuntimeException('Cannot find supported phpseclib/phpseclib library');
}
