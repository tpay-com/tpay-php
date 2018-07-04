<?php

/*
 * Created by tpay.com.
 * Date: 13.06.2017
 * Time: 15:50
 */
namespace tpayLibs\src\_class_tpay\Refunds;

use tpayLibs\src\_class_tpay\CardApi;
use tpayLibs\src\_class_tpay\Utilities\TException;
use tpayLibs\src\Dictionaries\CardDictionary;

class CardRefunds extends CardApi
{
    /**
     * Method used to transfer money back to the client.
     * The refund can reference to chosen sale (sale_auth) or directly to client (cli_auth).
     * In both cases amount is adjustable in parameter amount.
     * If only cli_auth is sent amount parameter is required,
     * if sale_auth is passed amount and currency is not necessary -
     * system will take default values from the specified sale. With sale_auth refund can be made only once
     *
     * @param string|bool $saleAuthCode sale auth code
     * @param string $refundDesc refund description
     *
     * @return bool|mixed
     *
     * @throws TException
     */
    public function refund($saleAuthCode, $refundDesc)
    {
        /*
         * 	required clientAuthCode or sale_auth, refund_desc and amount if only clientAuthCode passed
         */

        if (empty($this->clientAuthCode) && empty($saleAuthCode)) {
            throw new TException ('Empty Token or sale auth');
        }
        if (!empty($this->clientAuthCode && empty($this->amount))) {
            throw new TException('Amount is required for Token based refunds.');
        }
        if (!is_string($refundDesc) || strlen($refundDesc) === 0 || strlen($refundDesc) > 128) {
            throw new TException('Refund desc is empty or too long.');
        }

        $this->setMethod(CardDictionary::REFUND);
        $params[CardDictionary::METHOD] = CardDictionary::REFUND;
        if (!empty($this->clientAuthCode)) {
            $params[CardDictionary::CLIAUTH] = $this->clientAuthCode;
        } else {
            $params[CardDictionary::SALE_AUTH] = $saleAuthCode;
        }
        $params[CardDictionary::DESC] = $refundDesc;
        if (!empty($this->amount)) {
            $params[CardDictionary::AMOUNT] = $this->amount;
        }
        $params[CardDictionary::CURRENCY] = $this->currency;
        $params[CardDictionary::LANGUAGE] = $this->lang;
        $params[CardDictionary::SIGN] = hash($this->cardHashAlg, implode('', $params) . $this->cardVerificationCode);
        $params[CardDictionary::APIPASS] = $this->cardApiPass;

        return $this->requests($this->cardsApiURL . $this->cardApiKey, $params);
    }

}
