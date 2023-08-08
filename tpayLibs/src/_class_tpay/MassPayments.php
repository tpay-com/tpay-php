<?php

namespace tpayLibs\src\_class_tpay;

use tpayLibs\src\_class_tpay\Utilities\TException;

class MassPayments extends TransactionApi
{
    /**
     * Create mass payment
     *
     * @param string $csv content of csv file
     *
     * @throws TException
     *
     * @return array
     */
    public function massPaymentCreate($csv)
    {
        $url = $this->apiURL.$this->trApiKey.'/masspayment/create';

        $csvEncode = base64_encode($csv);

        $postData = [
            'csv' => $csvEncode,
            'sign' => sha1($this->merchantId.$csv.$this->merchantSecret),
        ];
        $response = $this->requests($url, $postData);

        $this->checkError($response);

        return $response;
    }

    /**
     * Authorize mass payment
     *
     * @param string $packId pack id from massPaymentCreate
     *
     * @throws TException
     *
     * @return array
     */
    public function massPaymentAuthorize($packId)
    {
        $url = $this->apiURL.$this->trApiKey.'/masspayment/authorize';

        $postData = [
            static::PACK_ID => $packId,
        ];
        $response = $this->requests($url, $postData);

        $this->checkError($response);

        return $response;
    }

    /**
     * Get information about packs
     *
     * @param bool|string $packId   pack id from massPaymentCreate
     * @param bool|string $fromDate start date in format YYYY-MM-DD
     * @param bool|string $toDate   end date in format YYYY-MM-DD
     *
     * @throws TException
     *
     * @return array
     */
    public function massPaymentPacks($packId = false, $fromDate = false, $toDate = false)
    {
        $url = $this->apiURL.$this->trApiKey.'/masspayment/packs';

        $postData = [];

        if (false !== $packId) {
            $postData[static::PACK_ID] = $packId;
        }
        if (false !== $fromDate) {
            $postData['fromDate'] = $fromDate;
        }
        if (false !== $toDate) {
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
     * @param string $trId   transaction id
     *
     * @throws TException
     *
     * @return array
     */
    public function massPaymentTransfers($packId, $trId)
    {
        $url = $this->apiURL.$this->trApiKey.'/masspayment/transfers';

        $postData = [
            static::PACK_ID => $packId,
            'trId' => $trId,
        ];
        $response = $this->requests($url, $postData);

        $this->checkError($response);

        return $response;

    }
}
