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
    private $channelDAC = 157;


    /**
     * Register new DAC transaction and create HTML block with information
     * about transaction and merchant data
     *
     * @param array $config transaction config
     * @param string $merchantData merchant data
     *
     * @return array
     */
    public function registerTransaction($config, $merchantData = '')
    {
        $config['group'] = $this->channelDAC;
        $transactionData = $this->create($config);
        $transactionData['crc'] = $config['crc'];

        return array(
            'html' => $this->getConfirmationBlock($transactionData, $merchantData),
            'data' => $transactionData
        );
    }

    /**
     * Get HTML string with confirmation block
     *
     * @param array $transactionData registered transaction data from tpay server
     * @param string $merchantData merchant data to
     *
     * @return string
     */
    private function getConfirmationBlock($transactionData, $merchantData)
    {
        $data = array(
            'merchant_data'    => $merchantData,
            'transaction'      => $transactionData
        );

        return Util::parseTemplate('dacConfirmation', $data);
    }
}
