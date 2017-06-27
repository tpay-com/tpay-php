<?php

/*
 * Created by tpay.com.
 * Date: 13.06.2017
 * Time: 15:50
 */
namespace tpayLibs\src\_class_tpay\Reports;

use tpayLibs\src\_class_tpay\Utilities\TException;
use tpayLibs\src\_class_tpay\TransactionApi;

class BasicReports extends TransactionApi
{
    /**
     * Get transactions report
     *
     * @param string $fromDate start date in format YYYY-MM-DD
     * @param string|bool $toDate end date in format YYYY-MM-DD
     *
     * @return array
     *
     * @throws TException
     */
    public function report($fromDate, $toDate = false)
    {
        $url = $this->apiURL . $this->trApiKey . '/transaction/report';
        $postData = array(
            'from_date' => $fromDate
        );

        if ($toDate !== false) {
            $postData['to_date'] = $toDate;
        }

        $response = $this->requests($url, $postData);

        $this->checkError($response);
        $response[static::REPORT] = base64_decode($response[static::REPORT]);
        return $response;
    }
}
