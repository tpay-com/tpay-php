<?php

/*
 * Created by tpay.com.
 * Date: 13.06.2017
 * Time: 16:14
 */

namespace tpayLibs\src\_class_tpay;

use tpayLibs\src\_class_tpay\Utilities\TException;
use tpayLibs\src\_class_tpay\Utilities\Util;
use tpayLibs\src\_class_tpay\Validators\PaymentTypes\PaymentTypeBlikAlias;
use tpayLibs\src\_class_tpay\Validators\PaymentTypes\PaymentTypeT6Register;
use tpayLibs\src\_class_tpay\Validators\PaymentTypes\PaymentTypeT6Standard;
use tpayLibs\src\Dictionaries\FieldsConfigDictionary;

class PaymentBlik extends TransactionApi
{
    public function handleBlikPayment($params)
    {
        if (!is_array($params) || count($params) <= 0) {
            throw new TException('Invalid or empty input parameters');
        }
        if (isset($params[FieldsConfigDictionary::CODE]) && !isset($params[static::ALIAS])) {
            $response = $this->handleBlik(new PaymentTypeT6Standard(), $params);
        } elseif (isset($params[FieldsConfigDictionary::CODE]) && isset($params[static::ALIAS])) {
            $response = $this->handleBlik(new PaymentTypeT6Register(), $params);
        } else {
            $response = $this->handleBlik(new PaymentTypeBlikAlias(), $params);
        }

        switch ($response['result']) {
            case 1:
                $success = true;
                break;
            case 0:
                if (isset($response[static::ERR]) && $response[static::ERR] === 'ERR82') {
                    $apps = array();
                    foreach ($response['availableUserApps'] as $userApp) {
                        $apps[] = get_object_vars($userApp);
                    }
                    return $apps;
                } else {
                    $success = false;
                }
                break;
            default:
                $success = false;
                break;
        }
        return $success;
    }

    public function handleBlik($type, $params)
    {
        $params = $this->validateConfig($type, $params);

        switch ($type) {
            case $type instanceof PaymentTypeT6Standard:
                $response = $this->blik($params[static::TITLE], $params[FieldsConfigDictionary::CODE]);
                break;
            case $type instanceof PaymentTypeT6Register:
                $response = $this->blik($params[static::TITLE], $params[FieldsConfigDictionary::CODE],
                    $params[static::ALIAS]);
                break;
            case $type instanceof PaymentTypeBlikAlias:
                $response = $this->blik($params[static::TITLE], '', $params[static::ALIAS]);
                break;
            default:
                throw new TException('Undefined transaction type!');
        }
        return $response;
    }

    public function blik($title, $code = '', $alias = '')
    {
        if (empty($title) || !is_string($title)) {
            throw new TException('Transaction title is empty or invalid');
        }
        $config['title'] = $title;
        if (!empty($code)) {
            $config[FieldsConfigDictionary::CODE] = $code;
        }
        if (!empty($alias)) {
            $config[static::ALIAS][] = $alias;
        }

        $url = $this->apiURL . $this->trApiKey . '/transaction/blik';
        Util::log('Blik request params', print_r($config, true));
        $res = $this->requests($url, $config);
        Util::log('Blik response', print_r($res, true));

        return $res;
    }

}
