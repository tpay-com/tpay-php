<?php

/*
 * Created by tpay.com
 */

namespace tpayLibs\examples;

use tpayLibs\src\_class_tpay\Notifications\CardNotificationHandler;

include_once 'config.php';
include_once 'loader.php';

class CardNotification extends CardNotificationHandler
{

    public function __construct()
    {
        if (filter_input(INPUT_GET, 'card_notification')) {
            $this->cardApiKey = '';
            $this->cardApiPass = '';
            $this->cardKeyRSA = '';
            $this->cardVerificationCode = '';
            $this->cardHashAlg = 'sha1';
            parent::__construct();
            $this->handleNotification();
        }
    }

}
