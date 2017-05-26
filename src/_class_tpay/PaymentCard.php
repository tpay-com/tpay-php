<?php

/*
 * Created by tpay.com
 */

namespace tpay;

/**
 * Class PaymentCard
 *
 * Class handles credit card payments through "Card API".
 * Depending on the chosen method:
 *  - client is redirected to card payment panel
 *  - card gate form is rendered
 *  - when user has saved card data only button is shown
 *
 * @package tpay
 */
class PaymentCard
{
    const RESULT = 'result';
    const ORDERID = 'order_id';
    const STRING = 'string';
    const SALE_AUTH = 'sale_auth';
    const REMOTE_ADDR = 'REMOTE_ADDR';

    /**
     * Card API key
     * @var string
     */
    private $apiKey = '[CARD_API_KEY]';

    /**
     * Card API password
     * @var string
     */
    private $apiPass = '[CARD_API_PASSWORD]';

    /**
     * Card API code
     * @var string
     */
    private $code = '[CARD_API_CODE]';

    /**
     * Card RSA key
     * @var string
     */
    private $keyRSA = '[CARD_RSA_KEY]';

    /**
     * Card hash algorithm
     * @var string
     */
    private $hashAlg = '[CARD_HASH_ALG]';

    /**
     * Currency code
     * @var string
     */
    private $currency = '985';

    /**
     * tpay payment url
     * @var string
     */
    private $apiURL = 'https://secure.tpay.com/cards/';

    /**
     * tpay response IP
     * @var string
     */
    private $secureIP = array(
        '176.119.38.175'
    );

    /**
     * If false library not validate tpay server IP
     * @var bool
     */
    private $validateServerIP = true;

    /**
     * PaymentCard class constructor for payment:
     * - card by panel
     * - card direct sale
     * - for saved cards
     *
     * @param string|bool $apiKey card api key
     * @param string|bool $apiPass card API password
     * @param string|bool $code card API code
     * @param string|bool $hashAlg card hash algorithm
     * @param string|bool $keyRSA card RSA key
     */
    public function __construct(
        $apiKey = false,
        $apiPass = false,
        $code = false,
        $hashAlg = false,
        $keyRSA = false
    ) {
        if ($apiKey !== false) {
            $this->apiKey = $apiKey;
        }
        if ($apiPass !== false) {
            $this->apiPass = $apiPass;
        }
        if ($code !== false) {
            $this->code = $code;
        }
        if ($hashAlg !== false) {
            $this->hashAlg = $hashAlg;
        }
        if ($keyRSA !== false) {
            $this->keyRSA = $keyRSA;
        }

        require_once(dirname(__FILE__) . '/Util.php');
        Util::loadClass('Validate');
        Util::loadClass('Exception');
        Util::loadClass('Lang');
        Util::checkVersionPHP();

        Validate::validateCardApiKey($this->apiKey);
        Validate::validateCardApiPassword($this->apiPass);
        Validate::validateCardCode($this->code);
        Validate::validateCardHashAlg($this->hashAlg);
        Validate::validateCardRSAKey($this->keyRSA);

        Util::loadClass('CardApi');
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
     * Create HTML form for panel payment based on transaction config
     * More information about config fields @see Validate::$cardPaymentRequestFields
     *
     * @param array $config transaction config
     *
     * @return string
     *
     * @throws TException
     */
    public function getTransactionForm($config)
    {
        $config = Validate::validateConfig(Validate::PAYMENT_TYPE_CARD, $config);

        $curr = isset($config['currency']) ? $config['currency'] : $this->currency;

        $api = new CardAPI($this->apiKey, $this->apiPass, $this->code, $this->hashAlg);
        $apiResponse = $api->registerSale(
            $config['name'],
            $config['email'],
            $config['desc'],
            $config['amount'],
            $curr,
            $config[static::ORDERID]
        );

        Util::log('card register sale', print_r($apiResponse, true));
        if (!is_array($apiResponse)
            ||
            !isset($apiResponse[static::RESULT])
            ||
            !isset($apiResponse[static::SALE_AUTH])
        ) {
            throw new TException('Invalid api response code');
        }

        $data = array(
            'action_url'      => $this->apiURL,
            static::SALE_AUTH => $apiResponse[static::SALE_AUTH],
        );

        return Util::parseTemplate('card/_tpl/paymentForm', $data);
    }

    /**
     * Check cURL request from tpay server after payment.
     * This method check server ip, required fields and md5 checksum sent by payment server.
     * Display information to prevent sending repeated notifications.
     *
     * @return mixed
     *
     * @throws TException
     */
    public function handleNotification()
    {
        Util::log('card handle notification', print_r($_POST, true));

        $notificationType = Util::post('type', static::STRING);
        if ($notificationType === 'sale') {
            $response = Validate::getResponse(Validate::PAYMENT_TYPE_CARD);
        } elseif ($notificationType === 'deregister') {
            $response = Validate::getResponse(Validate::CARD_DEREGISTER);
        } else {
            throw new TException('Unknown notification type');
        }

        if ($this->validateServerIP === true && $this->checkServer() === false) {
            throw new TException('Request is not from secure server');
        }

        echo json_encode(array(static::RESULT => '1'));

        if ($notificationType === 'sale' && $response['status'] === 'correct') {
            $resp = array(
                static::ORDERID   => $response[static::ORDERID],
                'sign'            => $response['sign'],
                static::SALE_AUTH => $response[static::SALE_AUTH],
                'date'            => $response['date'],
                'card'            => $response['card']
            );
            if (isset($response['test_mode'])) {

                $resp['test_mode'] = $response['test_mode'];
            }
            return $resp;
        } elseif ($notificationType === 'deregister') {
            return $response;
        } else {
            throw new TException('Incorrect payment');
        }
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
            return false;
        }

        return true;
    }

