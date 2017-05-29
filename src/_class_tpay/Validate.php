<?php

/*
 * Created by tpay.com
 */

namespace tpay;

/**
 * Class Fields
 *
 * Include methods responsible for receiving and validating input data
 *
 * @package tpay
 */
class Validate
{
    const PAYMENT_TYPE_BASIC = 'basic';
    const PAYMENT_TYPE_BASIC_API = 'basic_api';
    const PAYMENT_TYPE_CARD = 'card';
    const PAYMENT_TYPE_CARD_DIRECT = 'card_direct';
    const PAYMENT_TYPE_SZKWAL = 'szkwal';
    const PAYMENT_TYPE_WHITE_LABEL = 'whiteLabel';
    const PAYMENT_TYPE_EHAT = 'ehat';
    const PAYMENT_TYPE_SMS = 'sms';
    const PAYMENT_TYPE_BLIK_T6STANDARD = 'T6Standard';
    const PAYMENT_TYPE_BLIK_T6REGISTER = 'T6Register';
    const ALIAS = 'alias';
    const PAYMENT_TYPE_BLIK_ALIAS = 'blikAlias';
    const ALIAS_BLIK = 'aliasNotification';
    const CARD_DEREGISTER = 'deregister';
    const NUMBERS = 'numbers';
    const PHONE = 'phone';
    const REQUIRED = 'required';
    const VALIDATION = 'validation';
    const FLOAT = 'float';
    const FILTER = 'filter';
    const STRING = 'string';
    const ARR = 'array';
    const MAXLENGHT_128 = 'maxlenght_128';
    const OPTIONS = 'options';
    const KANAL = 'kanal';
    const MAXLENGHT_512 = 'maxlenght_512';
    const EMAIL_LIST = 'email_list';
    const OPIS_DODATKOWY = 'opis_dodatkowy';
    const MAXLENGHT_32 = 'maxlenght_32';
    const EMAIL = 'email';
    const MAXLENGHT_64 = 'maxlenght_64';
    const TEST_MODE = 'test_mode';
    const AMOUNT = 'amount';
    const ORDER_ID = 'order_id';
    const MAXLENGHT_40 = 'maxlenght_40';
    const MINLENGTH_40 = 'minlength_40';
    const MAXLENGTH_40 = 'maxlength_40';
    const UNKNOWN_PAYMENT_TYPE_S = 'Unknown payment type: %s';
    const TYPE = 'type';
    const BOOLEAN = 'boolean';
    const TEXT = 'text';
    private static $cardPaymentLanguages = array(
        'pl' => 'pl_PL',
        'en' => 'en_EN',
        'es' => 'sp_SP',
        'it' => 'it_IT',
        'ru' => 'ru_RU',
        'fr' => 'fr_FR',
    );
    /**
     * List of ISO currency codes supported on card payments
     * @var array
     */
    private static $isoCurrencyCodes = array(
        784 => 'AED',
        41  => 'AMD',
        532 => 'ANG',
        973 => 'AOA',
        26  => 'ARS',
        30  => 'AUD',
        533 => 'AWG',
        944 => 'AZN',
        977 => 'BAM',
        42  => 'BBD',
        40  => 'BDT',
        975 => 'BGN',
        4   => 'BHD',
        108 => 'BIF',
        48  => 'BMD',
        6   => 'BOB',
        986 => 'BRL',
        36  => 'BSD',
        58  => 'BWP',
        933 => 'BYN',
        124 => 'CAD',
        976 => 'CDF',
        756 => 'CHF',
        152 => 'CLP',
        156 => 'CNY',
        170 => 'COP',
        188 => 'CRC',
        132 => 'CVE',
        203 => 'CZK',
        208 => 'DKK',
        214 => 'DOP',
        10  => 'DZD',
        818 => 'EGP',
        230 => 'ETB',
        978 => 'EUR',
        242 => 'FJD',
        826 => 'GBP',
        981 => 'GEL',
        936 => 'GHS',
        270 => 'GMD',
        320 => 'GTQ',
        328 => 'GYD',
        344 => 'HKD',
        340 => 'HNL',
        191 => 'HRK',
        332 => 'HTG',
        348 => 'HUF',
        360 => 'IDR',
        376 => 'ILS',
        356 => 'INR',
        364 => 'IRR',
        352 => 'ISK',
        388 => 'JMD',
        400 => 'JOD',
        392 => 'JPY',
        404 => 'KES',
        417 => 'KGS',
        116 => 'KHR',
        410 => 'KRW',
        414 => 'KWD',
        136 => 'KYD',
        398 => 'KZT',
        422 => 'LBP',
        144 => 'LKR',
        434 => 'LYD',
        504 => 'MAD',
        498 => 'MDL',
        969 => 'MGA',
        807 => 'MKD',
        104 => 'MMK',
        496 => 'MNT',
        446 => 'MOP',
        480 => 'MUR',
        454 => 'MWK',
        484 => 'MXN',
        458 => 'MYR',
        516 => 'NAD',
        566 => 'NGN',
        558 => 'NIO',
        578 => 'NOK',
        524 => 'NPR',
        554 => 'NZD',
        512 => 'OMR',
        590 => 'PAB',
        604 => 'PEN',
        598 => 'PGK',
        608 => 'PHP',
        586 => 'PKR',
        985 => 'PLN',
        600 => 'PYG',
        634 => 'QAR',
        946 => 'RON',
        941 => 'RSD',
        643 => 'RUB',
        646 => 'RWF',
        682 => 'SAR',
        690 => 'SCR',
        752 => 'SEK',
        702 => 'SGD',
        760 => 'SYP',
        764 => 'THB',
        788 => 'TND',
        949 => 'TRY',
        780 => 'TTD',
        901 => 'TWD',
        834 => 'TZS',
        980 => 'UAH',
        840 => 'USD',
        858 => 'UYU',
        860 => 'UZS',
        704 => 'VND',
        882 => 'WST',
        950 => 'XAF',
        951 => 'XCD',
        952 => 'XOF',
        953 => 'XPF',
        886 => 'YER',
        710 => 'ZAR',
        967 => 'ZMW',
    );
    /**
     * List of ISO 3166-1 country codes
     * @var array
     */
    private static $isoCountryCodes = array(
        'AF' => 'AFG',
        'AX' => 'ALA',
        'AL' => 'ALB',
        'DZ' => 'DZA',
        'AS' => 'ASM',
        'AD' => 'AND',
        'AO' => 'AGO',
        'AI' => 'AIA',
        'AQ' => 'AQ',
        'AG' => 'ATG',
        'AR' => 'ARG',
        'AM' => 'ARM',
        'AW' => 'ABW',
        'AU' => 'AUS',
        'AT' => 'AUT',
        'AZ' => 'AZE',
        'BS' => 'BHS',
        'BH' => 'BHR',
        'BD' => 'BGD',
        'BB' => 'BRB',
        'BY' => 'BLR',
        'BE' => 'BEL',
        'BZ' => 'BLZ',
        'BJ' => 'BEN',
        'BM' => 'BMU',
        'BT' => 'BTN',
        'BO' => 'BOL',
        'BA' => 'BIH',
        'BW' => 'BWA',
        'BV' => 'BV',
        'BR' => 'BRA',
        'IO' => 'IO',
        'BN' => 'BRN',
        'BG' => 'BGR',
        'BF' => 'BFA',
        'BI' => 'BDI',
        'KH' => 'KHM',
        'CM' => 'CMR',
        'CA' => 'CAN',
        'CV' => 'CV',
        'KY' => 'CYM',
        'CF' => 'CAF',
        'TD' => 'TCD',
        'CL' => 'CHL',
        'CN' => 'CHN',
        'CX' => 'CX',
        'CC' => 'CC',
        'CO' => 'COL',
        'KM' => 'COM',
        'CG' => 'COG',
        'CD' => 'COD',
        'CK' => 'COK',
        'CR' => 'CRI',
        'CI' => 'CIV',
        'HR' => 'HRV',
        'CU' => 'CUB',
        'CY' => 'CYP',
        'CZ' => 'CZE',
        'DK' => 'DNK',
        'DJ' => 'DJI',
        'DM' => 'DMA',
        'DO' => 'DOM',
        'EC' => 'ECU',
        'EG' => 'EGY',
        'SV' => 'SLV',
        'GQ' => 'GNQ',
        'ER' => 'ERI',
        'EE' => 'EST',
        'ET' => 'ETH',
        'FK' => 'FLK',
        'FO' => 'FRO',
        'FJ' => 'FJI',
        'FI' => 'FIN',
        'FR' => 'FRA',
        'GF' => 'GUF',
        'PF' => 'PYF',
        'TF' => 'IF',
        'GA' => 'GAB',
        'GM' => 'GMB',
        'GE' => 'GEO',
        'DE' => 'DEU',
        'GH' => 'GHA',
        'GI' => 'GIB',
        'GR' => 'GRC',
        'GL' => 'GRL',
        'GD' => 'GRD',
        'GP' => 'GLP',
        'GU' => 'GUM',
        'GT' => 'GTM',
        'GG' => 'GGY',
        'GN' => 'GIN',
        'GW' => 'GNB',
        'GY' => 'GUY',
        'HT' => 'HTI',
        'HM' => 'HM',
        'VA' => 'VAT',
        'HN' => 'HND',
        'HK' => 'HKG',
        'HU' => 'HUN',
        'IS' => 'ISL',
        'IN' => 'IND',
        'ID' => 'IDN',
        'IR' => 'IRN',
        'IQ' => 'IRQ',
        'IE' => 'IRL',
        'IM' => 'IMN',
        'IL' => 'ISR',
        'IT' => 'ITA',
        'JM' => 'JAM',
        'JP' => 'JPN',
        'JE' => 'JEY',
        'JO' => 'JOR',
        'KZ' => 'KAZ',
        'KE' => 'KEN',
        'KI' => 'KIR',
        'KR' => 'PRK',
        'KW' => 'KWT',
        'KG' => 'KGZ',
        'LA' => 'LAO',
        'LV' => 'LVA',
        'LB' => 'LBN',
        'LS' => 'LSO',
        'LR' => 'LBR',
        'LY' => 'LBY',
        'LI' => 'LIE',
        'LT' => 'LTU',
        'LU' => 'LUX',
        'MO' => 'MAC',
        'MK' => 'MKD',
        'MG' => 'MDG',
        'MW' => 'MWI',
        'MY' => 'MYS',
        'MV' => 'MDV',
        'ML' => 'MLI',
        'MT' => 'MLT',
        'MH' => 'MHL',
        'MQ' => 'MTQ',
        'MR' => 'MRT',
        'MU' => 'MUS',
        'YT' => 'MYT',
        'MX' => 'MEX',
        'FM' => 'FSM',
        'MD' => 'MDA',
        'MC' => 'MCO',
        'MN' => 'MNG',
        'ME' => 'MNE',
        'MS' => 'MSR',
        'MA' => 'MAR',
        'MZ' => 'MOZ',
        'MM' => 'MMR',
        'NA' => 'NAM',
        'NR' => 'NRU',
        'NP' => 'NPL',
        'NL' => 'NLD',
        'AN' => 'AN',
        'NC' => 'NCL',
        'NZ' => 'NZL',
        'NI' => 'NIC',
        'NE' => 'NER',
        'NG' => 'NGA',
        'NU' => 'NIU',
        'NF' => 'NFK',
        'MP' => 'MNP',
        'NO' => 'NOR',
        'OM' => 'OMN',
        'PK' => 'PAK',
        'PW' => 'PLW',
        'PS' => 'PSE',
        'PA' => 'PAN',
        'PG' => 'PNG',
        'PY' => 'PRY',
        'PE' => 'PER',
        'PH' => 'PHL',
        'PN' => 'PCN',
        'PL' => 'POL',
        'PT' => 'PRT',
        'PR' => 'PRI',
        'QA' => 'QAT',
        'RE' => 'REU',
        'RO' => 'ROU',
        'RU' => 'RUS',
        'RW' => 'RWA',
        'BL' => 'BLM',
        'SH' => 'SHN',
        'KN' => 'KNA',
        'LC' => 'LCA',
        'MF' => 'MAF',
        'PM' => 'SPM',
        'VC' => 'VCT',
        'WS' => 'WSM',
        'SM' => 'SMR',
        'ST' => 'STP',
        'SA' => 'SAU',
        'SN' => 'SEN',
        'RS' => 'SRB',
        'SC' => 'SYC',
        'SL' => 'SLE',
        'SG' => 'SGP',
        'SK' => 'SVK',
        'SI' => 'SVN',
        'SB' => 'SLB',
        'SO' => 'SOM',
        'ZA' => 'ZAF',
        'GS' => 'GS',
        'ES' => 'ESP',
        'LK' => 'LKA',
        'SD' => 'SSD',
        'SR' => 'SUR',
        'SJ' => 'SJM',
        'SZ' => 'SWZ',
        'SE' => 'SWE',
        'CH' => 'CHE',
        'SY' => 'SYR',
        'TW' => 'TW',
        'TJ' => 'TJK',
        'TZ' => 'TZA',
        'TH' => 'THA',
        'TL' => 'TLS',
        'TG' => 'TGO',
        'TK' => 'TKL',
        'TO' => 'TON',
        'TT' => 'TTO',
        'TN' => 'TUN',
        'TR' => 'TUR',
        'TM' => 'TKM',
        'TC' => 'TCA',
        'TV' => 'TUV',
        'UG' => 'UGA',
        'UA' => 'UKR',
        'AE' => 'ARE',
        'GB' => 'GBR',
        'US' => 'USA',
        'UM' => 'UM',
        'UY' => 'URY',
        'UZ' => 'UZB',
        'VU' => 'VUT',
        'VE' => 'VEN',
        'VN' => 'VNM',
        'VG' => 'VG',
        'VI' => 'VIR',
        'WF' => 'WLF',
        'EH' => 'ESH',
        'YE' => 'YEM',
        'ZM' => 'ZMB',
        'ZW' => 'ZWE',
    );
    /**
     * List of supported request fields for blik payment
     * @var array
     */
    private static $blikPaymentRequestFields = array(
        /**
         * Transaction amount with dot as decimal separator.
         */
        'code'  => array(
            self::REQUIRED   => true,
            self::VALIDATION => array(self::FLOAT, 'maxlenght_6', 'minlenght_6'),
            self::FILTER     => self::NUMBERS
        ),
        'title' => array(
            self::REQUIRED   => true,
            self::VALIDATION => array(self::STRING),
            self::FILTER     => self::TEXT
        ),
        'alias' => array(
            self::REQUIRED   => true,
            self::VALIDATION => array(self::ARR),
        ),
    );
    /**
     * List of supported request fields for basic payment
     * @var array
     */
    private static $panelPaymentRequestFields = array(

        /**
         * Transaction amount with dot as decimal separator.
         */
        'kwota'               => array(
            self::REQUIRED   => true,
            self::VALIDATION => array(self::FLOAT),
        ),
        /**
         * Transaction description
         */
        'opis'                => array(
            self::REQUIRED   => true,
            self::VALIDATION => array(self::STRING, self::MAXLENGHT_128),
            self::FILTER     => self::TEXT
        ),
        /**
         * The secondary parameter to the transaction identification.
         * After the transaction returned as a parameter tr_crc.
         */
        'crc'                 => array(
            self::REQUIRED   => false,
            self::VALIDATION => array(self::STRING, self::MAXLENGHT_128),
        ),
        /**
         * Allow only online payment.
         * Prevents the channel selection, which at the moment is not able to post real-time payment.
         */
        'online'              => array(
            self::REQUIRED   => false,
            self::VALIDATION => array(self::OPTIONS),
            self::OPTIONS    => array(0, 1),
        ),
        /**
         * Imposing the customer the pre-payment channel.
         * Could be changed manually by customer.
         * Required for register transaction by transaction API
         */
        self::KANAL           => array(
            self::REQUIRED   => false,
            self::VALIDATION => array('uint'),
        ),
        /**
         * Customer will be presented only the selected group.
         */
        'grupa'               => array(
            self::REQUIRED   => false,
            self::VALIDATION => array('unit'),
        ),
        /**
         * Customer will be redirected to bank login page.
         */
        'direct'            => array(
            self::REQUIRED   => false,
            self::VALIDATION => array('unit'),
        ),
        /**
         * The resulting URL return address that will send the result of a transaction in the form POST parameters.
         */
        'wyn_url'             => array(
            self::REQUIRED   => false,
            self::VALIDATION => array(self::STRING, self::MAXLENGHT_512),
            self::FILTER     => 'url'
        ),
        /**
         * E-mail address to which you will be notified about the status of the transaction.
         */
        'wyn_email'           => array(
            self::REQUIRED   => false,
            self::VALIDATION => array(self::EMAIL_LIST),
        ),
        /**
         * Description payees during the transaction.
         */
        'opis_sprzed'         => array(
            self::REQUIRED   => false,
            self::VALIDATION => array(self::STRING, self::MAXLENGHT_128),
            self::FILTER     => self::TEXT
        ),
        /**
         * Optional field used during card transactions processed through Elavon.
         * The value of the field is passed to Elavon as „TEKST REF. TRANSAKCJI”.
         * Acceptable characters are a-z, AZ (without Polish), 0-9 and space.
         * All others will be removed.
         * Max 32 signs.
         */
        self::OPIS_DODATKOWY  => array(
            self::REQUIRED   => false,
            self::VALIDATION => array(self::OPIS_DODATKOWY, self::MAXLENGHT_32),
            self::FILTER     => 'mixed'
        ),
        /**
         * The URL to which the customer will be transferred after successful completion of the transaction.
         */
        'pow_url'             => array(
            self::REQUIRED   => false,
            self::VALIDATION => array(self::STRING, self::MAXLENGHT_512),
            self::FILTER     => 'url'
        ),
        /**
         * The URL to which the client will be transferred in the event of an error.
         * Default is pow_url
         */
        'pow_url_blad'        => array(
            self::REQUIRED   => false,
            self::VALIDATION => array(self::STRING, self::MAXLENGHT_512),
            self::FILTER     => 'url'
        ),
        /**
         * Transactional panel language.
         * Default is PL
         */
        'jezyk'               => array(
            self::REQUIRED   => false,
            self::VALIDATION => array(self::OPTIONS),
            self::OPTIONS    => array('PL', 'EN', 'DE', 'IT', 'ES', 'FR', 'RU'),
        ),
        /**
         * Customer email address.
         */
        self::EMAIL           => array(
            self::REQUIRED   => false,
            self::VALIDATION => array(self::STRING, self::MAXLENGHT_64),
            self::FILTER     => 'mail'
        ),
        /**
         * Customer surname.
         */
        'nazwisko'            => array(
            self::REQUIRED   => false,
            self::VALIDATION => array(self::STRING, self::MAXLENGHT_64),
            self::FILTER     => 'name'
        ),
        /**
         * Customer name.
         */
        'imie'                => array(
            self::REQUIRED   => false,
            self::VALIDATION => array(self::STRING, self::MAXLENGHT_64),
            self::FILTER     => 'name'
        ),
        /**
         * Customer address.
         */
        'adres'               => array(
            self::REQUIRED   => false,
            self::VALIDATION => array(self::STRING, self::MAXLENGHT_64),
            self::FILTER     => self::TEXT
        ),
        /**
         * Customer city.
         */
        'miasto'              => array(
            self::REQUIRED   => false,
            self::VALIDATION => array(self::STRING, self::MAXLENGHT_32),
            self::FILTER     => 'name'
        ),
        /**
         * Customer postal code.
         */
        'kod'                 => array(
            self::REQUIRED   => false,
            self::VALIDATION => array(self::STRING, 'maxlenght_10'),
            self::FILTER     => self::TEXT
        ),
        /**
         * Country code.
         * Alphanumeric, 2 or 3 signs compatible with ISO 3166-1
         */
        'kraj'                => array(
            self::REQUIRED   => false,
            self::VALIDATION => array('country_code'),
        ),
        /**
         * Customer phone.
         */
        'telefon'             => array(
            self::REQUIRED   => false,
            self::VALIDATION => array(self::STRING, 'maxlenght_16'),
            self::FILTER     => self::PHONE
        ),
        /**
         * The parameter indicating acceptance of Terms tpay if it is available on the payee.
         */
        'akceptuje_regulamin' => array(
            self::REQUIRED   => false,
            self::VALIDATION => array(self::OPTIONS),
            self::OPTIONS    => array(0, 1),
        ),
    );
    /**
     * List of fields available in response for blik payment
     * @var array
     */
    private static $blikAliasResponseFields = array(
        'id'        => array(
            self::REQUIRED   => true,
            self::TYPE       => self::FLOAT,
            self::VALIDATION => array(self::FLOAT),
        ),
        'event'     => array(
            self::REQUIRED   => true,
            self::TYPE       => self::STRING,
            self::VALIDATION => array(self::STRING),
        ),
        'msg_value' => array(
            self::REQUIRED   => true,
            self::TYPE       => self::ARR,
            self::VALIDATION => array(self::ARR),
        ),
    );
    /**
     * List of fields available in response for basic payment
     * @var array
     */
    private static $panelPaymentResponseFields = array(
        /**
         * The merchant ID assigned by the system tpay
         */
        'id'            => array(
            self::REQUIRED   => true,
            self::TYPE       => self::FLOAT,
            self::VALIDATION => array(self::FLOAT),
        ),
        /**
         * The transaction ID assigned by the system tpay
         */
        'tr_id'         => array(
            self::REQUIRED   => true,
            self::TYPE       => self::STRING,
            self::VALIDATION => array(self::STRING),
        ),
        /**
         * Date of transaction.
         */
        'tr_date'       => array(
            self::REQUIRED   => true,
            self::TYPE       => self::STRING,
            self::VALIDATION => array(self::STRING),

        ),
        /**
         * The secondary parameter to the transaction identification.
         */
        'tr_crc'        => array(
            self::REQUIRED   => true,
            self::TYPE       => self::STRING,
            self::VALIDATION => array(self::STRING),
        ),
        /**
         * Transaction amount.
         */
        'tr_amount'     => array(
            self::REQUIRED   => true,
            self::TYPE       => self::FLOAT,
            self::VALIDATION => array(self::FLOAT),
        ),
        /**
         * The amount paid for the transaction.
         * Note: Depending on the settings, the amount paid can be different
         * than transactions eg. When the customer does overpayment.
         */
        'tr_paid'       => array(
            self::REQUIRED   => true,
            self::TYPE       => self::FLOAT,
            self::VALIDATION => array(self::FLOAT),
        ),
        /**
         * Description of the transaction.
         */
        'tr_desc'       => array(
            self::REQUIRED   => true,
            self::TYPE       => self::STRING,
            self::VALIDATION => array(self::STRING),
        ),
        /**
         * Transaction status: TRUE in the case of the correct result or FALSE in the case of an error.
         * Note: Depending on the settings, the transaction may be correct status,
         * even if the amount paid is different from the amount of the transaction!
         * Eg. If the Seller accepts the overpayment or underpayment threshold is set.
         */
        'tr_status'     => array(
            self::REQUIRED   => true,
            self::TYPE       => self::STRING,
            self::VALIDATION => array(self::OPTIONS),
            self::OPTIONS    => array(0, 1, true, false, 'TRUE', 'FALSE'),
        ),
        /**
         * Transaction error status.
         * Could have the following values:
         * - none
         * - overpay
         * - surcharge
         */
        'tr_error'      => array(
            self::REQUIRED   => true,
            self::TYPE       => self::STRING,
            self::VALIDATION => array(self::OPTIONS),
            self::OPTIONS    => array('none', 'overpay', 'surcharge'),
        ),
        /**
         * Customer email address.
         */
        'tr_email'      => array(
            self::REQUIRED   => true,
            self::TYPE       => self::STRING,
            self::VALIDATION => array(self::EMAIL_LIST),
        ),
        /**
         * The checksum verifies the data sent to the payee.
         * It is built according to the following scheme using the MD5 hash function:
         * MD5(id + tr_id + tr_amount + tr_crc + security code)
         */
        'md5sum'        => array(
            self::REQUIRED   => true,
            self::TYPE       => self::STRING,
            self::VALIDATION => array(self::STRING, 'maxlength_32', 'minlength_32'),
        ),
        /**
         * Transaction marker indicates whether the transaction was executed in test mode:
         * 1 – in test mode
         * 0 – in normal mode
         */
        self::TEST_MODE => array(
            self::REQUIRED   => false,
            self::TYPE       => 'int',
            self::VALIDATION => array(self::OPTIONS),
            self::OPTIONS    => array(0, 1),
        ),
        /**
         * The parameter is sent only when you use a payment channel or MasterPass or V.me.
         * Could have the following values: „masterpass” or „vme”
         */
        'wallet'        => array(
            self::REQUIRED => false,
            self::TYPE     => self::STRING,
        ),
    );
    /**
     * List of supported fields for card payment request
     * @var array
     */
    private static $cardPaymentRequestFields = array(
        /**
         * Transaction amount
         */
        self::AMOUNT   => array(
            self::REQUIRED   => true,
            self::VALIDATION => array(self::FLOAT),
        ),
        /**
         * Client name
         */
        'name'         => array(
            self::REQUIRED   => true,
            self::VALIDATION => array(self::STRING, self::MAXLENGHT_64),
        ),
        /**
         * Client email
         */
        self::EMAIL    => array(
            self::REQUIRED   => true,
            self::VALIDATION => array(self::STRING, self::EMAIL_LIST),
        ),
        /**
         * Sale description
         */
        'desc'         => array(
            self::REQUIRED   => true,
            self::VALIDATION => array(self::STRING, self::MAXLENGHT_128),
        ),
        /**
         * Value from partner system
         */
        self::ORDER_ID => array(
            self::REQUIRED   => false,
            self::VALIDATION => array(self::STRING, self::MAXLENGHT_40),
        ),
        /**
         * Value from partner system
         */
        'currency'     => array(
            self::REQUIRED   => true,
            self::VALIDATION => array(self::OPTIONS),
            self::OPTIONS    => array('985', '826', '840', '978', '203'),
        ),
    );
    /**
     * List of fields available in card payment response
     * @var array
     */
    private static $cardPaymentResponseFields = array(
        /**
         * Method type
         */
        self::TYPE      => array(
            self::REQUIRED   => true,
            self::TYPE       => self::STRING,
            self::VALIDATION => array(self::OPTIONS),
            self::OPTIONS    => array('sale', 'refund', 'deregister'),
        ),
        /**
         * Merchant optional value
         */
        self::ORDER_ID  => array(
            self::REQUIRED   => true,
            self::TYPE       => self::STRING,
            self::VALIDATION => array(self::STRING, self::MAXLENGHT_40)
        ),
        /**
         * Payment status
         */
        'status'        => array(
            self::REQUIRED   => true,
            self::TYPE       => self::STRING,
            self::VALIDATION => array(self::OPTIONS),
            self::OPTIONS    => array('correct', 'declined'),
        ),
        /**
         * Message checksum
         */
        'sign'          => array(
            self::REQUIRED   => true,
            self::TYPE       => self::STRING,
            self::VALIDATION => array(self::STRING, self::MAXLENGHT_128, self::MINLENGTH_40)
        ),
        /**
         * Created sale/refund id
         */
        'sale_auth'     => array(
            self::REQUIRED   => true,
            self::TYPE       => self::STRING,
            self::VALIDATION => array(self::STRING, self::MAXLENGHT_40)
        ),
        /**
         * Date of accounting/deregistering
         */
        'date'          => array(
            self::REQUIRED   => true,
            self::TYPE       => self::STRING,
            self::VALIDATION => array(self::STRING)
        ),
        /**
         * carry value of 1 if account has test mode, otherwise parameter not sent
         */
        self::TEST_MODE => array(
            self::REQUIRED   => false,
            self::TYPE       => self::STRING,
            self::VALIDATION => array(self::STRING, 'maxlength_1', 'minlength_1')
        ),
        /**
         * shortcut for client card number, eg ****5678
         */
        'card'          => array(
            self::REQUIRED   => true,
            self::TYPE       => self::STRING,
            self::VALIDATION => array(self::STRING, 'maxlength_8', 'minlength_8')
        ),
    );
    /**
     * List of supported fields for card direct payment request
     * @var array
     */
    private static $cardDirectPaymentRequestFields = array(
        /**
         * Transaction amount
         */
        self::AMOUNT     => array(
            self::REQUIRED   => true,
            self::VALIDATION => array(self::FLOAT),
        ),
        /**
         * Client name
         */
        'name'           => array(
            self::REQUIRED   => true,
            self::VALIDATION => array(self::STRING, self::MAXLENGHT_64),
        ),
        /**
         * Client email
         */
        self::EMAIL      => array(
            self::REQUIRED   => true,
            self::VALIDATION => array(self::STRING, self::EMAIL_LIST),
        ),
        /**
         * Sale description
         */
        'desc'           => array(
            self::REQUIRED   => true,
            self::VALIDATION => array(self::STRING, self::MAXLENGHT_128),
        ),
        /**
         * Value from partner system
         */
        self::ORDER_ID   => array(
            self::REQUIRED   => false,
            self::VALIDATION => array(self::STRING, self::MAXLENGHT_40),
        ),
        /**
         * 3ds return url enabled
         */
        'enable_pow_url' => array(
            self::REQUIRED   => false,
            self::VALIDATION => array(self::BOOLEAN),
        ),
        /**
         * 3ds success return url
         */
        'pow_url' => array(
            self::REQUIRED   => false,
            self::VALIDATION => array(self::STRING),
        ),
        /**
         * 3ds failure return url
         */
        'pow_url_blad' => array(
            self::REQUIRED   => false,
            self::VALIDATION => array(self::STRING),
        ),
        /**
         * language
         */
        'language'       => array(
            self::REQUIRED   => false,
            self::VALIDATION => array(self::STRING),
        ),
    );
    /**
     * List of fields available in card direct payment response
     * @var array
     */
    private static $cardDeregisterResponseFields = array(
        /**
         * client authorization ID, sent if onetimer option is not set
         * when creating client and client has not been deregistered (himself or by api)
         */
        'cli_auth'      => array(
            self::REQUIRED   => true,
            self::TYPE       => self::STRING,
            self::VALIDATION => array(self::STRING, self::MAXLENGTH_40, self::MINLENGTH_40),
        ),
        /**
         * carry value of 1 if account has test mode, otherwise parameter not sent
         */
        self::TEST_MODE => array(
            self::REQUIRED   => false,
            self::TYPE       => 'int',
            self::VALIDATION => array('int'),
        ),
        /**
         * Date of accounting/deregistering
         */
        'date'          => array(
            self::REQUIRED   => true,
            self::TYPE       => self::STRING,
            self::VALIDATION => array(self::STRING),
            self::FILTER     => 'date'
        ),
        /**
         * Message checksum
         */
        'sign'          => array(
            self::REQUIRED   => true,
            self::TYPE       => self::STRING,
            self::VALIDATION => array(self::STRING, 'maxlength_128', self::MINLENGTH_40),
        ),
    );
    /**
     * List of supported fields for szkwal payment request
     * @var array
     */
    private static $szkwalRequestFields = array(
        /**
         * User api login
         */
        'api_login'    => array(
            self::REQUIRED   => true,
            self::VALIDATION => array(self::STRING),
        ),
        /**
         * User api password
         */
        'api_password' => array(
            self::REQUIRED   => true,
            self::VALIDATION => array(self::STRING),
        ),
        /**
         * Client name
         */
        'cli_name'     => array(
            self::REQUIRED   => true,
            self::VALIDATION => array(self::STRING, 'maxlength_96'),
            self::FILTER     => 'name'
        ),
        /**
         * Client email
         */
        'cli_email'    => array(
            self::REQUIRED   => true,
            self::VALIDATION => array(self::STRING, 'maxlength_128'),
            self::FILTER     => 'mail'
        ),
        /**
         * Client phone
         */
        'cli_phone'    => array(
            self::REQUIRED   => true,
            self::VALIDATION => array(self::STRING, 'maxlength_32'),
            self::FILTER     => self::PHONE
        ),
        /**
         * Title the client will be paying with; according to agreed format;
         */
        'title'        => array(
            self::REQUIRED   => true,
            self::VALIDATION => array(self::STRING),
        ),
        /**
         * Optional field sent in notifications
         */
        'crc'          => array(
            self::REQUIRED   => true,
            self::VALIDATION => array(self::STRING, 'maxlength_64'),
            self::FILTER     => self::TEXT
        ),
        /**
         * Client account number
         */
        'cli_account'  => array(
            self::REQUIRED   => true,
            self::VALIDATION => array(self::STRING, 'minlenght_26', 'maxlength_26'),
            self::FILTER     => self::NUMBERS
        ),
        /**
         * Checksum
         */
        'hash'         => array(
            self::REQUIRED   => true,
            self::VALIDATION => array(self::STRING, self::MINLENGTH_40, self::MAXLENGTH_40),
            self::FILTER     => 'sign'
        ),
    );
    /**
     * List of fields available in szkwal payment response
     * @var array
     */
    private static $szkwalResponseFields = array(
        /**
         * Unique SZKWał payment ID
         */
        'pay_id'     => array(
            self::REQUIRED   => false,
            self::TYPE       => 'int',
            self::VALIDATION => array('uint'),
        ),
        /**
         * Unique SZKWał notification ID
         */
        'not_id'     => array(
            self::REQUIRED   => false,
            self::TYPE       => 'int',
            self::VALIDATION => array('uint'),
        ),
        /**
         * The title of payment in agreed format
         */
        'title'      => array(
            self::REQUIRED   => false,
            self::TYPE       => self::STRING,
            self::VALIDATION => array(self::STRING),
        ),
        /**
         * Additional client field
         */
        'crc'        => array(
            self::REQUIRED   => false,
            self::TYPE       => self::STRING,
            self::VALIDATION => array(self::STRING),
        ),
        /**
         * Transaction amount
         */
        self::AMOUNT => array(
            self::REQUIRED   => false,
            self::TYPE       => self::FLOAT,
            self::VALIDATION => array(self::FLOAT),
        ),
        /**
         * Message checksum
         */
        'hash'       => array(
            self::REQUIRED   => false,
            self::TYPE       => self::STRING,
            self::VALIDATION => array(self::STRING, self::MAXLENGTH_40, self::MINLENGTH_40),
        ),
    );
    /**
     * List of supported fields for white label payment request
     * @var array
     */
    private static $whiteLabelRequestFields = array(
        /**
         * User api login
         */
        'api_login'    => array(
            self::REQUIRED   => true,
            self::VALIDATION => array(self::STRING),
        ),
        /**
         * User api password
         */
        'api_password' => array(
            self::REQUIRED   => true,
            self::VALIDATION => array(self::STRING),
        ),
        /**
         * Client name
         */
        'cli_name'     => array(
            self::REQUIRED   => true,
            self::VALIDATION => array(self::STRING, 'maxlenght_96'),
            self::FILTER     => self::TEXT
        ),
        /**
         * Client email
         */
        'cli_email'    => array(
            self::REQUIRED   => true,
            self::VALIDATION => array(self::STRING, self::MAXLENGHT_128),
            self::FILTER     => 'mail'
        ),
        /**
         * Client phone
         */
        'cli_phone'    => array(
            self::REQUIRED   => true,
            self::VALIDATION => array(self::MAXLENGHT_32),
            self::FILTER     => self::PHONE
        ),
        /**
         * Order id (payment title) the customer will be paying with; according to agreed format;
         */
        'order'        => array(
            self::REQUIRED   => true,
            self::VALIDATION => array(self::STRING),
        ),
        /**
         * Transaction amount
         */
        self::AMOUNT   => array(
            self::REQUIRED   => true,
            self::VALIDATION => array(self::FLOAT),
        ),
        /**
         * Message checksum
         */
        'hash'         => array(
            self::REQUIRED   => true,
            self::VALIDATION => array(self::STRING, self::MAXLENGHT_40),
            self::FILTER     => 'sign'
        ),
    );


