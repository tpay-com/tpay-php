<?php

/*
 * Created by tpay.com.
 * Date: 13.06.2017
 * Time: 16:56
 */

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
     * @return mixed
     *
     * @throws TException
     */
    public function handleNotification()
    {
        Util::log('Card notification', "POST params: \n" . print_r($_POST, true));
        $notificationType = Util::post('type', CardDictionary::STRING);
        if ($notificationType === CardDictionary::SALE) {
            $response = $this->getResponse(new PaymentTypeCard());
        } elseif ($notificationType === CardDictionary::DEREGISTER) {
            $response = $this->getResponse(new PaymentTypeCardDeregister());
        } else {
            throw new TException('Unknown notification type');
        }
        if ($this->validateServerIP === true && $this->isTpayServer() === false) {
            throw new TException('Request is not from secure server');
        }

        echo json_encode([CardDictionary::RESULT => '1']);

        if (($notificationType === CardDictionary::SALE && $response['status'] === 'correct')
            || $notificationType === CardDictionary::DEREGISTER
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