    /**
     * Get HTML form for direct sale gate. Using for payment in merchant shop
     *
     * @param string $staticFilesURL path to library static files
     * @param string $paymentRedirectPath payment redirect path
     *
     * @param bool $cardSaveAllowed
     * @return string
     * @throws TException
     */
    public function getDirectCardForm(
        $staticFilesURL = '',
        $paymentRedirectPath = 'index.html',
        $cardSaveAllowed = true
    ) {

        if (!is_string($this->keyRSA) || $this->keyRSA === '') {
            throw new TException('Invalid api response code');
        }

        $data = array(
            'rsa_key'               => $this->keyRSA,
            'static_files_url'      => $staticFilesURL,
            'payment_redirect_path' => $paymentRedirectPath,
            'card_save_allowed'     => $cardSaveAllowed
        );

        return Util::parseTemplate('card/_tpl/gate', $data);
    }

    /**
     * Get HTML form for saved card transaction. Using for payment in merchant shop
     *
     * @param string $cliAuth client auth sign form prev payment
     * @param string $desc transaction description
     * @param float $amount amount
     * @param string $confirmationUrl url to send confirmation
     * @param string $orderId order id
     * @param string $language language
     * @param string $currency currency
     *
     * @return string
     *
     * @throws TException
     */
    public function getCardSavedForm(
        $cliAuth,
        $desc,
        $amount,
        $confirmationUrl,
        $orderId = '',
        $language = 'pl',
        $currency = '985'
    ) {
        $api = new CardAPI($this->apiKey, $this->apiPass, $this->code, $this->hashAlg);

        $resp = $api->presale($cliAuth, $desc, $amount, $currency, $orderId, $language);

        Util::log('Card saved presale response', print_r($resp, true));

        if ((int)$resp[static::RESULT] === 1) {
            $data = array(
                static::SALE_AUTH  => $resp[static::SALE_AUTH],
                'confirmation_url' => $confirmationUrl,
                static::ORDERID    => $orderId
            );

            return Util::parseTemplate('card/_tpl/savedCard', $data);
        } else {
            throw new TException('Order data is invalid');
        }
    }

