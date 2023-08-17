<?php

namespace Tpay\Validators;

interface PaymentTypesInterface
{
    public function getRequestFields();

    public function getResponseFields();
}
