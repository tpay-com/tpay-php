<?php

namespace Tpay\OriginApi;

use Tpay\OriginApi\Dictionaries\CardDictionary;
use Tpay\OriginApi\Utilities\TException;
use Tpay\OriginApi\Utilities\Util;

/**
 * Class handles credit card payments through "Card API".
 * Depending on the chosen method:
 *  - client is redirected to card payment panel
 *  - card gate form is rendered
 *  - when user has saved card data only button is shown
 */
class PaymentCard extends CardApi
{
    /**
     * PaymentCard class constructor for payment:
     * - card by panel
     * - card direct sale
     * - for saved cards
     */
    public function __construct()
    {
        parent::__construct();
        $this->isNotEmptyString($this->cardKeyRSA, 'Card RSA key');
    }

    public function registerSale(
        $clientName,
        $clientEmail,
        $orderDesc,
        $cardData = null
    ) {
        if (!is_null($cardData)) {
            $this->setCardData($cardData);
        }
        if (!is_null($this->cardData)) {
            $this->setEnablePowUrl(true)->setMethod(CardDictionary::SECURESALE);
        } else {
            $this->setEnablePowUrl(false)->setMethod(CardDictionary::REGISERSALE);
        }

        $response = $this->registerSaleMethod(
            $clientName,
            $clientEmail,
            $orderDesc
        );
        Util::log($this->method.' response', print_r($response, true));

        return $response;
    }

    /**
     * Register sale for client saved card
     *
     * @param string $saleAuth client sale sign
     * @param mixed  $cliAuth
     *
     * @return bool|mixed
     */
    public function sale($saleAuth, $cliAuth)
    {
        return $this->setClientToken($cliAuth)->saleMethod($saleAuth);
    }

    public function presale($description, $cliAuth)
    {
        return $this->setClientToken($cliAuth)->presaleMethod($description);
    }

    /**
     * Check md5 sum to validate tpay response.
     * The values of variables that md5 sum includes are available only for
     * merchant and tpay system.
     *
     * @param string $sign
     * @param string $saleAuth
     * @param string $card
     * @param string $saleDate
     * @param string $status
     * @param string $testMode
     * @param string $sale
     * @param string $reason
     *
     * @throws TException
     */
    public function validateCardSign(
        $sign,
        $saleAuth,
        $card,
        $saleDate,
        $status,
        $testMode = '',
        $sale = 'sale',
        $reason = ''
    ) {
        $hash = hash($this->cardHashAlg, $sale.$testMode.$saleAuth.$this->orderID.$this->clientAuthCode
            .$card.$this->currency.$this->amount.$saleDate.$status.$reason.$this->cardVerificationCode);

        if ($sign !== $hash) {
            throw new TException('Card payment - invalid checksum');
        }
    }
}
