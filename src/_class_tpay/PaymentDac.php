<?php

/*
 * Created by tpay.com
 */

namespace tpay;

/**
 * Class PaymentDAC
 *
 * Class handles DAC payment. System generate account number where client should send funds.
 *
 * @package tpay
 */
class PaymentDAC
{
    /**
     * Merchant id
     * @var int
     */
    private $merchantId = '[MERCHANT_ID]';

    /**
     * Merchant secret
     * @var string
     */
    private $merchantSecret = '[MERCHANT_SECRET]';

    /**
     * Transaction API key
     * @var string
     */
    private $apiKey = '[TRANSACTION_API_KEY]';

    /**
     * Transaction API password
     * @var string
     */
    private $apiPass = '[TRANSACTION_API_PASS]';

    /**
     * DAC payment chanel
     * @var int
     */
    private $channelDAC = 29;

    /**
     * PaymentBasic class constructor
     *
     * @param string|bool $merchantId       merchant id
     * @param string|bool $merchantSecret   merchant secret
     * @param string|bool $apiKey           transaction API key
     * @param string|bool $apiPass          transaction API password
     */
    public function __construct($merchantId = false, $merchantSecret = false, $apiKey = false, $apiPass = false)
    {
        if($merchantId !== false) {
            $this->merchantId = $merchantId;
        }
        if($merchantSecret !== false) {
            $this->merchantSecret = $merchantSecret;
        }
        if($apiKey !== false) {
            $this->apiKey = $apiKey;
        }
        if($apiPass !== false) {
            $this->apiPass = $apiPass;
        }

        require_once(dirname(__FILE__) . '/Util.php');

        Util::loadClass('Validate');
        Util::loadClass('Exception');
        Util::loadClass('Lang');
        Util::loadClass('TransactionApi');
        Util::checkVersionPHP();

        Validate::validateMerchantId($this->merchantId);
        Validate::validateMerchantSecret($this->merchantSecret);
    }

    /**
     * Register new DAC transaction and create HTML block with information
     * about transaction and merchant data
     *
     * @param array $config transaction config
     * @param string $staticFilesURL static files url
     * @param string $merchantData merchant data
     *
     * @return array
     */
    public function registerTransaction($config, $staticFilesURL = '', $merchantData = '')
    {
        $api = new TransactionAPI($this->apiKey, $this->apiPass, $this->merchantId, $this->merchantSecret);

        $config['kanal'] = $this->channelDAC;
        $transactionData = $api->create($config);
        $transactionData['crc'] = $config['crc'];

        return array(
            'html' => $this->getConfirmationBlock($transactionData, $staticFilesURL, $merchantData),
            'data' => $transactionData
        );
    }

    /**
     * Get HTML string with confirmation block
     *
     * @param array  $transactionData registered transaction data from tpay server
     * @param string $staticFilesURL browser url to library
     * @param string $merchantData merchant data to
     *
     * @return string
     */
    private function getConfirmationBlock($transactionData, $staticFilesURL, $merchantData)
    {
        $data = array(
            'static_files_url'  => $staticFilesURL,
            'merchant_data'     => $merchantData,
            'transaction'       => $transactionData
        );

        return Util::parseTemplate('dac/_tpl/confirmation', $data);
    }
}
