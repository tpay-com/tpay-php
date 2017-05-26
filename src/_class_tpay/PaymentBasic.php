<?php

/*
 * Created by tpay.com
 */

namespace tpay;

/**
 * Class PaymentBasic
 *
 * Class handles bank transfer payment through tpay panel
 *
 * @package tpay
 */
class PaymentBasic
{
    const REMOTE_ADDR = 'REMOTE_ADDR';
    /**
     * @var string
     */

    const ACTIONURL = 'action_url';
    /**
     * @var string
     */
    const FIELDS = 'fields';
    /**
     * @var string
     */
    const PAYMENTFORM = 'paymentForm';
    /**
     * Merchant id
     * @var int
     */
    protected $merchantId = '[MERCHANT_ID]';
    /**
     * tpay payment url
     * @var string
     */
    protected $apiURL = 'https://secure.tpay.com';
    /**
     * Merchant secret
     * @var string
     */
    private $merchantSecret = '[MERCHANT_SECRET]';
    /**
     * tpay response IP
     * @var string
     */
    private $secureIP = array(
        '195.149.229.109',
        '148.251.96.163',
        '178.32.201.77',
        '46.248.167.59',
        '46.29.19.106'
    );
    /**
     * If false library not validate tpay server IP
     * @var bool
     */
    private $validateServerIP = true;
    /**
     * Path to template directory
     * @var string
     */
    private $templateDir = 'common/_tpl/';
    /**
     * URL to tpay regulations file
     * @var string
     */
    private $regulationURL = 'https://secure.tpay.com/regulamin.pdf';

    /**
     * PaymentBasic class constructor for payment:
     * - basic from tpay panel
     * - with bank selection in merchant shop
     * - eHat
     *
     * @param string|bool $merchantId merchant id
     * @param string|bool $merchantSecret merchant secret
     */
    public function __construct($merchantId = false, $merchantSecret = false)
    {
        if ($merchantId !== false) {
            $this->merchantId = $merchantId;
        }
        if ($merchantSecret !== false) {
            $this->merchantSecret = $merchantSecret;
        }

        require_once(dirname(__FILE__) . '/Util.php');

        Util::loadClass('Curl');
        Util::loadClass('Validate');
        Util::loadClass('Exception');
        Util::loadClass('Lang');
        Util::checkVersionPHP();
        Validate::validateMerchantId($this->merchantId);
        Validate::validateMerchantSecret($this->merchantSecret);
    }

    /**
     * Disabling validation of payment notification server IP
     * Validation of tpay server ip is very important.
     * Use this method only in test mode and be sure to enable validation in production.
     */
    public function disableValidationServerIP()
    {
        $this->validateServerIP = false;
    }

    /**
     * Enabling validation of payment notification server IP
     */
    public function enableValidationServerIP()
    {
        $this->validateServerIP = true;
    }

    /**
     * Check cURL request from tpay server after payment.
     * This method check server ip, required fields and md5 checksum sent by payment server.
     * Display information to prevent sending repeated notifications.
     *
     * @param string $paymentType optional payment type default is 'basic'
     *
     * @throws TException
     *
     * @return array
     */
    public function checkPayment($paymentType = Validate::PAYMENT_TYPE_BASIC)
    {
        Util::log('check basic payment', '$_POST: ' . "\n" . print_r($_POST, true));

        $res = Validate::getResponse($paymentType);

        $checkMD5 = $this->checkMD5(
            $res['md5sum'],
            $res['tr_id'],
            number_format($res['tr_amount'], 2, '.', ''),
            $res['tr_crc']
        );
        Util::logLine('Check MD5: ' . (int)$checkMD5);

        if ($this->validateServerIP === true && $this->checkServer() === false) {
            throw new TException('Request is not from secure server');
        }

        if ($checkMD5 === false) {
            throw new TException('MD5 checksum is invalid');
        }
        echo 'TRUE';

        return $res;
    }

    /**
     * Check md5 sum to validate tpay response.
     * The values of variables that md5 sum includes are available only for
     * merchant and tpay system.
     *
     * @param string $md5sum md5 sum received from tpay
     * @param string $transactionId transaction id
     * @param float $transactionAmount transaction amount
     * @param string $crc transaction crc
     *
     * @return bool
     */
    private function checkMD5($md5sum, $transactionId, $transactionAmount, $crc)
    {
        if (!is_string($md5sum) || strlen($md5sum) !== 32) {
            return false;
        }

        return ($md5sum === md5($this->merchantId . $transactionId .
                $transactionAmount . $crc . $this->merchantSecret));
    }
    
    /**
     * Check if request is called from secure tpay server
     *
     * @return bool
     */
    private function checkServer()
    {
        if (!isset($_SERVER[static::REMOTE_ADDR])
            || !in_array($_SERVER[static::REMOTE_ADDR], $this->secureIP)
        ) {
            if (!isset($_SERVER['HTTP_X_FORWARDED_FOR'])
                || !in_array($_SERVER['HTTP_X_FORWARDED_FOR'], $this->secureIP)
            ) {
                return false;
            }
        }
        return true;
    }
    
