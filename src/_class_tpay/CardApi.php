<?php

/*
 * Created by tpay.com
 */

namespace tpay;

/**
 * CardAPI class
 *
 * See cards_instructions.pdf for more details
 *
 * @package tpay
 */
class CardAPI
{
    const PRESALE = 'presale';
    const EMPTYCODE = 'Client auth code is empty.';
    const INVALIDCODE = 'Client auth code is invalid.';

    /**
     * PaymentCardAPI class constructor
     *
     * @param string $cardApiKey api key
     * @param string $cardApiPassword api password
     * @param string $verificationCode verification code
     * @param string $hashAlg hash algorithm
     *
     * @throws TException
     */

    const METHOD = 'method';
    const NAME = 'name';
    const EMAIL = 'email';
    const DESC = 'desc';
    const AMOUNT = 'amount';
    const CURRENCY = 'currency';
    const SIGN = 'sign';
    const APIPASS = 'api_password';
    const LANGUAGE = 'language';
    const SALE = 'sale';
    const SALEAUTH = 'sale_auth';
    const CLIAUTH = 'cli_auth';
    /**
     * tpay payment url
     * @var string
     */
    private $apiURL = 'https://secure.tpay.com/api/cards/';
    /**
     * Card api key
     * @var string
     */
    private $apiKey;
    /**
     * Card api pass
     * @var string
     */
    private $apiPass;
    /**
     * Api verification code
     * @var string
     */
    private $verificationCode;
    /**
     * The same as chosen in merchant panel (https://secure.tpay.com/panel)
     * In card api tab preferences
     * @var string
     */
    private $hashAlg;

    public function __construct($cardApiKey, $cardApiPassword, $verificationCode = '', $hashAlg = 'sha1')
    {
        Validate::validateCardApiKey($cardApiKey);
        Validate::validateCardApiPassword($cardApiPassword);
        Validate::validateCardHashAlg($hashAlg);
        if ($verificationCode !== '') {
            Validate::validateCardCode($verificationCode);
        }

        $this->apiKey = $cardApiKey;
        $this->apiPass = $cardApiPassword;
        $this->hashAlg = $hashAlg;
        $this->verificationCode = $verificationCode;

        Util::loadClass('Curl');
    }

    /**
     * Method used to sale initialization in tpay system.
     * Successful request returns sale_auth used to redirect client to transaction panel
     *
     * @param string $clientName client name
     * @param string $clientEmail client email
     * @param string $saleDescription sale description
     * @param float $amount amount
     * @param string $currency currency
     * @param string|null $orderID order id
     * @param bool $onetimer
     * @param string $lang
     *
     * @param bool $powUrlEnable
     * @param bool|string $powUrl
     * @param string $powUrlBlad
     * @return bool|mixed
     */
    public function registerSale(
        $clientName,
        $clientEmail,
        $saleDescription,
        $amount,
        $currency = '985',
        $orderID = null,
        $onetimer = true,
        $lang = 'pl',
        $powUrlEnable = true,
        $powUrl = '',
        $powUrlBlad = ''
    ) {
        return $this->registerSaleBase(
            $clientName,
            $clientEmail,
            $saleDescription,
            $amount,
            $currency,
            $orderID,
            $onetimer,
            false,
            null,
            $lang,
            $powUrlEnable,
            $powUrl,
            $powUrlBlad
        );
    }

