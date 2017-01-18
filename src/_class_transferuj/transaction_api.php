<?php
namespace Transferuj;

/**
 * Class TransactionAPI
 *
 * Includes group of methods responsible for connection with Transferuj Transaction API
 *
 * @package Transferuj
 */
class TransactionAPI
{
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
     * Transferuj api url
     * @var string
     */
    private $apiURL = 'https://secure.transferuj.pl/api/gw/';

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
        'ERR21' => 'Niepoprawny pack_id lub nie znaleziono paczki',
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

        require_once(dirname(__FILE__) . '/util.php');

        Util::loadClass('curl');
        Util::loadClass('exception');
        Util::loadClass('validate');
        Util::loadClass('lang');
        Util::checkVersionPHP();

        Validate::validateMerchantId($this->merchantId);
        Validate::validateMerchantSecret($this->merchantSecret);
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
     * Execute request to Transferuj transaction API
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

    /**
     * Check api response error
     *
     * @param array $response
     *
     * @throws TException
     */
    private function checkError($response)
    {
        if ($response['result'] !== 1) {
            if (isset($response['err']) && isset($this->errorCodes[$response['err']])) {
                throw new TException($this->errorCodes[$response['err']]);
            } else if (isset($response['error_code']) && isset($this->errorCodes[$response['error_code']])) {
                throw new TException($this->errorCodes[$response['error_code']]);
            } else {
                throw new TException('Unexpected error');
            }
        }
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
        $res = $this->requests($url, $config);

        $response = array(
            'result'         => (int)Util::findSubstring('/<result>([0-1]*)<\/result>/', $res),
            'title'          => Util::findSubstring('/<title>(.*)<\/title>/', $res),
            'amount'         => (float)Util::findSubstring('/<amount>([0-9\.]*)<\/amount>/', $res),
            'account_number' => Util::findSubstring('/<account_number>([0-9]*)<\/account_number>/', $res),
            'online'         => (int)Util::findSubstring('/<online>([0-1]*)<\/online>/', $res),
            'url'            => Util::findSubstring('/<url>(.*)<\/url>/', $res),
            'desc'           => Util::findSubstring('/<desc>(.*)<\/desc>/', $res),
        );

        if ($response['result'] !== 1) {
            throw new TException(sprintf('Error in %s', $response['desc']));
        }
        return $response;
    }

    /**
     * Get information about transaction
     *
     * @param string $transaction_id transaction id
     *
     * @return array
     *
     * @throws TException
     */
    public function get($transaction_id)
    {
        $url = $this->apiURL . $this->apiKey . '/transaction/get';

        $res = $this->requests($url, array('title' => $transaction_id));

        $response = array(
            'result'          => (int)Util::findSubstring('/<result>([0-1]*)<\/result>/', $res),
            'status'          => Util::findSubstring('/<status>(.*)<\/status>/', $res),
            'error_code'      => Util::findSubstring('/<error_code>(.*)<\/error_code>/', $res),
            'err'             => Util::findSubstring('/<err>(.*)<\/err>/', $res),
            'start_time'      => Util::findSubstring('/<start_time>(.*)<\/start_time>/', $res),
            'payment_time'    => Util::findSubstring('/<payment_time>(.*)<\/payment_time>/', $res),
            'chargeback_time' => Util::findSubstring('/<chargeback_time>(.*)<\/chargeback_time>/', $res),
            'channel'         => (int)Util::findSubstring('/<channel>([0-9]*)<\/channel>/', $res),
            'test_mode'       => (int)Util::findSubstring('/<test_mode>([0-1]*)<\/test_mode>/', $res),
            'amount'          => (float)Util::findSubstring('/<amount>([0-9\.]*)<\/amount>/', $res),
            'amount_paid'     => (float)Util::findSubstring('/<amount_paid>([0-9\.]*)<\/amount_paid>/', $res),
            'name'            => Util::findSubstring('/<name>(.*)<\/name>/', $res),
            'address'         => Util::findSubstring('/<address>(.*)<\/address>/', $res),
            'code'            => Util::findSubstring('/<code>(.*)<\/code>/', $res),
            'city'            => Util::findSubstring('/<city>(.*)<\/city>/', $res),
            'email'           => Util::findSubstring('/<email>(.*)<\/email>/', $res),
            'country'         => Util::findSubstring('/<country>(.*)<\/country>/', $res),
        );

        $this->checkError($response);
        return $response;
    }

    /**
     * Get transactions report
     *
     * @param string $from_date start date in format YYYY-MM-DD
     * @param string|bool $to_date end date in format YYYY-MM-DD
     *
     * @return array
     *
     * @throws TException
     */
    public function report($from_date, $to_date = false)
    {
        $url = $this->apiURL . $this->apiKey . '/transaction/report';
        $postData = array(
            'from_date' => $from_date
        );

        if ($to_date !== false) {
            $postData['to_date'] = $to_date;
        }

        $res = $this->requests($url, $postData);

        $response = array(
            'result' => (int)Util::findSubstring('/<result>([0-1]*)<\/result>/', $res),
            'report' => Util::findSubstring('/<report>(.*)<\/report>/', $res),
        );
        $this->checkError($response);
        $response['report'] = base64_decode($response['report']);
        return $response;
    }


