<?php
namespace tpayLibs\src\_class_tpay\Refunds;

use tpayLibs\src\_class_tpay\Utilities\TException;
use tpayLibs\src\_class_tpay\TransactionApi;
use tpayLibs\src\_class_tpay\Utilities\Util;

class BasicRefunds extends TransactionApi
{
    /**
     * Refund full amount to customer
     * @return array
     * @throws TException
     */
    public function refund()
    {
        $url = $this->apiURL.$this->trApiKey.'/chargeback/transaction';
        $requestData = [static::TITLE => $this->transactionID];
        Util::log('Refund request', print_r($requestData, true));
        $response = $this->requests($url, $requestData);
        $this->checkError($response);
        Util::log('Refund response', print_r($response, true));

        return $response;
    }

    /**
     * Refund custom amount to customer
     * @param float $amount refund amount
     * @return array
     * @throws TException
     */
    public function refundAny($amount)
    {
        $url = $this->apiURL.$this->trApiKey.'/chargeback/any';
        $requestData = [
            static::TITLE => $this->transactionID,
            'chargeback_amount' => $amount,
        ];
        Util::log('Refund any request', print_r($requestData, true));
        $response = $this->requests($url, $requestData);
        $this->checkError($response);
        Util::log('Refund any response', print_r($response, true));

        return $response;
    }

}
