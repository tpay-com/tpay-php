<?php

/*
 * Created by tpay.com
 */

namespace tpayLibs\examples;

use tpayLibs\src\_class_tpay\PaymentBlik;

include_once 'config.php';
include_once 'loader.php';

class OneClick extends PaymentBlik
{

    const TITLE = 'title';

    const ALIAS_KEY = 'aliasKey';

    const CODE = 'code';

    const REGISTER = 'register';

    const ALIAS = 'alias';

    public function __construct()
    {
        $this->merchantSecret = 'demo';
        $this->merchantId = 1010;
        $this->trApiKey = '';
        $this->trApiPass = '';
        parent::__construct();

        if (empty($_GET)) {
            $this->getForm();
        }
        if (isset($_GET['tryOneClick']) && isset($_GET[static::TITLE])) {
            $params[static::TITLE] = $_GET[static::TITLE];
            $this->pushBlik($params);
        }
        if (isset($_GET['getTitle'])) {
            $this->createTransaction();
        }
        if (isset($_GET[static::CODE]) || isset($_GET[static::TITLE]) || isset($_GET[static::ALIAS_KEY])) {
            $params = array();
            foreach ($_GET as $key => $value) {
                $params[$key] = $value;
            }
            $this->pushBlik($params);
        }

    }

    public function getForm()
    {
        $result = $this->getBlikSelectionForm();
        echo $result;
    }

    public function pushBlik($data)
    {
        $params[static::TITLE] = $data[static::TITLE];
        if (!isset($data[static::REGISTER]) || (isset($data[static::REGISTER]) && $data[static::REGISTER] !== '0')) {
            $params[static::ALIAS][0] = $this->getAlias();
            if (isset($data[static::ALIAS_KEY])) {
                $params[static::ALIAS][0]['key'] = $data[static::ALIAS_KEY];
            }
        }
        if (isset($data[static::CODE])) {
            $params[static::CODE] = $data[static::CODE];
        }

        $res = $this->handleBlikPayment($params);
        if (is_array($res)) {
            foreach ($res as $key => $value) {
                foreach ($value as $key1 => $value1) {

                    echo ($value1) . ",";
                }
            }
        } else {
            $convertedRes = ($res) ? '1' : '0';
            echo $convertedRes . ",";
        }

    }

    private function getAlias()
    {
        return array(
            'value' => 'TPAY_NONUNIQUE_ALIAS',
            'type'  => 'UID',
        );
    }

    public function createTransaction()
    {
        $config = array(
            'opis'                => 'transakcja testowa api',
            'kwota'               => 0.10,
            'crc'                 => 'test',
            'kanal'               => 64,
            'nazwisko'            => 'kowalski',
            'email'               => 'test@tpay.com',
            'akceptuje_regulamin' => 1,
        );
        $params[static::TITLE] = $this->create($config)[static::TITLE];
        echo $params[static::TITLE] . ",";
        return $params;

    }

}

(new OneClick())->getBlikSelectionForm();