    /**
     * Refund all amount to customer
     *
     * @param string $transaction_id transaction id
     *
     * @return bool
     *
     * @throws TException
     */
    public function refund($transaction_id)
    {
        $url = $this->apiURL . $this->apiKey . '/chargeback/transaction';

        $res = $this->requests($url, array('title' => $transaction_id));

        $response = array(
            'result' => (int)Util::findSubstring('/<result>([0-1]*)<\/result>/', $res),
            'err'    => Util::findSubstring('/<err>(.*)<\/err>/', $res),
        );
        $this->checkError($response);

        return true;
    }

    /**
     * Refund custom amount to customer
     *
     * @param string $transaction_id transaction id
     * @param float $amount refund amount
     *
     * @return bool
     *
     * @throws TException
     */
    public function refundAny($transaction_id, $amount)
    {
        $url = $this->apiURL . $this->apiKey . '/chargeback/any';

        $postData = array(
            'title'             => $transaction_id,
            'chargeback_amount' => $amount,
        );
        $res = $this->requests($url, $postData);

        $response = array(
            'result' => (int)Util::findSubstring('/<result>([0-1]*)<\/result>/', $res),
            'err'    => Util::findSubstring('/<err>(.*)<\/err>/', $res),
        );
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
        $url = $this->apiURL . $this->apiKey . '/masspayment/any';

        $csv = base64_encode($csv);

        $postData = array(
            'csv'  => $csv,
            'sign' => sha1($this->merchantId . $csv . $this->merchantSecret),
        );
        $res = $this->requests($url, $postData);

        $response = array(
            'result'   => (int)Util::findSubstring('/<result>([0-1]*)<\/result>/', $res),
            'count'    => (int)Util::findSubstring('/<count>([0-9]*)<\/count>/', $res),
            'sum'      => (float)Util::findSubstring('/<sum>([0-9\.]*)<\/sum>/', $res),
            'pack_id'  => Util::findSubstring('/<pack_id>(.*)<\/pack_id>/', $res),
            'referers' => Util::findSubstring('/<referers>(.*)<\/referers>/', $res),
            'err'      => Util::findSubstring('/<err>(.*)<\/err>/', $res),
        );
        $this->checkError($response);

        return $response;
    }

    /**
     * Authorize mass payment
     *
     * @param string $pack_id pack id from masspaymentCreate
     *
     * @return bool
     * @throws TException
     */
    public function masspaymentAuthorize($pack_id)
    {
        $url = $this->apiURL . $this->apiKey . '/masspayment/authorize';

        $postData = array(
            'pack_id' => $pack_id,
        );
        $res = $this->requests($url, $postData);

        $response = array(
            'result' => (int)Util::findSubstring('/<result>([0-1]*)<\/result>/', $res),
            'err'    => Util::findSubstring('/<error>(.*)<\/error>/', $res),
        );
        $this->checkError($response);

        return $response;
    }

    /**
     * Get information about packs
     *
     * @param string|bool $pack_id pack id from masspaymentCreate
     * @param string|bool $from_date start date in format YYYY-MM-DD
     * @param string|bool $to_date end date in format YYYY-MM-DD
     *
     * @return bool
     * @throws TException
     */
    public function masspaymentPacks($pack_id = false, $from_date = false, $to_date = false)
    {
        $url = $this->apiURL . $this->apiKey . '/masspayment/packs';

        $postData = array();

        if ($pack_id !== false) {
            $postData['pack_id'] = $pack_id;
        }
        if ($from_date !== false) {
            $postData['from_date'] = $from_date;
        }
        if ($to_date !== false) {
            $postData['to_date'] = $to_date;
        }

        $res = $this->requests($url, $postData);

        $response = array(
            'result' => (int)Util::findSubstring('/<result>([0-1]*)<\/result>/', $res),
            'packs'  => Util::findSubstring('/<packs>(.*)<\/packs>/', $res),
            'err'    => Util::findSubstring('/<error>(.*)<\/error>/', $res),
        );
        $this->checkError($response);

        return $response;
    }

    /**
     * Authorize mass payment
     *
     * @param string $pack_id pack id from masspaymentCreate
     * @param string $tr_id transaction id
     *
     * @return bool
     * @throws TException
     */
    public function masspaymentTransfers($pack_id, $tr_id)
    {
        $url = $this->apiURL . $this->apiKey . '/masspayment/transfers';

        $postData = array(
            'pack_id' => $pack_id,
            'tr_id'   => $tr_id,
        );
        $res = $this->requests($url, $postData);

        $response = array(
            'result'    => (int)Util::findSubstring('/<result>([0-1]*)<\/result>/', $res),
            'transfers' => Util::findSubstring('/<transfers>(.*)<\/transfers>/', $res),
            'err'       => Util::findSubstring('/<error>(.*)<\/error>/', $res),
        );
        $this->checkError($response);

        return $response;
    }
}
