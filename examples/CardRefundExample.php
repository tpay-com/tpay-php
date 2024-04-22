<?php

namespace Tpay\Example;

use Tpay\OriginApi\Refunds\CardRefunds;

include_once 'config.php';
include_once 'loader.php';

final class CardRefundExample extends CardRefunds
{
    public function __construct()
    {
        // This is pre-configured sandbox access. You should use your own data in production mode.
        $this->cardApiKey = 'bda5eda723bf1ae71a82e90a249803d3f852248d';
        $this->cardApiPass = 'IhZVgraNcZoWPLgA1yQcGMIzquVWWrWtJ';
        $this->cardKeyRSA = 'LS0tLS1CRUdJTiBQVUJMSUMgS0VZLS0tLS0NCk1JR2ZNQTBHQ1NxR1NJYjNEUUVCQVFVQUE0R05BRENCaVFLQmdRQ2NLRTVZNU1Wemd5a1Z5ODNMS1NTTFlEMEVrU2xadTRVZm1STS8NCmM5L0NtMENuVDM2ekU0L2dMRzBSYzQwODRHNmIzU3l5NVpvZ1kwQXFOVU5vUEptUUZGVyswdXJacU8yNFRCQkxCcU10TTVYSllDaVQNCmVpNkx3RUIyNnpPOFZocW9SK0tiRS92K1l1YlFhNGQ0cWtHU0IzeHBhSUJncllrT2o0aFJDOXk0WXdJREFRQUINCi0tLS0tRU5EIFBVQkxJQyBLRVktLS0tLQ==';
        $this->cardVerificationCode = '6680181602d396e640cb091ea5418171';
        $this->cardHashAlg = 'sha512';
        parent::__construct();
    }

    public function refund($transactionId, $refundDescription, $refundAmount = null)
    {
        // If refund amount is empty, the method call will refund full transaction amount
        if (!is_null($refundAmount)) {
            $this->setAmount($refundAmount);
        }
        $result = parent::refund($transactionId, $refundDescription);

        return 1 === $result['result'];
    }
}