    /**
     * Prepare for register sale @see $this->registerSale
     *
     * @param string $clientName client name
     * @param string $clientEmail client email
     * @param string $saleDescription sale description
     * @param float $amount amount
     * @param string $currency currency
     * @param string|null $orderID order id
     * @param bool $onetimer
     * @param bool $direct
     * @param string|null $saledata encrypted credit card data
     * @param string $lang
     *
     * @param bool $enablePowUrl
     * @param string $powUrl
     * @param string $powUrlBlad
     * @return bool|mixed
     */
    private function registerSaleBase(
        $clientName,
        $clientEmail,
        $saleDescription,
        $amount,
        $currency = '985',
        $orderID = null,
        $onetimer = true,
        $direct = false,
        $saledata = null,
        $lang = 'pl',
        $enablePowUrl = false,
        $powUrl = '',
        $powUrlBlad = ''
    ) {
        $amount = number_format(str_replace(array(',', ' '), array('.', ''), $amount), 2, '.', '');

        $params = $this->recogniseMethod($direct, $saledata);

        $params = array_merge($params, array(
            static::NAME   => $clientName,
            static::EMAIL  => $clientEmail,
            static::DESC   => $saleDescription,
            static::AMOUNT => $amount,
        ));
        $params = array_merge($params, $this->prepareSecondaryParams($currency, $orderID, $onetimer, $lang));
        if ($params['method'] !== 'register_sale') {
            $params['enable_pow_url'] = $enablePowUrl ? '1' : '0';
        }

        $params[static::SIGN] = hash($this->hashAlg, implode('', $params) . $this->verificationCode);
        $params[static::APIPASS] = $this->apiPass;

        $params = array_merge($params, $this->checkReturnUrls($powUrl, $powUrlBlad));

        Util::log('Card request', print_r($params, true));
        return Curl::doCurlRequest($this->apiURL . $this->apiKey, $params);
    }

    /**
     * Prepare for register sale @see $this->registerSale
     *
     * @param string $saledata
     * @param bool $direct
     * @return array
     *
     */
    private function recogniseMethod($direct = false, $saledata = null)
    {

        if ($direct && !empty($saledata)) {
            $params = array(
                static::METHOD => 'directsale',
                'card'         => $saledata,
            );
        } elseif (!$direct && !empty($saledata)) {
            $params = array(
                static::METHOD => 'securesale',
                'card'         => $saledata,
            );
        } else {
            $params = array(
                static::METHOD => 'register_sale',
            );
        }
        return $params;
    }

    /**
     * Prepare for register sale @see $this->registerSale
     *
     * @param string $currency currency
     * @param string|null $orderID order id
     * @param bool $onetimer
     * @param string $lang
     * @return array
     *
     */
    private function prepareSecondaryParams(
        $currency = '985',
        $orderID = '',
        $onetimer = true,
        $lang = 'pl'
    ) {
        $params = array();
        if ($currency) {
            $params[static::CURRENCY] = $currency;
        }
        if ($orderID) {
            $params['order_id'] = $orderID;
        }
        if ($onetimer) {
            $params['onetimer'] = '1';
        }
        if ($lang) {
            $params[static::LANGUAGE] = Validate::validateCardLanguage($lang);
        }

        return $params;
    }

    private function checkReturnUrls($powUrl = '', $powUrlBlad = '')
    {
        $params = array();
        if (filter_var($powUrl, FILTER_VALIDATE_URL)) {
            $params['pow_url'] = $powUrl;
        }
        if (filter_var($powUrlBlad, FILTER_VALIDATE_URL)) {
            $params['pow_url_blad'] = $powUrlBlad;
        }
        return $params;
    }

    /**
     * This method allows Merchant to host payment form on his website and perform sale without any client redirection
     * to tpay.com system. This approach requires special security considerations.
     * The client will be redirected if his card has 3d secure.
     * We support secure communication by encrypting card data (card number, validity date and cvv/cvs number)
     * on client side (javascript) with Merchant's public RSA key and send it as one parameter (card) to our API gate.
     * A valid SSL certificate on domain is required
     *
     * @param string $clientName client name
     * @param string $clientEmail client email
     * @param string $saleDescription sale description
     * @param float $amount amount
     * @param string $carddata encrypted credit card data
     * @param string $curr currency
     * @param string|null $orderID order id
     * @param bool $onetimer
     * @param string $lang
     *
     * @param bool $enablePowUrl
     * @param string $powUrl
     * @param string $powUrlBlad
     * @return bool|mixed
     * @throws TException
     */
    public function secureSale(
        $clientName,
        $clientEmail,
        $saleDescription,
        $amount,
        $carddata,
        $curr = '985',
        $orderID = null,
        $onetimer = true,
        $lang = 'pl',
        $enablePowUrl = true,
        $powUrl = '',
        $powUrlBlad = ''
    ) {
        if (!is_string($carddata) || strlen($carddata) === 0) {
            throw new TException('Card data are not set');
        }

        return $this->registerSaleBase(
            $clientName,
            $clientEmail,
            $saleDescription,
            $amount,
            $curr,
            $orderID,
            $onetimer,
            false,
            $carddata,
            $lang,
            $enablePowUrl,
            $powUrl,
            $powUrlBlad
        );
    }

