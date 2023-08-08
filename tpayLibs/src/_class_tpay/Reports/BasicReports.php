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
    const CSV_SEPARATOR = ';';
    const CSV_EOL = "\n";

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

    /**
     * @param array $response
     * @return array|null
     */
    private function associateReportArray($response)
    {
        $allReportCsvLines = explode(self::CSV_EOL, $response['report']);

        $reportCsvLines = $this->removeCsvHeader($allReportCsvLines);

        $isEmpty = count($reportCsvLines) < 2;
        if ($isEmpty) {
            return null;
        }

        $firstRowData = array_shift($reportCsvLines);
        $columnNames = $this->removeLineCounterColumn(
            $this->csvLineToArray($firstRowData)
        );

        $result = [];
        while (false === empty($reportCsvLines)) {
            $rowData = array_shift($reportCsvLines);

            if (empty($rowData)) {
                break;
            }

            $values = $this->removeLineCounterColumn(
                $this->csvLineToArray($rowData)
            );

            $result[] = array_combine($columnNames, $values);
        }

        return $result;
    }

    /**
     * @param array $reportCsvLines
     * @return array
     */
    private function removeCsvHeader(array $reportCsvLines)
    {
        return array_slice($reportCsvLines, 2);
    }

    /**
     * @param array $values
     * @return array
     */
    private function removeLineCounterColumn(array $values)
    {
        return array_slice($values, 1);
    }

    /**
     * @param string $csvLine
     * @return array
     */
    private function csvLineToArray($csvLine)
    {
        return str_getcsv($csvLine, self::CSV_SEPARATOR);
    }
}