    /**
     * Check all variables required in response
     * Parse variables to valid types
     *
     * @param string $paymentType
     *
     * @return array
     * @throws TException
     */
    public static function getResponse($paymentType)
    {
        $ready = array();
        $missed = array();

        switch ($paymentType) {
            case static::PAYMENT_TYPE_BASIC:
            case static::PAYMENT_TYPE_EHAT:
                $responseFields = static::$panelPaymentResponseFields;
                break;
            case static::PAYMENT_TYPE_CARD:
                $responseFields = static::$cardPaymentResponseFields;
                break;
            case static::PAYMENT_TYPE_SZKWAL:
                $responseFields = static::$szkwalResponseFields;
                break;
            case static::CARD_DEREGISTER:
                $responseFields = static::$cardDeregisterResponseFields;
                break;
            default:
                throw new TException(sprintf(static::UNKNOWN_PAYMENT_TYPE_S, $paymentType));
        }

        foreach ($responseFields as $fieldName => $field) {
            if (Util::post($fieldName, static::STRING) === false) {
                if ($field[static::REQUIRED] === true) {
                    $missed[] = $fieldName;
                }
            } else {
                $val = Util::post($fieldName, static::STRING);
                switch ($field[static::TYPE]) {
                    case static::STRING:
                        $val = (string)$val;
                        break;
                    case 'int':
                        $val = (int)$val;
                        break;
                    case static::FLOAT:
                        $val = (float)$val;
                        break;
                    case static::ARR:
                        $val = (array)$val;
                        break;
                    default:
                        throw new TException(sprintf('unknown field type in getResponse - field name= %s', $fieldName));
                }
                $ready[$fieldName] = $val;
            }
        }

        if (count($missed) > 0) {
            throw new TException(sprintf('Missing fields in tpay response: %s', implode(',', $missed)));
        }

        foreach ($ready as $fieldName => $fieldVal) {
            static::validateOne($paymentType, $fieldName, $fieldVal, false);
        }

        return $ready;
    }

