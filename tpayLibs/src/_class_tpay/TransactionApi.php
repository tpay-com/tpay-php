<?php

/*
 * Created by tpay.com
 */
namespace tpayLibs\src\_class_tpay;

use tpayLibs\src\_class_tpay\PaymentForms\PaymentBasicForms;
use tpayLibs\src\_class_tpay\Utilities\TException;
use tpayLibs\src\_class_tpay\Utilities\Util;
use tpayLibs\src\Dictionaries\ErrorCodes\TransactionApiErrors;

/**
 * Class TransactionAPI
 *
 * Includes group of methods responsible for connection with tpay Transaction API
 *
 * @package tpay
 */
class TransactionApi extends PaymentBasicForms
{
    const RESULT = 'result';
    const TITLE = 'title';
    const ERROR_CODE = 'err_code';
    const REPORT = 'report';
    const PACK_ID = 'pack_id';
    const ERR = 'err';
    const AMOUNT = 'amount';
    const PACKS = 'packs';
    const TRANSFERS = 'transfers';
    const ALIAS = 'alias';
    const CODE = 'code';

    protected $apiURL = 'https://secure.tpay.com/api/gw/';

    /**
     * List of errors
     * @var array
     */
    private $errorCodes = TransactionApiErrors::ERROR_CODES;

    /**
     * PaymentTransactionAPI class constructor
     */
    public function __construct()
    {
        parent::__construct();

        $this->isNotEmptyString($this->trApiKey, 'Transaction API key');
        $this->isNotEmptyString($this->trApiPass, 'Transaction API password');
    }

    /**
     * Create new transaction
     * More information about config fields @see FieldsConfigValidator::$panelPaymentRequestField
     *
     * @param array $config transaction config
     *
     * @return array
     *
     * @throws TException
     */
    public function create($config)
    {
        $url = $this->apiURL . $this->trApiKey . '/transaction/create';

        $config = $this->prepareConfig($config, true);
        Util::log('Transaction create request params', print_r($config, true));
        $response = $this->requests($url, $config);
        Util::log('Transaction create response', print_r($response, true));

        if ($response[static::RESULT] !== 1) {
            throw new TException(sprintf('Error in %s', $response['err']));
        }
        return $response;
    }

    /**
     * Execute request to tpay transaction API
     *
     * @param string $url url
     * @param array $params post params
     *
     * @return bool|mixed
     */
    public function requests($url, $params)
    {
        $params['api_password'] = $this->trApiPass;

        return parent::requests($url, $params);
    }

    /**
     * Get information about transaction
     *
     * @return array
     *
     * @throws TException
     */
    public function get()
    {
        $url = $this->apiURL . $this->trApiKey . '/transaction/get';

        $response = $this->requests($url, array(static::TITLE => $this->transactionID));

        $this->checkError($response);
        return $response;
    }

    /**
     * Check api response error
     *
     * @param array $response
     *
     * @throws TException
     */
    public function checkError($response)
    {
        if ($response[static::RESULT] !== 1) {
            if (isset($response[static::ERR]) && isset($this->errorCodes[$response[static::ERR]])) {
                throw new TException($this->errorCodes[$response[static::ERR]]);
            } elseif (isset($response[static::ERROR_CODE]) && isset($this->errorCodes[$response[static::ERROR_CODE]])) {
                throw new TException($this->errorCodes[$response[static::ERROR_CODE]]);
            } else {
                throw new TException('Unexpected error');
            }
        }
    }

}
