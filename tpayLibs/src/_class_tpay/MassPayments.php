<?php

/*
 * Created by tpay.com.
 * Date: 13.06.2017
 * Time: 15:47
 */

namespace tpayLibs\src\_class_tpay;

use tpayLibs\src\_class_tpay\Utilities\TException;

class MassPayments extends TransactionApi
{
    /**
     * Create mass payment
     *
     * @param string $csv content of csv file
     *
     * @return array
     * @throws TException
     */
    public function massPaymentCreate($csv)
    {
        $url = $this->apiURL . $this->trApiKey . '/masspayment/create';

        $csvEncode = base64_encode($csv);

        $postData = array(
            'csv'  => $csvEncode,
            'sign' => sha1($this->merchantId . $csv . $this->merchantSecret),
        );
        $response = $this->requests($url, $postData);

        $this->checkError($response);

        return $response;
    }

    /**
     * Authorize mass payment
     *
     * @param string $packId pack id from massPaymentCreate
     *
     * @return array
     * @throws TException
     */
    public function massPaymentAuthorize($packId)
    {
        $url = $this->apiURL . $this->trApiKey . '/masspayment/authorize';

        $postData = array(
            static::PACK_ID => $packId,
        );
        $response = $this->requests($url, $postData);

        $this->checkError($response);

        return $response;
    }

    /**
     * Get information about packs
     *
     * @param string|bool $packId pack id from massPaymentCreate
     * @param string|bool $fromDate start date in format YYYY-MM-DD
     * @param string|bool $toDate end date in format YYYY-MM-DD
     *
     * @return array
     * @throws TException
     */
    public function massPaymentPacks($packId = false, $fromDate = false, $toDate = false)
    {
        $url = $this->apiURL . $this->trApiKey . '/masspayment/packs';

        $postData = array();

        if ($packId !== false) {
            $postData[static::PACK_ID] = $packId;
        }
        if ($fromDate !== false) {
            $postData['fromDate'] = $fromDate;
        }
        if ($toDate !== false) {
            $postData['toDate'] = $toDate;
        }

        $response = $this->requests($url, $postData);

        $this->checkError($response);
        return $response;

    }

    /**
     * Authorize mass payment
     *
     * @param string $packId pack id from massPaymentCreate
     * @param string $trId transaction id
     *
     * @return array
     * @throws TException
     */
    public function massPaymentTransfers($packId, $trId)
    {
        $url = $this->apiURL . $this->trApiKey . '/masspayment/transfers';

        $postData = array(
            static::PACK_ID => $packId,
            'trId'          => $trId,
        );
        $response = $this->requests($url, $postData);

        $this->checkError($response);

        return $response;

    }
}