    /**
     * Check one field form
     *
     * @param string $paymentType payment type
     * @param string $name field name
     * @param mixed $value field value
     * @param bool $notResp is it not response value
     *
     * @return bool
     *
     * @throws TException
     */
    public static function validateOne($paymentType, $name, $value, $notResp = true)
    {
        switch ($paymentType) {
            case static::PAYMENT_TYPE_BASIC:
            case static::PAYMENT_TYPE_EHAT:
                $requestFields = $notResp ? static::$panelPaymentRequestFields : static::$panelPaymentResponseFields;
                break;
            case static::PAYMENT_TYPE_BASIC_API:
                $requestFields = static::$panelPaymentRequestFields;
                $requestFields[static::KANAL][static::REQUIRED] = true;
                break;
            case static::PAYMENT_TYPE_CARD:
                $requestFields = $notResp ? static::$cardPaymentRequestFields : static::$cardPaymentResponseFields;
                break;
            case static::PAYMENT_TYPE_CARD_DIRECT:
                $requestFields = static::$cardDirectPaymentRequestFields;
                break;
            case static::PAYMENT_TYPE_SZKWAL:
                $requestFields = $notResp ? static::$szkwalRequestFields : static::$szkwalResponseFields;
                break;
            case static::PAYMENT_TYPE_WHITE_LABEL:
                $requestFields = static::$whiteLabelRequestFields;
                break;
            case static::PAYMENT_TYPE_BLIK_T6STANDARD:
                $requestFields = static::$blikPaymentRequestFields;
                $requestFields['alias'][static::REQUIRED] = false;
                break;
            case static::PAYMENT_TYPE_BLIK_T6REGISTER:
                $requestFields = static::$blikPaymentRequestFields;
                break;
            case static::PAYMENT_TYPE_BLIK_ALIAS:
                $requestFields = static::$blikPaymentRequestFields;
                $requestFields['code'][static::REQUIRED] = false;
                break;
            case static::ALIAS_BLIK:
                $requestFields = static::$blikAliasResponseFields;
                break;
            default:
                throw new TException(sprintf(static::UNKNOWN_PAYMENT_TYPE_S, $paymentType));
        }
        $requestFields['json'][static::REQUIRED] = false;
        $requestFields['json'][self::VALIDATION] = array(self::BOOLEAN);
        if (!is_string($name)) {
            throw new TException('Invalid field name');
        }
        if (!array_key_exists($name, $requestFields)) {
            throw new TException('Field with this name is not supported ' . $name);
        }

        $fieldConfig = $requestFields[$name];

        if ($fieldConfig[static::REQUIRED] === false && ($value === '' || $value === false)) {
            return true;
        }

        if (isset($fieldConfig[static::VALIDATION]) === true) {

            foreach ($fieldConfig[static::VALIDATION] as $validator) {

                switch ($validator) {
                    case 'uint':
                        static::validateUint($value, $name);
                        break;
                    case static::FLOAT:
                        static::validateFloat($value, $name);
                        break;
                    case static::STRING:
                        static::validateString($value, $name);
                        break;
                    case static::BOOLEAN:
                        static::validateBoolean($value, $name);
                        break;
                    case static::OPIS_DODATKOWY:
                        static::validateDescription($value, $name);
                        break;
                    case static::EMAIL_LIST:
                        static::validateEmailList($value, $name);
                        break;
                    case static::OPTIONS:
                        static::validateOptions($value, $fieldConfig[static::OPTIONS], $name);
                        break;
                    case 'country_code':
                        static::validateCountryCode($value, $name);
                        break;
                    case static::ARR:
                        static::validateArray($value, $name);
                        break;
                    default:
                        break;
                }
                if (strpos($validator, 'maxlenght') === 0) {
                    $max = explode('_', $validator);
                    $max = (int)$max[1];
                    static::validateMaxLenght($value, $max, $name);
                }
                if (strpos($validator, 'minlength') === 0) {
                    $min = explode('_', $validator);
                    $min = (int)$min[1];
                    static::validateMinLength($value, $min, $name);
                }
            }
        }
        if (!static::filterValues($value, $fieldConfig)) {
            throw new TException(
                sprintf('Value of field "%s" contains illegal characters. Value: ' . $value, $name)
            );

        }

        return true;
    }

