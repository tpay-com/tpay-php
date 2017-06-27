<?php

/*
 * Created by tpay.com
 */
namespace tpay;

/**
 * Class TransactionAPI
 *
 * Includes group of methods responsible for connection with tpay Transaction API
 *
 * @package tpay
 */
class TransactionAPI
{
    const RESULT = 'result';
    const TITLE = 'title';
    const ERROR_CODE = 'error_code';
    const REPORT = 'report';
    const PACK_ID = 'pack_id';
    const ERR = 'err';
    const AMOUNT = 'amount';
    const PACKS = 'packs';
    const TRANSFERS = 'transfers';
    const ALIAS = 'alias';
    const CODE = 'code';
    /**
     * Api key
     * @var string
     */
    private $apiKey;

    /**
     * Api pass
     * @var string
     */
    private $apiPass;

    /**
     * Merchant id
     * @var int
     */
    private $merchantId;

    /**
     * Merchant secret
     * @var string
     */
    private $merchantSecret;

    /**
     * tpay api url
     * @var string
     */
    private $apiURL = 'https://secure.tpay.com/api/gw/';

    /**
     * List of errors
     * @var array
     */
    private $errorCodes = array(
        'ERR44' => 'Invalid transaction id',
        'ERR51' => 'Can\'t create transaction for this channel',
        'ERR52' => 'Error create a transaction, try again later',
        'ERR53' => 'Invalid input data',
        'ERR54' => 'Transation with this id not exists',
        'ERR55' => 'Invalid range or format for dates',
        'ERR99' => 'General error',
        'ERR98' => 'Login error, invalid key or password',
        'ERR97' => 'No metod',
        'ERR31' => 'Access disabled',
        'ERR32' => 'Access forbidden',

        'ERR96' => 'Invalid transaction id or can\'t make refund',

        'ERR4'  => 'Nie został przesłany plik o rozszerzeniu csv',
        'ERR6'  => 'Niepoprawna suma kontrolna (sign)',
        'ERR7'  => 'Niepoprawny format linii',
        'ERR8'  => 'Niepoprawny format numeru rachunku',
        'ERR9'  => 'Nazwa odbiorcy nie może być pusta',
        'ERR10' => 'Nazwa odbiorcy 1 jest za długa - maks. 35 znaków',
        'ERR11' => 'Nazwa odbiorcy 2 jest za długa - maks. 35 znaków',
        'ERR12' => 'Nazwa odbiorcy 3 jest za długa - maks. 35 znaków',
        'ERR13' => 'Nazwa odbiorcy 4 jest za długa - maks. 35 znaków',
        'ERR14' => 'Niepoprawny format kwoty',
        'ERR15' => 'Pole tytuł 1 nie może być puste',
        'ERR16' => 'Pole tytuł 1 jest za długie - maks. 35 znaków',
        'ERR17' => 'Pole tytuł 2 jest za długie - maks. 35 znaków',
        'ERR18' => 'Błąd wewnętrzny',
        'ERR19' => 'Nie udało się załadować pliku o rozszerzeniu csv',
        'ERR20' => 'Błąd przetwarzania przelewów',
        'ERR21' => 'Niepoprawny packId lub nie znaleziono paczki',
        'ERR22' => 'Błąd przy autoryzacji paczki',
        'ERR23' => 'Za mało środków do autoryzacji paczki',
        'ERR24' => 'Paczka została już autoryzowana',

    );

    /**
     * PaymentTransactionAPI class constructor
     *
     * @param string $apiKey api key
     * @param string $apiPass api password
     * @param int $merchantId merchant id
     * @param string $merchantSecret merchant secret
     *
     * @throws TException
     */
    public function __construct($apiKey, $apiPass, $merchantId, $merchantSecret)
    {
        if (!is_string($apiKey) || strlen($apiKey) === 0) {
            throw new TException('Invalid API key');
        }
        if (!is_string($apiPass) || strlen($apiPass) === 0) {
            throw new TException('Invalid API pass');
        }

        $this->merchantId = $merchantId;
        $this->merchantSecret = $merchantSecret;
        $this->apiKey = $apiKey;
        $this->apiPass = $apiPass;

        require_once(dirname(__FILE__) . '/Util.php');

        Util::loadClass('Curl');
        Util::loadClass('Exception');
        Util::loadClass('Validate');
        Util::loadClass('Lang');
        Util::checkVersionPHP();

        Validate::validateMerchantId($this->merchantId);
        Validate::validateMerchantSecret($this->merchantSecret);
    }

