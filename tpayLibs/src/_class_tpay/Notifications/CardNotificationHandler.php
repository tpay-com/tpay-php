<?php

namespace tpayLibs\src\_class_tpay\Notifications;

use tpayLibs\src\_class_tpay\PaymentCard;
use tpayLibs\src\_class_tpay\Utilities\TException;
use tpayLibs\src\_class_tpay\Utilities\Util;
use tpayLibs\src\_class_tpay\Validators\PaymentTypes\PaymentTypeCard;
use tpayLibs\src\_class_tpay\Validators\PaymentTypes\PaymentTypeCardDeregister;
use tpayLibs\src\Dictionaries\CardDictionary;

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