    /**
     * Check if variable is uint
     *
     * @param mixed $value variable to check
     * @param string $name field name
     *
     * @throws TException
     */
    private static function validateUint($value, $name)
    {
        if (!is_int($value)) {
            throw new TException(sprintf('Field "%s" must be an integer', $name));
        } else {
            if ($value <= 0) {
                throw new TException(sprintf('Field "%s" must be higher than zero', $name));
            }
        }
    }
    /**
     * Check if variable is array
     *
     * @param mixed $value variable to check
     * @param string $name field name
     *
     * @throws TException
     */
    private static function validateArray($value, $name)
    {
        if (!is_array($value)) {
            throw new TException(sprintf('Field "%s" must be an array', $name));
        } else {
            if (count($value) <= 0) {
                throw new TException(sprintf('Array "%s" must not be empty', $name));
            }
        }
    }
    /**
     * Check if variable is float
     *
     * @param mixed $value variable to check
     * @param string $name field name
     *
     * @throws TException
     */
    private static function validateFloat($value, $name)
    {
        if (!is_numeric($value) && !is_int($value)) {
            throw new TException(sprintf('Field "%s" must be a float|int number', $name));
        } else {
            if ($value < 0) {
                throw new TException(sprintf('Field "%s" must be higher than zero', $name));
            }
        }
    }

