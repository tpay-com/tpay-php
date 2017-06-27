<?php

/*
 * Created by tpay.com.
 * Date: 13.06.2017
 * Time: 15:50
 */

namespace tpayLibs\src\_class_tpay\Refunds;

use tpayLibs\src\_class_tpay\Utilities\TException;
use tpayLibs\src\_class_tpay\TransactionApi;

class BasicRefunds extends TransactionApi
{
    /**
     * Refund all amount to customer
     *
     * @return array
     *
     * @throws TException
     */
    public function refund()
    {
        $url = $this->apiURL . $this->trApiKey . '/chargeback/transaction';

        $response = $this->requests($url, array(static::TITLE => $this->transactionID));

        $this->checkError($response);

        return $response;
    }

    /**
     * Refund custom amount to customer
     *
     * @param float $amount refund amount
     *
     * @return array
     *
     * @throws TException
     */
    public function refundAny($amount)
    {
        $url = $this->apiURL . $this->trApiKey . '/chargeback/any';

        $postData = array(
            static::TITLE       => $this->transactionID,
            'chargeback_amount' => $amount,
        );
        $response = $this->requests($url, $postData);

        $this->checkError($response);

        return $response;
    }

}
