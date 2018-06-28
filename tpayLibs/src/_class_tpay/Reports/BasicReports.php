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
     * @param bool $raw decide if return raw CSV format or array formatted report
     * @return array
     */
    public function report($fromDate, $toDate = false, $raw = true)
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
        if ($raw === false) {
            $response = $this->associateReportArray($response);
        }

        return $response;
    }

    public function transactionRefundStatus()
    {
        $url = $this->apiURL . $this->trApiKey . '/chargeback/status';
        if (!is_string($this->transactionID)) {
            throw new TException('Assign transaction title first!');
        }
        $postData = [
            'title' => $this->transactionID,
        ];
        $response = $this->requests($url, $postData);
        $this->checkError($response);

        return $response;
    }

    private function associateReportArray($response)
    {
        $report = explode(';', preg_replace('/[\n]+[0-9]+/', '', $response['report']));
        if (count($report) < 24) {
            return null;
        }
        $reportDefinition = array_slice($report, 1, 22);
        $j = 0;
        $k = 0;
        $reportArray = [];
        for ($i = 23; $i < count($report); $i++) {
            $reportArray[$j][$reportDefinition[$k]] = trim(preg_replace('/\s\s+/', ' ', str_replace('"', '', $report[$i])));
            if ($i % 22 === 0) {
                $j++;
            }
            ++$k;
            if ($k === count($reportDefinition)) {
                $k = 0;
            }
        }

        return $reportArray;
    }

}
