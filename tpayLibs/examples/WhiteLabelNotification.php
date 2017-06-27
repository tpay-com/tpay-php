<?php

/*
 * Created by tpay.com
 */

namespace tpayLibs\examples;

use tpayLibs\src\_class_tpay\Notifications\SzkwalNotificationsHandler;

include_once 'config.php';
include_once 'loader.php';

class WhiteLabelNotification extends SzkwalNotificationsHandler
{

    public function __construct()
    {
        $this->szkwalApiLogin = '';
        $this->szkwalApiPass = '';
        $this->szkwalApiHash = '';
        $this->szkwalPartnerUniqueAddress = '';
        $this->szkwalTitleFormat = '';
        parent::__construct();
        if (filter_input(INPUT_GET, 'szkwal_notification')) {
            $this->handleSzkwalNotification();
        }
    }

}
