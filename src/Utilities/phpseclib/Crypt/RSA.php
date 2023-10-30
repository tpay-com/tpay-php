<?php

namespace Tpay\OriginApi\Utilities\phpseclib\Crypt;

use RuntimeException;

if (class_exists('phpseclib3\Crypt\RSA')) {
    abstract class RSA extends \phpseclib3\Crypt\RSA {}
} elseif (class_exists('phpseclib\Crypt\RSA')) {
    class RSA extends \phpseclib\Crypt\RSA {}
} else {
    throw new RuntimeException('Cannot find supported phpseclib/phpseclib library');
}