    /**
     * Create new transaction
     * More information about config fields @see Validate::$panelPaymentRequestField
     *
     * @param array $config transaction config
     *
     * @return array
     *
     * @throws TException
     */
    public function create($config)
    {
        $url = $this->apiURL . $this->apiKey . '/transaction/create';

        Validate::validateConfig(Validate::PAYMENT_TYPE_BASIC_API, $config);
        $config = $this->prepareConfig($config);
        Util::log('Transaction create request params', print_r($config, true));
        $response = $this->requests($url, $config);
        Util::log('Transaction create response', print_r($response, true));
        if ($response[static::RESULT] !== 1) {
            throw new TException(sprintf('Error in %s', $response['desc']));
        }
        return $response;
    }

    /**
     * Prepare and validate passed config
     *
     * @param array $config
     *
     * @return array
     *
     * @throws TException
     */
    private function prepareConfig($config)
    {
        $ready = Validate::validateConfig(Validate::PAYMENT_TYPE_BASIC, $config);

        $ready['md5sum'] = md5($this->merchantId . $ready['kwota'] . $ready['crc'] . $this->merchantSecret);
        $ready['id'] = $this->merchantId;

        return $ready;
    }

    /**
     * Execute request to tpay transaction API
     *
     * @param string $url url
     * @param array $params post params
     *
     * @return bool|mixed
     */
    private function requests($url, $params)
    {
        $params['api_password'] = $this->apiPass;

        return Curl::doCurlRequest($url, $params);
    }