    /**
     * Card direct sale. Handle request from card gate form in merchant site
     * from method getDirectCardForm
     * Validate transaction config and all input fields
     *
     * @param float $orderAmount amount of payment
     * @param int $orderID order id
     * @param string $orderDesc order description
     * @param string $currency transaction currency
     *
     * @return bool|mixed
     *
     * @throws TException
     */
    public function directSale($orderAmount, $orderID, $orderDesc, $currency = '985')
    {
        $cardData = Util::post('carddata', static::STRING);
        $clientName = Util::post('client_name', static::STRING);
        $clientEmail = Util::post('client_email', static::STRING);
        $saveCard = Util::post('card_save', static::STRING);

        Util::log('Card direct post params', print_r(INPUT_POST, true));

        $oneTimeTransaction = ($saveCard !== 'on');
        $amount = number_format(str_replace(array(',', ' '), array('.', ''), $orderAmount), 2, '.', '');
        $amount = (float)$amount;

        $api = new CardAPI($this->apiKey, $this->apiPass, $this->code, $this->hashAlg);

        $tmpConfig = array(
            'amount'        => $amount,
            'name'          => $clientName,
            'email'         => $clientEmail,
            'desc'          => $orderDesc,
            static::ORDERID => $orderID,

        );


        Validate::validateConfig(Validate::PAYMENT_TYPE_CARD_DIRECT, $tmpConfig);
        $currency = Validate::validateCardCurrency($currency);
        $response = $api->directSale(
            $clientName,
            $clientEmail,
            $orderDesc,
            $amount,
            $cardData,
            $currency,
            $orderID,
            $oneTimeTransaction

        );

        Util::log('card direct sale response', print_r($response, true));

        return $response;
    }

    public function secureSale(
        $orderAmount,
        $orderID,
        $orderDesc,
        $currency = '985',
        $enablePowUrl = false,
        $language = 'pl',
        $powUrl = '',
        $powUrlBlad = ''
    ) {
        $cardData = Util::post('carddata', static::STRING);
        $clientName = Util::post('client_name', static::STRING);
        $clientEmail = Util::post('client_email', static::STRING);
        $saveCard = Util::post('card_save', static::STRING);

        Util::log('Card secureSale post params', print_r($_POST, true));

        $oneTimeTransaction = ($saveCard !== 'on');
        $amount = number_format(str_replace(array(',', ' '), array('.', ''), $orderAmount), 2, '.', '');
        $amount = (float)$amount;

        $api = new CardAPI($this->apiKey, $this->apiPass, $this->code, $this->hashAlg);

        $tmpConfig = array(
            'amount'         => $amount,
            'name'           => $clientName,
            'email'          => $clientEmail,
            'desc'           => $orderDesc,
            static::ORDERID  => $orderID,
            'enable_pow_url' => $enablePowUrl,
            'pow_url'        => $powUrl,
            'pow_url_blad'   => $powUrlBlad
        );


        Validate::validateConfig(Validate::PAYMENT_TYPE_CARD_DIRECT, $tmpConfig);
        $currency = Validate::validateCardCurrency($currency);

        $response = $api->secureSale(
            $clientName,
            $clientEmail,
            $orderDesc,
            $amount,
            $cardData,
            $currency,
            $orderID,
            $oneTimeTransaction,
            $language,
            $enablePowUrl,
            $powUrl,
            $powUrlBlad
        );

        Util::log('card secure sale response', print_r($response, true));

        return $response;
    }

    /**
     * Register sale for client saved card
     *
     * @param string $cliAuth client auth sign
     * @param string $saleAuth client sale sign
     *
     * @return bool|mixed
     */
    public function cardSavedSale($cliAuth, $saleAuth)
    {
        $api = new CardAPI($this->apiKey, $this->apiPass, $this->code, $this->hashAlg);

        return $api->sale($cliAuth, $saleAuth);
    }

    /**
     * Check md5 sum to validate tpay response.
     * The values of variables that md5 sum includes are available only for
     * merchant and tpay system.
     *
     * @param string $sign
     * @param string $testMode
     * @param string $saleAuth
     * @param string $orderId
     * @param string $card
     * @param float $amount
     * @param string $saleDate
     * @param string $currency
     *
     * @throws TException
     */
    public function validateSign(
        $sign,
        $saleAuth,
        $card,
        $amount,
        $saleDate,
        $status,
        $currency = '985',
        $testMode = '',
        $orderId = '',
        $sale = 'sale',
        $cliAuth = '',
        $reason = ''
    ) {
        $hash = hash($this->hashAlg, $sale . $testMode . $saleAuth . $orderId . $cliAuth . $card .
            $currency . $amount . $saleDate . $status . $reason . $this->code);

        if ($sign !== $hash) {
            throw new TException('Card payment - invalid checksum');
        }
    }

}
