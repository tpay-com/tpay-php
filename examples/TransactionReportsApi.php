<?php

namespace TpayExample;

use Tpay\OriginApi\Reports\BasicReports;
use Tpay\OriginApi\Utilities\TException;

include_once 'config.php';
include_once 'loader.php';

class TransactionReportsApi extends BasicReports
{
    public function __construct()
    {
        $this->merchantSecret = 'demo';
        $this->merchantId = 1010;
        $this->trApiKey = '75f86137a6635df826e3efe2e66f7c9a946fdde1';
        $this->trApiPass = 'p@$$w0rd#@!';
        parent::__construct();
    }

    /**
     * Get transactions report
     *
     * @param string      $dateStart 'report date start range'
     * @param bool|string $dateEnd   'report date end range - false if to current date'
     * @param bool        $csv       'decide if return report in csv format or table associated'
     */
    public function getReportTransaction($dateStart, $dateEnd = false, $csv = false)
    {
        try {
            // Set $csv parameter value to bool true, to get RAW CSV formatted report
            $result = $this->report($dateStart, $dateEnd, $csv);
            if (is_null($result)) {
                echo 'Report is empty for this time range.';
            } else {
                // Will return each transaction in separate array element
                var_dump($result);
            }
        } catch (TException $e) {
            var_dump($e->getMessage());
        }
    }
}

(new TransactionReportsApi())->getReportTransaction('2017-01-01');