    public function handleBlikPayment($params)
    {
        if (!is_array($params) || count($params) <= 0) {
            throw new TException('Invalid or empty input parameters');
        }
        if (isset($params['code']) && !isset($params['alias'])) {
            $params['code'] = (int)$params['code'];
            $response = $this->handleBlik(Validate::PAYMENT_TYPE_BLIK_T6STANDARD, $params);
        } elseif (isset($params['code']) && isset($params['alias'])) {
            $params['code'] = (int)$params['code'];
            $response = $this->handleBlik(Validate::PAYMENT_TYPE_BLIK_T6REGISTER, $params);
        } else {
            $response = $this->handleBlik(Validate::PAYMENT_TYPE_BLIK_ALIAS, $params);
        }

        switch ($response['result']) {
            case 1:
                $success = true;
                break;
            case 0:
                if (isset($response[static::ERR]) && $response[static::ERR] === 'ERR82') {
                    $apps = array();
                    foreach ($response['availableUserApps'] as $key => $value) {
                        $apps[] = get_object_vars($value);
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
        $params = Validate::validateConfig($type, $params);

        switch ($type) {
            case Validate::PAYMENT_TYPE_BLIK_T6STANDARD:
                $response = $this->blik($params[self::CODE], $params[static::TITLE]);
                break;
            case Validate::PAYMENT_TYPE_BLIK_T6REGISTER:
                $response = $this->blik($params[self::CODE], $params[static::TITLE], $params[static::ALIAS]);
                break;
            case Validate::PAYMENT_TYPE_BLIK_ALIAS:
                $response = $this->blik('', $params[static::TITLE], $params[static::ALIAS]);
                break;
            default:
                throw new TException('Undefined transaction type!');
        }
        return $response;
    }

    public function blik($code = '', $title, $alias = '')
    {
        if (empty($title) || !is_string($title)) {
            throw new TException('Transaction title is empty or invalid');
        }
        $config['title'] = $title;
        if (!empty($code)) {
            $config[self::CODE] = $code;
        }
        if (!empty($alias)) {
            $config[self::ALIAS] = $alias;
        }
        Util::log('Blik request params', print_r($config, true));
        $url = $this->apiURL . $this->apiKey . '/transaction/blik';
        $response = $this->requests($url, $config);
        Util::log('Blik response', print_r($response, true));
        return $response;
    }


    /**
     * Get information about transaction
     *
     * @param string $transactionId transaction id
     *
     * @return array
     *
     * @throws TException
     */
    public function get($transactionId)
    {
        $url = $this->apiURL . $this->apiKey . '/transaction/get';

        $response = $this->requests($url, array(static::TITLE => $transactionId));

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
    private function checkError($response)
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

    /**
     * Get transactions report
     *
     * @param string $fromDate start date in format YYYY-MM-DD
     * @param string|bool $toDate end date in format YYYY-MM-DD
     *
     * @return array
     *
     * @throws TException
     */
    public function report($fromDate, $toDate = false)
    {
        $url = $this->apiURL . $this->apiKey . '/transaction/report';
        $postData = array(
            'from_date' => $fromDate
        );

        if ($toDate !== false) {
            $postData['to_date'] = $toDate;
        }

        $response = $this->requests($url, $postData);

        $this->checkError($response);
        $response[static::REPORT] = base64_decode($response[static::REPORT]);
        return $response;
    }

    /**
     * Refund all amount to customer
     *
     * @param string $transactionId transaction id
     *
     * @return bool
     *
     * @throws TException
     */
    public function refund($transactionId)
    {
        $url = $this->apiURL . $this->apiKey . '/chargeback/transaction';

        $response = $this->requests($url, array(static::TITLE => $transactionId));

        $this->checkError($response);

        return true;
    }

    /**
     * Refund custom amount to customer
     *
     * @param string $transactionId transaction id
     * @param float $amount refund amount
     *
     * @return bool
     *
     * @throws TException
     */
    public function refundAny($transactionId, $amount)
    {
        $url = $this->apiURL . $this->apiKey . '/chargeback/any';

        $postData = array(
            static::TITLE       => $transactionId,
            'chargeback_amount' => $amount,
        );
        $response = $this->requests($url, $postData);

        $this->checkError($response);

        return true;
    }

    /**
     * Create mass payment
     *
     * @param string $csv content of csv file
     *
     * @return array
     * @throws TException
     */
    public function masspaymentCreate($csv)
    {
        $url = $this->apiURL . $this->apiKey . '/masspayment/create';

        $csvEncode = base64_encode($csv);

        $postData = array(
            'csv'  => $csvEncode,
            'sign' => sha1($this->merchantId . $csv . $this->merchantSecret),
        );
        $response = $this->requests($url, $postData);

        $this->checkError($response);

        return $response;
    }

    /**
     * Authorize mass payment
     *
     * @param string $packId pack id from masspaymentCreate
     *
     * @return array
     * @throws TException
     */
    public function masspaymentAuthorize($packId)
    {
        $url = $this->apiURL . $this->apiKey . '/masspayment/authorize';

        $postData = array(
            static::PACK_ID => $packId,
        );
        $response = $this->requests($url, $postData);

        $this->checkError($response);

        return $response;
    }

    /**
     * Get information about packs
     *
     * @param string|bool $packId pack id from masspaymentCreate
     * @param string|bool $fromDate start date in format YYYY-MM-DD
     * @param string|bool $toDate end date in format YYYY-MM-DD
     *
     * @return array
     * @throws TException
     */
    public function masspaymentPacks($packId = false, $fromDate = false, $toDate = false)
    {
        $url = $this->apiURL . $this->apiKey . '/masspayment/packs';

        $postData = array();

        if ($packId !== false) {
            $postData[static::PACK_ID] = $packId;
        }
        if ($fromDate !== false) {
            $postData['fromDate'] = $fromDate;
        }
        if ($toDate !== false) {
            $postData['toDate'] = $toDate;
        }

        $response = $this->requests($url, $postData);

        $this->checkError($response);
        $xml = simplexml_load_string($response[static::PACKS]);
        $response[static::PACKS] = unserialize(serialize(json_decode(json_encode((array)$xml), 1)));
        return $response;
    }

    /**
     * Authorize mass payment
     *
     * @param string $packId pack id from masspaymentCreate
     * @param string $trId transaction id
     *
     * @return array
     * @throws TException
     */
    public function masspaymentTransfers($packId, $trId)
    {
        $url = $this->apiURL . $this->apiKey . '/masspayment/transfers';

        $postData = array(
            static::PACK_ID => $packId,
            'trId'          => $trId,
        );
        $response = $this->requests($url, $postData);

        $this->checkError($response);
        $xml = simplexml_load_string($response[static::TRANSFERS]);
        $response[static::TRANSFERS] = unserialize(serialize(json_decode(json_encode((array)$xml), 1)));
        return $response;
    }

}