    /**
     * This method allows Merchant to host payment form on his website and perform sale without any client redirection
     * to tpay.com system. This approach requires special security considerations.
     * We support secure communication by encrypting card data (card number, validity date and cvv/cvs number)
     * on client side (javascript) with Merchant's public RSA key and send it as one parameter (card) to our API gate.
     * A valid SSL certificate on domain is required
     *
     * @param string $clientName client name
     * @param string $clientEmail client email
     * @param string $saleDescription sale description
     * @param float $amount amount
     * @param string $carddata encrypted credit card data
     * @param string $curr currency
     * @param string|null $orderID order id
     * @param bool $onetimer
     *
     * @return bool|mixed
     *
     * @throws TException
     */
    public function directSale(
        $clientName,
        $clientEmail,
        $saleDescription,
        $amount,
        $carddata,
        $curr = '985',
        $orderID = null,
        $onetimer = true


    ) {
        if (!is_string($carddata) || strlen($carddata) === 0) {
            throw new TException('Card data are not set');
        }

        return $this->registerSaleBase(
            $clientName,
            $clientEmail,
            $saleDescription,
            $amount,
            $curr,
            $orderID,
            $onetimer,
            true,
            $carddata

        );
    }

    /**
     * Method used to create new sale for payment on demand.
     * It can be called after receiving notification with cli_auth (see communication schema in register_sale method).
     * It cannot be used if onetimer option was sent in register_sale or client has unregistered
     * (by link in email or by API).
     *
     * @param string $clientAuthCode client auth code
     * @param string $saleDescription sale description
     * @param float $amount amount
     * @param string $currency currency
     * @param null $orderID order id
     * @param string $lang language
     *
     * @return bool|mixed
     *
     * @throws TException
     */
    public function presale(
        $clientAuthCode,
        $saleDescription,
        $amount,
        $currency = '985',
        $orderID = null,
        $lang = 'pl'
    ) {

        $params = $this->saleValidateAndPrepareParams($clientAuthCode, $saleDescription, $amount,
            $currency, $orderID, $lang, static::PRESALE);

        Util::log('Presale params', print_r($params, true) . ' hash alg ' . $this->hashAlg);

        $amount = number_format($amount, 2, '.', '');

        $params[static::SIGN] = hash($this->hashAlg, static::PRESALE . $clientAuthCode . $saleDescription .
            $amount . $currency . $orderID . $lang . $this->verificationCode);
        $params[static::APIPASS] = $this->apiPass;

        Util::log('Pre sale params with hash ', print_r($params, true) . 'req url ' . $this->apiURL . $this->apiKey);

        return Curl::doCurlRequest($this->apiURL . $this->apiKey, $params);
    }