    /**
     * Check cURL request from tpay server after payment.
     * This method check server ip sent by payment server.
     * Display information to prevent sending repeated notifications.
     *
     * @param string $paymentType optional payment type default is 'basic'
     *
     * @throws TException
     *
     * @return array
     */
    public function checkAliasNotification($paymentType = Validate::ALIAS_BLIK)
    {
        Util::log('check blik notification', '$_POST: ' . "\n" . print_r($_POST, true));
        
        $res = Validate::getResponse($paymentType);
        
        if ($this->validateServerIP === true && $this->checkServer() === false) {
            throw new TException('Request is not from secure server');
        }
        
        echo 'TRUE';
        
        return $res;
    }
    
    /**
     * Create HTML form for EHat payment based on transaction config
     * More information about config fields @see Validate::$panelPaymentRequestFields
     *
     * @param array $config transaction config
     *
     * @return string
     */
    public function getEHatForm($config)
    {
        $config = $this->prepareConfig($config);

        $config['kanal'] = 58;
        $config['akceptuje_regulamin'] = 1;

        $data = array(
            static::ACTIONURL => $this->apiURL,
            static::FIELDS    => $config,
        );

        return Util::parseTemplate($this->templateDir . static::PAYMENTFORM, $data);
    }

    /**
     * Validate passed payment config and add required elements with merchant id and md5 sum
     * More information about config fields @see Validate::$panelPaymentRequestField
     *
     * @param array $config transaction config
     *
     * @return array
     *
     * @throws TException
     */
    public function prepareConfig($config)
    {
        $ready = Validate::validateConfig(Validate::PAYMENT_TYPE_BASIC, $config);

        $ready['md5sum'] = md5($this->merchantId . $ready['kwota'] . $ready['crc'] . $this->merchantSecret);
        $ready['id'] = $this->merchantId;

        return $ready;
    }

    /**
     * Create HTML form for basic panel payment based on transaction config
     * More information about config fields @see Validate::$panelPaymentRequestFields
     *
     * @param array $config transaction config
     *
     * @return string
     */
    public function getTransactionForm($config)
    {
        $config = $this->prepareConfig($config);

        $data = array(
            static::ACTIONURL => $this->apiURL,
            static::FIELDS    => $config,
        );

        return Util::parseTemplate($this->templateDir . static::PAYMENTFORM, $data);
    }


    public function getTransactionFormConfig($config)
    {
        return $this->prepareConfig($config);
    }

    /**
     * Create HTML form for payment with bank selection based on transaction config
     * More information about config fields @see Validate::$panelPaymentRequestFields
     *
     * @param array $config transaction config
     * @param bool $smallList type of bank selection list big icons or small form with select
     * @param bool $showRegulations show accept regulations input
     *
     * @return string
     *
     * @throws TException
     */
    public function getBankSelectionForm($config, $smallList = false, $showRegulations = true)
    {
        $config = $this->prepareConfig($config);
        $config['kanal'] = 0;
        $config['akceptuje_regulamin'] = ($showRegulations) ? 0 : 1;

        $data = array(
            static::ACTIONURL => $this->apiURL,
            static::FIELDS    => $config,
        );

        $form = Util::parseTemplate($this->templateDir . static::PAYMENTFORM, $data);

        $data = array(
            'merchant_id'               => $this->merchantId,
            'regulation_url'            => $this->regulationURL,
            'show_regulations_checkbox' => $showRegulations,
            'form'                      => $form
        );
        if ($smallList) {
            $templateFile = 'bankSelectionList';
        } else {
            $templateFile = 'bankSelection';
        }
        return Util::parseTemplate($this->templateDir . $templateFile, $data);
    }
    
    /**
     * Create HTML form for payment with blik selection based on transaction config
     * More information about config fields @see Validate::$blikPaymentRequestFields
     *
     * @param string $alias alias of registered user for One Click transactions
     *
     * @return string
     *
     * @throws TException
     */
    public function getBlikSelectionForm()
    {
        $data = array(
            'regulation_url' => $this->regulationURL,
        );
        
        return Util::parseTemplate($this->templateDir . 'blikForm', $data);
    }
    
    /**
     * Check md5 sum to confirm value of payment amount
     *
     * @param string $md5sum md5 sum received from tpay
     * @param string $transactionId transaction id
     * @param string $transactionAmount transaction amount
     * @param string $crc transaction crc
     *
     * @throws TException
     */
    public function validateSign($md5sum, $transactionId, $transactionAmount, $crc)
    {
        if ($md5sum !== md5($this->merchantId . $transactionId . $transactionAmount . $crc . $this->merchantSecret)) {
            throw new TException('Invalid checksum');
        }
    }
}
