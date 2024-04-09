<?php

namespace Tpay\Example;

use Tpay\OriginApi\Reports\BasicReports;
use Tpay\OriginApi\Utilities\TException;

include_once 'config.php';
include_once 'loader.php';

final class TransactionRefundStatus extends BasicReports
{
    const TRID = 'TR-BRA-KGZK0X';

    public function __construct()
    {
        $this->merchantSecret = 'demo';
        $this->merchantId = 1010;
        $this->trApiKey = '75f86137a6635df826e3efe2e66f7c9a946fdde1';
        $this->trApiPass = 'p@$$w0rd#@!';
        parent::__construct();
    }

    public function getTransactionRefundsStatuses()
    {
        try {
            $this->transactionID = self::TRID;
            $result = $this->transactionRefundStatus();
            var_dump($result);
        } catch (TException $e) {
            var_dump($e->getMessage());
        }
    }
}

(new TransactionRefundStatus())->getTransactionRefundsStatuses();
