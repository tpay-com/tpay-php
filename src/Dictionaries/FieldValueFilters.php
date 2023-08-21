<?php

namespace Tpay\OriginApi\Dictionaries;

class FieldValueFilters
{
    const FILTERS = [
        FieldsConfigDictionary::PHONE => '/[^0-9]\+ /',
        FieldsConfigDictionary::NUMBERS => '/[^0-9]/',
        'letters' => '/[^A-Za-z]/',
        'mixed' => '/[^A-Za-z0-9]/',
        'date' => '/[^0-9 \-:]/',
        FieldsConfigDictionary::TEXT => '/[^\-\p{Latin}A-Za-z0-9 \.,#_()\/\!]/u',
        'name' => '/[^\-\p{Latin} ]/u',
        'sign' => '/[^A-Za-z!\., _\-0-9]/',
    ];
}
