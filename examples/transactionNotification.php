<?php

/*
 * Created by tpay.com
 */

class TransactionNotification
{
    private $tpay;

    public function __construct(tpay\PaymentBasic $object)
    {
        if (filter_input(INPUT_GET, ['transaction_notification'])) {
            $this->tpay = $object;
            $this->handleNotification();
        }
    }

    public function handleNotification()
    {

        return $this->tpay->checkPayment();
        /*
             * Example $paymentDetails response
            Array
            (
                [id] => 12345
                [tr_id] => TR-B7K-79FR0X
                [tr_date] => 2015-07-22 08:45:23
                [tr_crc] => order_200
                [tr_amount] => 40.96
                [tr_paid] => 40.96
                [tr_desc] => Sklep tpay.com
                [tr_status] => TRUE
                [tr_error] => none
                [tr_email] => kowalsky@example.com
                [test_mode] => 1
                [md5sum] => 0d1cf3083e2fe3b49d046c28e28d120c
            )
             */
    }

}
