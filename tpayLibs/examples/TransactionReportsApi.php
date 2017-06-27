<?php

/*
 * Created by tpay.com
 */

namespace tpayLibs\examples;

use tpayLibs\src\_class_tpay\Reports\BasicReports;
use tpayLibs\src\_class_tpay\Utilities\TException;

include_once 'config.php';
include_once 'loader.php';

class TransactionReportsApi extends BasicReports
{
    public function __construct()
    {
        $this->merchantSecret = 'demo';
        $this->merchantId = 1010;
        $this->trApiKey = '';
        $this->trApiPass = '';
        parent::__construct();
    }

    public function getReportTransaction()
    {
        /**
         * Get report
         */

        $from = '2017-01-01';

        try {
            $report = $this->report($from);
            print_r($report);
        } catch (TException $e) {
            var_dump($e);
        }

    }

}

(new TransactionReportsApi())->getReportTransaction();