    /**
     * Check if variable is string
     *
     * @param mixed $value variable to check
     * @param string $name field name
     *
     * @throws TException
     */
    private static function validateString($value, $name)
    {
        if (!is_string($value)) {
            throw new TException(sprintf('Field "%s" must be a string, type given: ' . gettype($value), $name));
        }
    }

    /**
     * Check if variable is string
     *
     * @param mixed $value variable to check
     * @param string $name field name
     *
     * @throws TException
     */
    private static function validateBoolean($value, $name)
    {
        if (!is_bool($value)) {
            throw new TException(sprintf('Field "%s" must be a boolean', $name));
        }
    }

    /**
     * Check if variable is valid description
     *
     * @param mixed $value variable to check
     * @param string $name field name
     *
     * @throws TException
     */
    private static function validateDescription($value, $name)
    {
        if (preg_match('/[^a-zA-Z0-9 ]/', $value) !== 0) {
            throw new TException(
                sprintf('Field "%s" contains invalid characters. Only a-z A-Z 0-9 and space', $name)
            );
        }
    }

    /**
     * Check if variable is valid email list
     *
     * @param mixed $value variable to check
     * @param string $name field name
     *
     * @throws TException
     */
    private static function validateEmailList($value, $name)
    {
        if (!is_string($value)) {
            throw new TException(sprintf('Field "%s" must be a string', $name));
        }
        $emails = explode(',', $value);
        foreach ($emails as $email) {
            if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
                throw new TException(
                    sprintf('Field "%s" contains invalid email address', $name)
                );
            }
        }
    }

    /**
     * Check if variable has expected value
     *
     * @param mixed $value variable to check
     * @param array $options available options
     * @param string $name field name
     *
     * @throws TException
     */
    private static function validateOptions($value, $options, $name)
    {
        if (!in_array($value, $options, true)) {
            throw new TException(sprintf('Field "%s" has unsupported value', $name));
        }
    }

    /**
     * Check if variable is valid country code
     *
     * @param mixed $value variable to check
     * @param string $name field name
     *
     * @throws TException
     */
    private static function validateCountryCode($value, $name)
    {
        if (!is_string($value)
            || (strlen($value) !== 2 && strlen($value) !== 3)
            || (!in_array($value, static::$isoCountryCodes) && !isset(static::$isoCountryCodes[$value]))
        ) {
            throw new TException(
                sprintf('Field "%s" has invalid country code', $name)
            );
        }
    }

    /**
     * Check variable max lenght
     *
     * @param mixed $value variable to check
     * @param int $max max lenght
     * @param string $name field name
     *
     * @throws TException
     */
    private static function validateMaxLenght($value, $max, $name)
    {
        if (strlen($value) > $max) {
            throw new TException(
                sprintf('Value of field "%s" is too long. Max %d characters', $name, $max)
            );
        }
    }

    /**
     * Check variable min length
     *
     * @param mixed $value variable to check
     * @param int $min min length
     * @param string $name field name
     *
     * @throws TException
     */
    private static function validateMinLength($value, $min, $name)
    {
        if (strlen($value) < $min) {
            throw new TException(
                sprintf('Value of field "%s" is too short. Min %d characters', $name, $min)
            );
        }
    }

    /**
     * RegExp filter for fields validation
     * @param string $value
     * @param array $fieldConfig
     * @return bool
     * @throws TException
     */
    private static function filterValues($value, $fieldConfig)
    {
        $filters = array(
            static::PHONE   => '/[^0-9]\+ /',
            static::NUMBERS => '/[^0-9]/',
            'letters'       => '/[^A-Za-z]/',
            'mixed'         => '/[^A-Za-z0-9]/',
            'date'          => '/[^0-9 \-:]/',
            self::TEXT      => '/[^\-\p{Latin}A-Za-z0-9 \.,#_()\/\!]/u',
            'name'          => '/[^\-\p{Latin} ]/u',
            'sign'          => '/[^A-Za-z!\., _\-0-9]/'
        );

        if (isset($fieldConfig[static::FILTER])) {
            $filterName = $fieldConfig[static::FILTER];
            if ($fieldConfig[static::FILTER] === 'name') {
                $value = preg_replace('/[^a-z]/i','',$value);
            }
            if (array_key_exists($filterName, $filters)) {
                if ((bool)preg_match($filters[$filterName], $value)) {
                    return false;
                }
            } else {
                if ((($filterName === 'mail') && !filter_var($value, FILTER_VALIDATE_EMAIL))
                    ||
                    (($filterName === 'url') && !((preg_match('/http:/', $value)) || preg_match('/https:/', $value)))
                    ||
                    (($filterName === static::BOOLEAN) && !is_bool($value))
                ) {
                    return false;
                }
            }
        }
        return true;
    }

    /**
     * Validate merchant Id
     *
     * @param int $merchantId
     *
     * @throws TException
     */
    public static function validateMerchantId($merchantId)
    {
        if (!is_int($merchantId) || $merchantId <= 0) {
            throw new TException('Invalid merchantId');
        }
    }

    /**
     * Validate merchant secret
     *
     * @param string $merchantSecret
     *
     * @throws TException
     */
    public static function validateMerchantSecret($merchantSecret)
    {
        if (!is_string($merchantSecret) || strlen($merchantSecret) === 0) {
            throw new TException('Invalid secret code');
        }
    }

    /**
     * Validate Card Api Key
     *
     * @param string $cardApiKey
     *
     * @throws TException
     */
    public static function validateCardApiKey($cardApiKey)
    {
        if (!is_string($cardApiKey) || strlen($cardApiKey) === 0) {
            throw new TException('Invalid card API key');
        }
    }

    /**
     * Validate Card Api Password
     *
     * @param string $cardApiPassword
     *
     * @throws TException
     */
    public static function validateCardApiPassword($cardApiPassword)
    {
        if (!is_string($cardApiPassword) || strlen($cardApiPassword) === 0) {
            throw new TException('Invalid card API pass');
        }
    }

    /**
     * Validate card verification code
     *
     * @param string $cardCode
     *
     * @throws TException
     */
    public static function validateCardCode($cardCode)
    {
        if (!is_string($cardCode) || strlen($cardCode) === 0 || strlen($cardCode) > 40) {
            throw new TException('Invalid card code');
        }
    }

    /**
     * Validate card hash algorithm
     * @param string $hashAlg
     * @throws TException
     */
    public static function validateCardHashAlg($hashAlg)
    {
        if (!in_array($hashAlg, array('sha1', 'sha256', 'sha512', 'ripemd160', 'ripemd320', 'md5'))) {
            throw new TException('Invalid hash algorithm');
        }
    }

    /**
     * Validate card RSA key
     *
     * @param string $keyRSA
     *
     * @throws TException
     */
    public static function validateCardRSAKey($keyRSA)
    {
        if (!is_string($keyRSA) || strlen($keyRSA) === 0) {
            throw new TException('Invalid card RSA key');
        }
    }

    /**
     * Validate card currency code
     *
     * @param string $currency
     *
     * @throws TException
     * @return int
     */
    public static function validateCardCurrency($currency)
    {
        if (strlen($currency) !== 3) {
            throw new TException('Currency is invalid.');
        }

        switch (gettype($currency)) {
            case 'string':
                if (in_array($currency, static::$isoCurrencyCodes)) {
                    $currency = array_search($currency, static::$isoCurrencyCodes);
                } elseif (array_key_exists((int)$currency, static::$isoCurrencyCodes)) {
                    $currency = (int)$currency;
                } else {
                    throw new TException('Currency is not supported.');
                }

                break;
            case 'integer':
                if (!array_key_exists($currency, static::$isoCurrencyCodes)) {
                    throw new TException('Currency is not supported.');
                }
                break;
            default:
                throw new TException('Currency variable type not supported.');
        }
        return $currency;

    }

    /**
     * Validate card payment language
     *
     * @param string $language
     *
     * @throws TException
     * @return string
     */
    public static function validateCardLanguage($language)
    {
        if (!is_string($language)) {
            throw new TException('Invalid language value type.');
        }
        if (in_array($language, static::$cardPaymentLanguages)) {
            $language = array_search($language, static::$cardPaymentLanguages);
        } elseif (!array_key_exists($language, static::$cardPaymentLanguages)) {
            $language = 'en';
        }
        return $language;

    }

    /**
     * Validate payment config
     *
     * @param  string $paymentType
     * @param  array $config
     * @return array
     *
     * @throws TException
     */
    public static function validateConfig($paymentType, $config)
    {
        if (!is_array($config)) {
            throw new TException('Config is not an array');
        } else {
            if (count($config) === 0) {
                throw new TException('Config is empty');
            }
        }
        $ready = array();
        foreach ($config as $key => $value) {
            if (Validate::validateOne($paymentType, $key, $value) === true) {
                $ready[$key] = $value;
            }
        }
        Validate::isSetRequiredPaymentFields($paymentType, $ready);

        return $ready;
    }

    /**
     * Check if all required fields isset in config
     *
     * @param string $paymentType
     * @param array $config
     *
     * @throws TException
     */
    public static function isSetRequiredPaymentFields($paymentType, $config)
    {
        $missing = array();

        switch ($paymentType) {
            case static::PAYMENT_TYPE_BASIC:
            case static::PAYMENT_TYPE_EHAT:
                $requestFields = static::$panelPaymentRequestFields;
                break;
            case static::PAYMENT_TYPE_BASIC_API:
                $requestFields = static::$panelPaymentRequestFields;
                $requestFields[static::KANAL][static::REQUIRED] = true;
                break;
            case static::PAYMENT_TYPE_CARD:
                $requestFields = static::$cardPaymentRequestFields;
                break;
            case static::PAYMENT_TYPE_CARD_DIRECT:
                $requestFields = static::$cardDirectPaymentRequestFields;
                break;
            case static::PAYMENT_TYPE_SZKWAL:
                $requestFields = static::$szkwalRequestFields;
                break;
            case static::PAYMENT_TYPE_WHITE_LABEL:
                $requestFields = static::$whiteLabelRequestFields;
                break;
            case static::PAYMENT_TYPE_BLIK_T6STANDARD:
                $requestFields = static::$blikPaymentRequestFields;
                $requestFields['alias'][static::REQUIRED] = false;
                break;
            case static::PAYMENT_TYPE_BLIK_T6REGISTER:
                $requestFields = static::$blikPaymentRequestFields;
                break;
            case static::PAYMENT_TYPE_BLIK_ALIAS:
                $requestFields = static::$blikPaymentRequestFields;
                $requestFields['code'][static::REQUIRED] = false;
                break;
            case static::ALIAS_BLIK:
                $requestFields = static::$blikAliasResponseFields;
                break;
            default:
                throw new TException(sprintf(static::UNKNOWN_PAYMENT_TYPE_S, $paymentType));
        }

        foreach ($requestFields as $fieldName => $field) {
            if ($field[static::REQUIRED] === true && !isset($config[$fieldName])) {
                $missing[] = $fieldName;
            }
        }
        if (count($missing) !== 0) {
            throw new TException(sprintf('Missing mandatory fields: %s', implode(',', $missing)));
        }
    }
}
