<?php

namespace Tpay\OriginApi\Reports;

use Tpay\OriginApi\TransactionApi;
use Tpay\OriginApi\Utilities\TException;

class BasicReports extends TransactionApi
{
    const CSV_SEPARATOR = ';';
    const CSV_EOL = "\n";

    /**
     * Get transactions report
     *
     * @param string      $fromDate start date in format YYYY-MM-DD
     * @param bool|string $toDate   end date in format YYYY-MM-DD
     * @param bool        $raw      decide if return raw CSV format or array formatted report
     *
     * @return array
     */
    public function report($fromDate, $toDate = false, $raw = true)
    {
        $url = $this->apiURL.$this->trApiKey.'/transaction/report';
        $postData = [
            'from_date' => $fromDate,
        ];

        if (false !== $toDate) {
            $postData['to_date'] = $toDate;
        }

        $response = $this->requests($url, $postData);

        $this->checkError($response);
        $response[static::REPORT] = base64_decode($response[static::REPORT]);
        if (false === $raw) {
            $response = $this->associateReportArray($response);
        }

        return $response;
    }

    public function transactionRefundStatus()
    {
        $url = $this->apiURL.$this->trApiKey.'/chargeback/status';
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
     *
     * @return null|array
     */
    private function associateReportArray($response)
    {
        $allReportCsvLines = explode(self::CSV_EOL, $response['report']);

        $reportCsvLines = $this->removeCsvHeader($allReportCsvLines);

        $isEmpty = count($reportCsvLines) < 2;
        if ($isEmpty) {
            return;
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

    /** @return array */
    private function removeCsvHeader(array $reportCsvLines)
    {
        return array_slice($reportCsvLines, 2);
    }

    /** @return array */
    private function removeLineCounterColumn(array $values)
    {
        return array_slice($values, 1);
    }

    /**
     * @param string $csvLine
     *
     * @return array
     */
    private function csvLineToArray($csvLine)
    {
        return str_getcsv($csvLine, self::CSV_SEPARATOR);
    }
}