    /**
     * Validate all transaction parameters and throw TException if any error occurs
     * Add required fields sign and api password to config
     *
     * @param string $clientAuthCode client auth code
     * @param string $saleDescription sale description
     * @param float $amount amount
     * @param string $currency currency
     * @param string|null $orderID order id
     * @param string $lang language
     * @param string $method sale method
     * @param array $errors validation errors
     *
     * @return array    parameters for sale request
     *
     * @throws TException
     */
    private function saleValidateAndPrepareParams(
        $clientAuthCode,
        $saleDescription,
        $amount,
        $currency,
        $orderID,
        $lang,
        $method,
        $errors = array()
    ) {

        if (!is_string($clientAuthCode) || strlen($clientAuthCode) === 0) {
            $errors[] = static::EMPTYCODE;
        } else {
            if (strlen($clientAuthCode) !== 40) {
                $errors[] = static::INVALIDCODE;
            }
        }

        if (!is_string($saleDescription) || strlen($saleDescription) === 0) {
            $errors[] = 'Sale description is empty.';
        } else {
            if (strlen($saleDescription) > 128) {
                $errors[] = 'Sale description is too long. Max 128 characters.';
            }
        }

        if (!is_double($amount) && !is_float($amount) && !is_int($amount) && $amount <= 0) {
            $errors[] = 'Amount is invalid.';
        }

        if (!is_int($currency) && strlen($currency) != 3) {
            $errors[] = 'XCurrency is invalid.';
        }

        if (count($errors) > 0) {
            throw new TException(sprintf('%s', implode(' ', $errors)));
        }

        $amount = number_format(str_replace(array(',', ' '), array('.', ''), $amount), 2, '.', '');

        $params = array(
            static::METHOD  => $method,
            static::CLIAUTH => $clientAuthCode,
            static::DESC    => $saleDescription,
            static::AMOUNT  => $amount,
        );

        if ($currency) {
            $params[static::CURRENCY] = $currency;
        }
        if ($orderID) {
            $params['order_id'] = $orderID;
        }
        if ($lang) {
            $params[static::LANGUAGE] = $lang;
        }

        $params[static::SIGN] = hash($this->hashAlg, implode('', $params) . $this->verificationCode);
        $params[static::APIPASS] = $this->apiPass;

        return $params;
    }

    /**
     * Make sale by client auth code
     *
     * @param string $clientAuthCode client auth code
     * @param string $saleDescription sale description
     * @param float $amount amount
     * @param string $currency currency
     * @param string|null $orderID order id
     * @param string $lang language
     *
     * @return bool|mixed
     *
     * @throws TException
     */
    public function completeSale(
        $clientAuthCode,
        $saleDescription,
        $amount,
        $currency = '985',
        $orderID = null,
        $lang = 'pl'
    ) {

        $params = $this->saleValidateAndPrepareParams($clientAuthCode, $saleDescription,
            $amount, $currency, $orderID, $lang, static::PRESALE);
        $response = Curl::doCurlRequest($this->apiURL . $this->apiKey, $params);

        if ($response['result']) {
            $saleAuthCode = $response[static::SALEAUTH];
            return $this->sale($clientAuthCode, $saleAuthCode);

        }

        return $response;
    }

    /**
     * Method used to execute created sale with presale method. Sale defined with sale_auth can be executed only once.
     * If the method is called second time with the same parameters, system returns sale actual status - in parameter
     * status - done for correct payment and declined for rejected payment.
     * In that case, client card is not charged the second time.
     *
     * @param string $clientAuthCode client auth code
     * @param string $saleAuthCode sale auth code
     *
     * @return bool|mixed
     */
    public function sale($clientAuthCode, $saleAuthCode)
    {
        if (strlen($clientAuthCode) != 40) {
            return false;
        }
        if (strlen($saleAuthCode) != 40) {
            return false;
        }

        $params = array(
            static::METHOD   => static::SALE,
            static::CLIAUTH  => $clientAuthCode,
            static::SALEAUTH => $saleAuthCode,
        );
        $params[static::SIGN] = hash($this->hashAlg, static::SALE .
            $clientAuthCode . $saleAuthCode . $this->verificationCode);
        $params[static::APIPASS] = $this->apiPass;

        return Curl::doCurlRequest($this->apiURL . $this->apiKey, $params);
    }

