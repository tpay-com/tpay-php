<?php

namespace Tpay\OriginApi\Validators;

interface PaymentTypesInterface
{
    public function getRequestFields();

    public function getResponseFields();
}
