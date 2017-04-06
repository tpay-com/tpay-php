<?php

/**
 * Created by PhpStorm.
 * User: user
 * Date: 31.03.2017
 * Time: 17:31
 */
error_reporting(E_ALL);
ini_set('display_errors', 1);

class OneClick
{
    
    const TITLE = 'title';
    
    const ALIAS_KEY = 'aliasKey';
    
    const CODE = 'code';
    
    const REGISTER = 'register';
    
    const ALIAS = 'alias';
    
    public function __construct()
    {
        include_once '../src/_class_tpay/transactionApi.php';
        include_once '../src/_class_tpay/validate.php';
        include_once '../src/_class_tpay/curl.php';
        include_once '../src/_class_tpay/util.php';
        include_once '../src/_class_tpay/lang.php';
        include_once '../src/_class_tpay/exception.php';
        include_once '../src/_class_tpay/paymentBasic.php';
        
        $this->tpayApi = new \tpay\TransactionAPI (
            '158ae0714578f5ab76bf6c0374cb1508b98ece5d',
            'testtpay123',
            25223,
            'testtpay'
        );
        $this->tpayBasic = new \tpay\PaymentBasic (
            25223,
            'testtpay'
        );
        if (empty($_GET)) {
            $this->getForm();
        }
        if (isset($_GET['tryOneClick']) && isset($_GET['title'])) {
            $params['title'] = $_GET['title'];
            $this->pushBlik($params);
        }
        if (isset($_GET['getTitle'])) {
            $this->create();
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
        $result = $this->tpayBasic->getBlikSelectionForm();
        var_dump($result);
    }
    
    public function create()
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
        $params[static::TITLE] = $this->tpayApi->create($config)[static::TITLE];
        echo $params[static::TITLE] . ",";
        return $params;
        
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
       
        $res = $this->tpayApi->handleBlikPayment($params);
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
    
}

new OneClick();
