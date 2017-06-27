<?php

/*
 * Created by tpay.com
 */

namespace tpayLibs\src\_class_tpay;

use tpayLibs\src\_class_tpay\Utilities\Util;

/**
 * Class DACPaymentOptions
 *
 * Class handles DAC payment. System generate account number where client should send funds.
 *
 * @package tpay
 */

class PaymentDac extends TransactionApi
{

    /**
     * DAC payment chanel
     * @var int
     */
    private $channelDAC = 29;


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
        $config['kanal'] = $this->channelDAC;
        $transactionData = $this->create($config);
        $transactionData['crc'] = $config['crc'];

        return array(
            'html' => $this->getConfirmationBlock($transactionData, $staticFilesURL, $merchantData),
            'data' => $transactionData
        );
    }

    /**
     * Get HTML string with confirmation block
     *
     * @param array $transactionData registered transaction data from tpay server
     * @param string $staticFilesURL browser url to library
     * @param string $merchantData merchant data to
     *
     * @return string
     */
    private function getConfirmationBlock($transactionData, $staticFilesURL, $merchantData)
    {
        $data = array(
            'static_files_url' => $staticFilesURL,
            'merchant_data'    => $merchantData,
            'transaction'      => $transactionData
        );

        return Util::parseTemplate('dac/_tpl/confirmation', $data);
    }
}
