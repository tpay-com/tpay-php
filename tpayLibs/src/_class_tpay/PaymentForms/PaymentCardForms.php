<?php

/*
 * Created by tpay.com.
 * Date: 13.06.2017
 * Time: 14:55
 */

namespace tpayLibs\src\_class_tpay\PaymentForms;


use tpayLibs\src\_class_tpay\PaymentCard;
use tpayLibs\src\_class_tpay\Utilities\TException;
use tpayLibs\src\_class_tpay\Utilities\Util;
use tpayLibs\src\Dictionaries\CardDictionary;

class PaymentCardForms extends PaymentCard
{

    /**
     * tpay payment url
     * @var string
     */
    private $cardsURL = 'https://secure.tpay.com/cards/';

    /**
     * Create HTML form for panel payment based on transaction config
     * More information about config fields @see $this->validator->$cardPaymentRequestFields
     *
     * @param array $config transaction config
     *
     * @return string
     *
     * @throws TException
     */
    public function getTransactionForm($config)
    {

        $apiResponse = $this->registerSale(
            $config['name'],
            $config['email'],
            $config['desc']
        );

        Util::log('card register sale', print_r($apiResponse, true));
        if (!is_array($apiResponse)
            ||
            !isset($apiResponse[CardDictionary::RESULT])
            ||
            !isset($apiResponse[CardDictionary::SALE_AUTH])
        ) {
            throw new TException('Invalid api response code');
        }

        $data = array(
            'action_url'              => $this->cardsURL,
            CardDictionary::SALE_AUTH => $apiResponse[CardDictionary::SALE_AUTH],
        );

        return Util::parseTemplate('cardPaymentForm', $data);
    }

    /**
     * Get HTML form for direct sale gate. Using for payment in merchant shop
     *
     * @param string $paymentRedirectPath payment redirect path
     *
     * @param bool $cardSaveAllowed
     * @return string
     * @throws TException
     */

    public function getOnSiteCardForm(
        $paymentRedirectPath = 'index.html',
        $cardSaveAllowed = true
    ) {
        $data = array(
            'rsa_key'               => $this->cardKeyRSA,
            'payment_redirect_path' => $paymentRedirectPath,
            'card_save_allowed'     => $cardSaveAllowed
        );

        return Util::parseTemplate('gate', $data);
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
        $this->setAmount($amount)->setCurrency($currency)->setOrderID($orderId)->setLanguage($language);

        $resp = $this->presale($cliAuth, $desc);

        Util::log('Card saved presale response', print_r($resp, true));

        if ((int)$resp[CardDictionary::RESULT] === 1) {
            $data = array(
                CardDictionary::SALE_AUTH => $resp[CardDictionary::SALE_AUTH],
                'confirmation_url'        => $confirmationUrl,
                CardDictionary::ORDERID   => $orderId
            );

            return Util::parseTemplate('savedCard', $data);
        } else {
            throw new TException('Order data is invalid');
        }
    }

}
