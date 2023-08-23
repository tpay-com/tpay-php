<?php

namespace Tpay\OriginApi\Notifications;

use Tpay\OriginApi\Dictionaries\CardDictionary;
use Tpay\OriginApi\PaymentCard;
use Tpay\OriginApi\Utilities\TException;
use Tpay\OriginApi\Utilities\Util;
use Tpay\OriginApi\Validators\PaymentTypes\PaymentTypeCard;
use Tpay\OriginApi\Validators\PaymentTypes\PaymentTypeCardDeregister;

class CardNotificationHandler extends PaymentCard
{
    /**
     * Check cURL request from tpay server after payment.
     * This method check server ip, required fields and md5 checksum sent by payment server.
     * Display information to prevent sending repeated notifications.
     *
     * @throws TException
     */
    public function handleNotification()
    {
        Util::log('Card notification', "POST params: \n".print_r($_POST, true));

        /** @var string $notificationType */
        $notificationType = Util::post('type', CardDictionary::STRING);

        if (CardDictionary::SALE === $notificationType) {
            $response = $this->getResponse(new PaymentTypeCard());
        } elseif (CardDictionary::DEREGISTER === $notificationType) {
            $response = $this->getResponse(new PaymentTypeCardDeregister());
        } else {
            throw new TException('Unknown notification type');
        }
        if (true === $this->validateServerIP && false === $this->isTpayServer()) {
            throw new TException('Request is not from secure server');
        }

        echo json_encode([CardDictionary::RESULT => '1']);

        if ((CardDictionary::SALE === $notificationType && 'correct' === $response['status'])
            || CardDictionary::DEREGISTER === $notificationType
        ) {
            if (isset($response[CardDictionary::CLIAUTH])) {
                $this->setClientToken($response[CardDictionary::CLIAUTH]);
            }
        } else {
            throw new TException('Incorrect payment');
        }

        return $response;
    }
}
