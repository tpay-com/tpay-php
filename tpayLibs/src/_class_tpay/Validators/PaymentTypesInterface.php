<?php

namespace tpayLibs\src\_class_tpay\Validators;

interface PaymentTypesInterface
{
    public function getRequestFields();

    public function getResponseFields();
}
