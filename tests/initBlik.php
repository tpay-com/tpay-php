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
            'nvidia8800',
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
        if (isset($_GET['tryOneClick'])) {
            $params = $this->create();
            $this->pushBlik($params);
        }
        
        if (isset($_GET['code']) || isset($_GET['title']) || isset($_GET['aliasKey'])) {
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
            'kwota'               => 1.00,
            'crc'                 => 'piotr',
            'kanal'               => 64,
            'nazwisko'            => 'kowalski',
            'email'               => 'piotr123.jozwiak@tpay.com',
            'akceptuje_regulamin' => 1,
        );
        $params['title'] = $this->tpayApi->create($config)['title'];
        echo $params['title'] . ",";
        return $params;
        
    }
    
    public function pushBlik($data)
    {
        $params['title'] = $data['title'];
        if (!isset($data['register']) || (isset($data['register']) && $data['register'] !== '0')) {
            $params['alias'][0] = $this->getAlias();
            if (isset($data['aliasKey'])) {
                $params['alias'][0]['key'] = $data['aliasKey'];
            }
        }
        if (isset($data['code'])) {
            $params['code'] = $data['code'];
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