<?php

/*
 * Created by tpay.com.
 * Date: 13.06.2017
 * Time: 15:50
 */
namespace tpayLibs\src\_class_tpay\Reports;

use tpayLibs\src\_class_tpay\PaymentSzkwal;

class SzkwalReports extends PaymentSzkwal
{

    /**
     * Method sed to acquire report of incoming payments. Depending on input parameters, the function can
     * return a list of payments for one client (providing cli_id or title) or list of all payments in the specified
     * period.
     *
     * @param int $clientId
     * @param string $title
     * @param int $startTime time in unix timestamp format
     * @param int|bool $endTime time in unix timestamp format, if false than now
     *
     * @return array
     */
    public function paymentsReport($clientId, $title, $startTime, $endTime = false)
    {
        $postData = array(
            static::APILOGIN => $this->szkwalApiLogin,
            static::APIPASS  => $this->szkwalApiPass,
        );
        $postData['from'] = date(static::DATE, $startTime);
        if ($clientId !== false) {
            $postData['cli_id'] = $clientId;
        }
        if ($title !== false) {
            $postData[static::TITLE] = $title;
        }
        $endTime = ($endTime !== false) ? $endTime : time();
        $postData['to'] = date(static::DATE, $endTime);

        $postData['hash'] = sha1(
            $postData['cli_id'] . $postData[static::TITLE] . $postData['from'] . $postData['to'] . $this->szkwalApiHash
        );

        return $this->request('PaymentsReport', $postData);
    }

    /**
     * Generate monthly report
     *
     * @param int $startTime time in unix timestamp format
     * @param int|bool $endTime time in unix timestamp format, if false than now
     *
     * @return array
     */
    public function monthlyReport($startTime, $endTime = false)
    {
        return $this->generateReport('MonthlyReport', $startTime, $endTime);
    }

    /**
     * Generate monthly report
     *
     * @param string $type generate daily or monthly report
     * @param int $startTime time in unix timestamp format
     * @param int|bool $endTime time in unix timestamp format, if false than now
     *
     * @return array
     */
    private function generateReport($type, $startTime, $endTime)
    {
        $postData = array(
            static::APILOGIN => $this->szkwalApiLogin,
            static::APIPASS  => $this->szkwalApiPass,
        );
        $postData['from'] = date(static::DATE, $startTime);
        if ($endTime !== false) {
            $postData['to'] = date(static::DATE, $endTime);
        } else {
            $postData['to'] = date(static::DATE);
        }

        $sha1 = sha1($postData['from'] . $postData['to'] . $this->szkwalApiHash);
        $postData['hash'] = $sha1;

        return $this->request($type, $postData);
    }

    /**
     * Generate daily report
     *
     * @param int $startTime time in unix timestamp format
     * @param int|bool $endTime time in unix timestamp format, if false than now
     *
     * @return array
     */
    public function dailyReport($startTime, $endTime = false)
    {
        return $this->generateReport('DailyReport', $startTime, $endTime);
    }

}