    /**
     * Method used to transfer money back to the client.
     * The refund can reference to chosen sale (sale_auth) or directly to client (cli_auth).
     * In both cases amount is adjustable in parameter amount.
     * If only cli_auth is sent amount parameter is required,
     * if sale_auth is passed amount and currency is not necessary -
     * system will take default values from the specified sale. With sale_auth refund can be made only once
     *
     * @param string $clientAuthCode client auth code
     * @param string|bool $saleAuthCode sale auth code
     * @param string $refundDesc refund description
     * @param float|null $amount amount
     * @param string $currency currency
     * @param string $lang
     *
     * @return bool|mixed
     *
     * @throws TException
     */
    public function refund($clientAuthCode, $saleAuthCode, $refundDesc, $amount = null, $currency = '985', $lang = 'pl')
    {
        $errors = array();
        /*
         * 	required clientAuthCode or sale_auth, refund_desc and amount if only clientAuthCode passed
         */
        if (!is_string($clientAuthCode) || strlen($clientAuthCode) === 0) {
            $errors[] = static::EMPTYCODE;
        } else {
            if (strlen($clientAuthCode) !== 40) {
                $errors[] = static::INVALIDCODE;
            }
        }

        if (!is_string($saleAuthCode) || strlen($saleAuthCode) === 0) {
            $errors[] = 'Sale auth code is empty.';
        } else {
            if (strlen($saleAuthCode) !== 40) {
                $errors[] = 'Sale auth code is invalid.';
            }
        }

        if (!is_string($refundDesc) || strlen($refundDesc) === 0) {
            $errors[] = 'Refund desc is empty.';
        } else {
            if (strlen($refundDesc) > 128) {
                $errors[] = 'Refund desc is too long. Max 128 characters.';
            }
        }

        if ($amount != null) {
            $amount = number_format(str_replace(array(',', ' '), array('.', ''), $amount), 2, '.', '');

        } else {
            if ($clientAuthCode && !$saleAuthCode) {
                $errors[] = 'Sale auth is false.';
            }
        }

        if (!isset($clientAuthCode) && !isset($saleAuthCode)) {
            $errors[] = 'Cli auth is not set and sale auth is not set.';
        }

        if (!is_int($currency) && strlen($currency) != 3) {
            $errors[] = 'Currency is invalid.';
        }

        if (count($errors) > 0) {
            throw new TException(sprintf('%s', implode(' ', $errors)));
        }

        $params[static::METHOD] = 'refund';
        $params[static::DESC] = $refundDesc;

        if ($clientAuthCode) {
            $params[static::CLIAUTH] = $clientAuthCode;
        }
        if ($saleAuthCode) {
            $params[static::SALEAUTH] = $saleAuthCode;
        }
        if ($amount) {
            $params[static::AMOUNT] = $amount;
        }
        if ($currency) {
            $params[static::CURRENCY] = $currency;
        }
        if ($lang) {
            $params[static::LANGUAGE] = $lang;
        }


        $params[static::SIGN] = hash($this->hashAlg, implode('', $params) . $this->verificationCode);
        $params[static::APIPASS] = $this->apiPass;

        return Curl::doCurlRequest($this->apiURL . $this->apiKey, $params);
    }

    /**
     * Method used to deregister client card data from system.
     * Client can also do it himself from link in email after payment - if onetimer was not set - in that case system
     * will sent notification. After successful deregistration Merchant can no more charge client's card
     *
     * @param string $clientAuthCode client auth code
     *
     * @return bool|mixed
     *
     * @throws TException
     */
    public function deregisterClient($clientAuthCode)
    {
        $errors = array();

        if (!is_string($clientAuthCode) || strlen($clientAuthCode) === 0) {
            $errors[] = static::EMPTYCODE;
        } else {
            if (strlen($clientAuthCode) !== 40) {
                $errors[] = static::INVALIDCODE;
            }
        }

        if (count($errors) > 0) {
            throw new TException(sprintf('%s', implode(' ', $errors)));
        }

        $params[static::METHOD] = 'deregister';
        $params[static::CLIAUTH] = $clientAuthCode;

        $params[static::SIGN] = hash($this->hashAlg, implode('', $params) . $this->verificationCode);
        $params[static::APIPASS] = $this->apiPass;

        return Curl::doCurlRequest($this->apiURL . $this->apiKey, $params);
    }
}
