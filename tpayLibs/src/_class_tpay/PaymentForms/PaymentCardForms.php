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
    const TPAY_TERMS_OF_SERVICE_URL = 'https://secure.tpay.com/regulamin.pdf';

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
     * @param bool $cardSaveAllowed set true if your want to display the save card checkbox
     * @param bool $payerFields set true if you want to display the name and email fields in card form.
     * Otherwise you will need to get those values from your DataBase.
     * @param array $savedCards list of user saved cards. Must contain id, shortCode and vendor parameters
     * @return string
     */

    public function getOnSiteCardForm(
        $paymentRedirectPath = 'index.html',
        $cardSaveAllowed = true,
        $payerFields = true,
        $savedCards = []
    ) {
        $data = [
            'rsa_key' => $this->cardKeyRSA,
            'payment_redirect_path' => $paymentRedirectPath,
            'card_save_allowed' => $cardSaveAllowed,
            'showPayerFields' => $payerFields,
            'userCards' => $savedCards,
            'regulation_url' => static::TPAY_TERMS_OF_SERVICE_URL,
        ];
        $data['new_card_form'] = Util::parseTemplate('gate', $data);

        return Util::parseTemplate('savedCardForm', $data);
    }

    /**
     * @param array $data
     * @return string HTML input form
     */
    public function getCardPaymentLinkBuilderForm($data)
    {
        return Util::parseTemplate('cardLinkBuilder', $data);
    }

}
