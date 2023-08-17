<?php

namespace Tpay\Refunds;

use Tpay\CardApi;
use Tpay\Dictionaries\CardDictionary;
use Tpay\Utilities\TException;
use Tpay\Utilities\Util;

class CardRefunds extends CardApi
{
    /**
     * Method used to transfer money back to the client.
     * The refund can reference to chosen sale (sale_auth) or directly to client (cli_auth).
     * In both cases amount is adjustable in parameter amount.
     * If only cli_auth is sent amount parameter is required,
     * if sale_auth is passed amount and currency is not necessary -
     * system will take default values from the specified sale.
     *
     * @param string $saleAuthCode optional sale auth code
     * @param string $refundDesc   refund description
     *
     * @throws TException
     *
     * @return array
     */
    public function refund($saleAuthCode, $refundDesc)
    {
        if (empty($this->clientAuthCode) && empty($saleAuthCode)) {
            throw new TException('Empty Token or sale auth');
        }
        if (!empty($this->clientAuthCode && empty($this->amount))) {
            throw new TException('Amount is required for Token based refunds.');
        }
        if (!is_string($refundDesc) || 0 === strlen($refundDesc) || strlen($refundDesc) > 128) {
            throw new TException('Refund desc is empty or too long.');
        }

        $this->setMethod(CardDictionary::REFUND);
        $params[CardDictionary::METHOD] = CardDictionary::REFUND;
        if (!empty($this->clientAuthCode)) {
            $params[CardDictionary::CLIAUTH] = $this->clientAuthCode;
        } else {
            $params[CardDictionary::CLIAUTH] = '';
            $params[CardDictionary::SALE_AUTH] = $saleAuthCode;
        }
        $params[CardDictionary::SALE_AUTH] = isset($saleAuthCode) ? $saleAuthCode : '';
        $params[CardDictionary::DESC] = isset($refundDesc) ? $refundDesc : '';
        $params[CardDictionary::AMOUNT] = !empty($this->amount) ? $this->amount : '';
        $params[CardDictionary::CURRENCY] = isset($this->currency) ? $this->currency : '';
        $params[CardDictionary::LANGUAGE] = isset($this->lang) ? $this->lang : '';
        $params[CardDictionary::SIGN] = hash($this->cardHashAlg, implode('&', $params).'&'.$this->cardVerificationCode);
        foreach ($params as $paramsKey => $paramsValue) {
            if ('' === $paramsValue) {
                unset($params[$paramsKey]);
            }
        }
        $params[CardDictionary::APIPASS] = $this->cardApiPass;
        Util::log('Card refund', print_r($params, true));
        $result = $this->requests($this->cardsApiURL.$this->cardApiKey, $params);
        Util::log('Card refund result', print_r($result, true));

        return $result;
    }
}
