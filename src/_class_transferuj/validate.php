<?php
namespace Transferuj;

/**
 * Class Fields
 *
 * Include methods responsible for receiving and validating input data
 *
 * @package Transferuj
 */
class Validate
{
    const
        PAYMENT_TYPE_BASIC = 'basic',
        PAYMENT_TYPE_BASIC_API = 'basic_api',
        PAYMENT_TYPE_CARD = 'card',
        PAYMENT_TYPE_CARD_DIRECT = 'card_direct',
        PAYMENT_TYPE_SZKWAL = 'szkwal',
        PAYMENT_TYPE_WHITE_LABEL = 'whiteLabel',
        PAYMENT_TYPE_EHAT = 'ehat',
        PAYMENT_TYPE_SMS = 'sms',
        CARD_DEREGISTER = 'deregister';


    /**
     * RegExp filter for fields validation
     * @var array
     */
    private static $filters = array(
        'numbers' => '/[^0-9]/',
        'letters' => '/[^A-Za-z]/',
        'mixed'   => '/[^A-Za-z0-9]/',
        'date'    => '/[^0-9 \-:]/',
        'text'    => '/[^\-\p{Latin}A-Za-z0-9 \.,_]/u',
        'url'     => '_^(?:(?:https?|ftp)://)(?:\S+(?::\S*)?@)?(?:(?!10(?:\.\d{1,3}){3})(?!127(?:\.\d{1,3}){3})(?!169\.254(?:\.\d{1,3}){2})(?!192\.168(?:\.\d{1,3}){2})(?!172\.(?:1[6-9]|2\d|3[0-1])(?:\.\d{1,3}){2})(?:[1-9]\d?|1\d\d|2[01]\d|22[0-3])(?:\.(?:1?\d{1,2}|2[0-4]\d|25[0-5])){2}(?:\.(?:[1-9]\d?|1\d\d|2[0-4]\d|25[0-4]))|(?:(?:[a-z\x{00a1}-\x{ffff}0-9]+-?)*[a-z\x{00a1}-\x{ffff}0-9]+)(?:\.(?:[a-z\x{00a1}-\x{ffff}0-9]+-?)*[a-z\x{00a1}-\x{ffff}0-9]+)*(?:\.(?:[a-z\x{00a1}-\x{ffff}]{2,})))(?::\d{2,5})?(?:/[^\s]*)?$_iuS',
        'mail'    => '/^[a-zA-Z0-9\.\-_\+]+\@[a-zA-Z0-9]+[a-zA-Z0-9\.\-_]*\.[a-z]{2,4}$/D',
        'name'    => '/[^\-\p{Latin} ]/u',
        'sign'    => '/[^A-Za-z!\., _\-0-9]/'
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
     * List of supported request fields for basic payment
     * @var array
     */
    private static $panelPaymentRequestFields = array(

        /**
         * Transaction amount with dot as decimal separator.
         */
        'kwota'               => array(
            'required'   => true,
            'validation' => array('float'),
        ),
        /**
         * Transaction description
         */
        'opis'                => array(
            'required'   => true,
            'validation' => array('string', 'maxlenght_128'),
            'filter'     => 'text'
        ),
        /**
         * The secondary parameter to the transaction identification.
         * After the transaction returned as a parameter tr_crc.
         */
        'crc'                 => array(
            'required'   => false,
            'validation' => array('string', 'maxlenght_128'),
            'filter'     => 'sign'
        ),
        /**
         * Allow only online payment.
         * Prevents the channel selection, which at the moment is not able to post real-time payment.
         */
        'online'              => array(
            'required'   => false,
            'validation' => array('options'),
            'options'    => array(0, 1),
        ),
        /**
         * Imposing the customer the pre-payment channel.
         * Could be changed manually by customer.
         * Required for register transaction by transaction API
         */
        'kanal'               => array(
            'required'   => false,
            'validation' => array('uint'),
        ),
        /**
         * Blocking the channel selection of payment - only works together with the parameter channel.
         * Customer will be presented only the selected channel.
         */
        'zablokuj'            => array(
            'required'   => false,
            'validation' => array('options'),
            'options'    => array(0, 1),
        ),
        /**
         * The resulting URL return address that will send the result of a transaction in the form POST parameters.
         */
        'wyn_url'             => array(
            'required'   => false,
            'validation' => array('string', 'maxlenght_512'),
            'filter'     => 'url'
        ),
        /**
         * E-mail address to which you will be notified about the status of the transaction.
         */
        'wyn_email'           => array(
            'required'   => false,
            'validation' => array('email_list'),
        ),
        /**
         * Description payees during the transaction.
         */
        'opis_sprzed'         => array(
            'required'   => false,
            'validation' => array('string', 'maxlenght_128'),
            'filter'     => 'text'
        ),
        /**
         * Optional field used during card transactions processed through Elavon.
         * The value of the field is passed to Elavon as „TEKST REF. TRANSAKCJI”.
         * Acceptable characters are a-z, AZ (without Polish), 0-9 and space.
         * All others will be removed.
         * Max 32 signs.
         */
        'opis_dodatkowy'      => array(
            'required'   => false,
            'validation' => array('opis_dodatkowy', 'maxlenght_32'),
            'filter'     => 'mixed'
        ),
        /**
         * The URL to which the customer will be transferred after successful completion of the transaction.
         */
        'pow_url'             => array(
            'required'   => false,
            'validation' => array('string', 'maxlenght_512'),
            'filter'     => 'url'
        ),
        /**
         * The URL to which the client will be transferred in the event of an error.
         * Default is pow_url
         */
        'pow_url_blad'        => array(
            'required'   => false,
            'validation' => array('string', 'maxlenght_512'),
            'filter'     => 'url'
        ),
        /**
         * Transactional panel language.
         * Default is PL
         */
        'jezyk'               => array(
            'required'   => false,
            'validation' => array('options'),
            'options'    => array('PL', 'EN', 'DE', 'IT', 'ES', 'FR', 'RU'),
        ),
        /**
         * Customer email address.
         */
        'email'               => array(
            'required'   => false,
            'validation' => array('string', 'maxlenght_64'),
            'filter'     => 'mail'
        ),
        /**
         * Customer surname.
         */
        'nazwisko'            => array(
            'required'   => false,
            'validation' => array('string', 'maxlenght_64'),
            'filter'     => 'name'
        ),
        /**
         * Customer name.
         */
        'imie'                => array(
            'required'   => false,
            'validation' => array('string', 'maxlenght_64'),
            'filter'     => 'name'
        ),
        /**
         * Customer address.
         */
        'adres'               => array(
            'required'   => false,
            'validation' => array('string', 'maxlenght_64'),
            'filter'     => 'text'
        ),
        /**
         * Customer city.
         */
        'miasto'              => array(
            'required'   => false,
            'validation' => array('string', 'maxlenght_32'),
            'filter'     => 'name'
        ),
        /**
         * Customer postal code.
         */
        'kod'                 => array(
            'required'   => false,
            'validation' => array('string', 'maxlenght_10'),
            'filter'     => 'text'
        ),
        /**
         * Country code.
         * Alphanumeric, 2 or 3 signs compatible with ISO 3166-1
         */
        'kraj'                => array(
            'required'   => false,
            'validation' => array('country_code'),
        ),
        /**
         * Customer phone.
         */
        'telefon'             => array(
            'required'   => false,
            'validation' => array('string', 'maxlenght_16'),
            'filter'     => 'numbers'
        ),
        /**
         * The parameter indicating acceptance of Terms Transferuj if it is available on the payee.
         */
        'akceptuje_regulamin' => array(
            'required'   => false,
            'validation' => array('options'),
            'options'    => array(0, 1),
        ),
    );

    /**
     * List of fields available in response for basic payment
     * @var array
     */
    private static $panelPaymentResponseFields = array(
        /**
         * The transaction ID assigned by the system Transferuj
         */
        'tr_id'     => array(
            'required'   => true,
            'type'       => 'string',
            'validation' => array('string'),
        ),
        /**
         * Date of transaction.
         */
        'tr_date'   => array(
            'required'   => true,
            'type'       => 'string',
            'validation' => array('string'),

        ),
        /**
         * The secondary parameter to the transaction identification.
         */
        'tr_crc'    => array(
            'required'   => true,
            'type'       => 'string',
            'validation' => array('string'),
        ),
        /**
         * Transaction amount.
         */
        'tr_amount' => array(
            'required'   => true,
            'type'       => 'float',
            'validation' => array('float'),
        ),
        /**
         * The amount paid for the transaction.
         * Note: Depending on the settings, the amount paid can be different than transactions eg. When the customer does overpayment.
         */
        'tr_paid'   => array(
            'required'   => true,
            'type'       => 'float',
            'validation' => array('float'),
        ),
        /**
         * Description of the transaction.
         */
        'tr_desc'   => array(
            'required'   => true,
            'type'       => 'string',
            'validation' => array('string'),
        ),
        /**
         * Transaction status: TRUE in the case of the correct result or FALSE in the case of an error.
         * Note: Depending on the settings, the transaction may be correct status, even if the amount paid is different from the amount of the transaction!
         * Eg. If the Seller accepts the overpayment or underpayment threshold is set.
         */
        'tr_status' => array(
            'required'   => true,
            'type'       => 'string',
            'validation' => array('options'),
            'options'    => array(0, 1, true, false, 'TRUE', 'FALSE'),
        ),
        /**
         * Transaction error status.
         * Could have the following values:
         * - none
         * - overpay
         * - surcharge
         */
        'tr_error'  => array(
            'required'   => true,
            'type'       => 'string',
            'validation' => array('options'),
            'options'    => array('none', 'overpay', 'surcharge'),
        ),
        /**
         * Customer email address.
         */
        'tr_email'  => array(
            'required'   => true,
            'type'       => 'string',
            'validation' => array('email_list'),
        ),
        /**
         * The checksum verifies the data sent to the payee.
         * It is built according to the following scheme using the MD5 hash function:
         * MD5(id + tr_id + tr_amount + tr_crc + security code)
         */
        'md5sum'    => array(
            'required'   => true,
            'type'       => 'string',
            'validation' => array('string', 'maxlength_32', 'minlength_32'),
        ),
        /**
         * Transaction marker indicates whether the transaction was executed in test mode:
         * 1 – in test mode
         * 0 – in normal mode
         */
        'test_mode' => array(
            'required'   => false,
            'type'       => 'int',
            'validation' => array('options'),
            'options'    => array(0, 1),
        ),
        /**
         * The parameter is sent only when you use a payment channel or MasterPass or V.me.
         * Could have the following values: „masterpass” or „vme”
         */
        'wallet'    => array(
            'required' => false,
            'type'     => 'string',
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
        'amount'   => array(
            'required'   => true,
            'validation' => array('float'),
        ),
        /**
         * Client name
         */
        'name'     => array(
            'required'   => true,
            'validation' => array('string', 'maxlenght_64'),
        ),
        /**
         * Client email
         */
        'email'    => array(
            'required'   => true,
            'validation' => array('string', 'email_list'),
        ),
        /**
         * Sale description
         */
        'desc'     => array(
            'required'   => true,
            'validation' => array('string', 'maxlenght_128'),
        ),
        /**
         * Value from partner system
         */
        'order_id' => array(
            'required'   => true,
            'validation' => array('string', 'maxlenght_40'),
        ),
        /**
         * Value from partner system
         */
        'currency' => array(
            'required'   => true,
            'validation' => array('options'),
            'options'    => array('985', '826', '840', '978', '203'),
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
        'type'      => array(
            'required'   => true,
            'type'       => 'string',
            'validation' => array('options'),
            'options'    => array('sale', 'refund', 'deregister'),
        ),
        /**
         * Merchant optional value
         */
        'order_id'  => array(
            'required'   => true,
            'type'       => 'string',
            'validation' => array('string', 'maxlenght_40')
        ),
        /**
         * Payment status
         */
        'status'    => array(
            'required'   => true,
            'type'       => 'string',
            'validation' => array('options'),
            'options'    => array('correct', 'declined'),
        ),
        /**
         * Message checksum
         */
        'sign'      => array(
            'required'   => true,
            'type'       => 'string',
            'validation' => array('string', 'maxlenght_128', 'minlength_40')
        ),
        /**
         * Created sale/refund id
         */
        'sale_auth' => array(
            'required'   => true,
            'type'       => 'string',
            'validation' => array('string', 'maxlenght_40')
        ),
        /**
         * Date of accounting/deregistering
         */
        'date'      => array(
            'required'   => true,
            'type'       => 'string',
            'validation' => array('string')
        ),
        /**
         * carry value of 1 if account has test mode, otherwise parameter not sent
         */
        'test_mode' => array(
            'required'   => false,
            'type'       => 'string',
            'validation' => array('string', 'maxlength_1', 'minlength_1')
        ),
        /**
         * shortcut for client card number, eg ****5678
         */
        'card'      => array(
            'required'   => true,
            'type'       => 'string',
            'validation' => array('string', 'maxlength_8', 'minlength_8')
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
        'amount'   => array(
            'required'   => true,
            'validation' => array('float'),
        ),
        /**
         * Client name
         */
        'name'     => array(
            'required'   => true,
            'validation' => array('string', 'maxlenght_64'),
        ),
        /**
         * Client email
         */
        'email'    => array(
            'required'   => true,
            'validation' => array('string', 'email_list'),
        ),
        /**
         * Sale description
         */
        'desc'     => array(
            'required'   => true,
            'validation' => array('string', 'maxlenght_128'),
        ),
        /**
         * Value from partner system
         */
        'order_id' => array(
            'required'   => false,
            'validation' => array('string', 'maxlenght_40'),
        ),
    );

    /**
     * List of fields available in card direct payment response
     * @var array
     */
    private static $cardDeregisterResponseFields = array(
        /**
         * client authorization ID, sent if onetimer option is not set when creating client and client has not been deregistered (himself or by api)
         */
        'cli_auth'  => array(
            'required'   => true,
            'type'       => 'string',
            'validation' => array('string', 'maxlength_40', 'minlength_40'),
        ),
        /**
         * carry value of 1 if account has test mode, otherwise parameter not sent
         */
        'test_mode' => array(
            'required'   => false,
            'type'       => 'int',
            'validation' => array('int'),
        ),
        /**
         * Date of accounting/deregistering
         */
        'date'      => array(
            'required'   => true,
            'type'       => 'string',
            'validation' => array('string'),
            'filter'     => 'date'
        ),
        /**
         * Message checksum
         */
        'sign'      => array(
            'required'   => true,
            'type'       => 'string',
            'validation' => array('string', 'maxlength_128', 'minlength_40'),
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
            'required'   => true,
            'validation' => array('string'),
        ),
        /**
         * User api password
         */
        'api_password' => array(
            'required'   => true,
            'validation' => array('string'),
        ),
        /**
         * Client name
         */
        'cli_name'     => array(
            'required'   => true,
            'validation' => array('string', 'maxlength_96'),
            'filter'     => 'name'
        ),
        /**
         * Client email
         */
        'cli_email'    => array(
            'required'   => true,
            'validation' => array('string', 'maxlength_128'),
            'filter'     => 'mail'
        ),
        /**
         * Client phone
         */
        'cli_phone'    => array(
            'required'   => true,
            'validation' => array('string', 'maxlength_32'),
            'filter'     => 'numbers'
        ),
        /**
         * Title the client will be paying with; according to agreed format;
         */
        'title'        => array(
            'required'   => true,
            'validation' => array('string'),
        ),
        /**
         * Optional field sent in notifications
         */
        'crc'          => array(
            'required'   => true,
            'validation' => array('string', 'maxlength_64'),
            'filter'     => 'text'
        ),
        /**
         * Client account number
         */
        'cli_account'  => array(
            'required'   => true,
            'validation' => array('string', 'minlenght_26', 'maxlength_26'),
            'filter'     => 'numbers'
        ),
        /**
         * Checksum
         */
        'hash'         => array(
            'required'   => true,
            'validation' => array('string', 'minlength_40', 'maxlength_40'),
            'filter'     => 'sign'
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
        'pay_id' => array(
            'required'   => false,
            'type'       => 'int',
            'validation' => array('uint'),
        ),
        /**
         * Unique SZKWał notification ID
         */
        'not_id' => array(
            'required'   => false,
            'type'       => 'int',
            'validation' => array('uint'),
        ),
        /**
         * The title of payment in agreed format
         */
        'title'  => array(
            'required'   => false,
            'type'       => 'string',
            'validation' => array('string'),
        ),
        /**
         * Additional client field
         */
        'crc'    => array(
            'required'   => false,
            'type'       => 'string',
            'validation' => array('string'),
        ),
        /**
         * Transaction amount
         */
        'amount' => array(
            'required'   => false,
            'type'       => 'float',
            'validation' => array('float'),
        ),
        /**
         * Message checksum
         */
        'hash'   => array(
            'required'   => false,
            'type'       => 'string',
            'validation' => array('string', 'maxlength_40', 'minlength_40'),
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
            'required'   => true,
            'validation' => array('string'),
        ),
        /**
         * User api password
         */
        'api_password' => array(
            'required'   => true,
            'validation' => array('string'),
        ),
        /**
         * Client name
         */
        'cli_name'     => array(
            'required'   => true,
            'validation' => array('string', 'maxlenght_96'),
            'filter'     => 'text'
        ),
        /**
         * Client email
         */
        'cli_email'    => array(
            'required'   => true,
            'validation' => array('string', 'maxlenght_128'),
            'filter'     => 'mail'
        ),
        /**
         * Client phone
         */
        'cli_phone'    => array(
            'required'   => true,
            'validation' => array('maxlenght_32'),
            'filter'     => 'numbers'
        ),
        /**
         * Order id (payment title) the customer will be paying with; according to agreed format;
         */
        'order'        => array(
            'required'   => true,
            'validation' => array('string'),
        ),
        /**
         * Transaction amount
         */
        'amount'       => array(
            'required'   => true,
            'validation' => array('float'),
        ),
        /**
         * Message checksum
         */
        'hash'         => array(
            'required'   => true,
            'validation' => array('string', 'maxlenght_40'),
            'filter'     => 'sign'
        ),
    );

    /**
     * Check if all required fields isset in config
     *
     * @param string $paymentType
     * @param array $config
     *
     * @return bool
     * @throws TException
     */
    public static function checkRequiredPaymentFields($paymentType, $config)
    {
        $missing = array();

        switch ($paymentType) {
            case self::PAYMENT_TYPE_BASIC:
            case self::PAYMENT_TYPE_EHAT:
                $requestFields = self::$panelPaymentRequestFields;
                break;
            case self::PAYMENT_TYPE_BASIC_API:
                $requestFields = self::$panelPaymentRequestFields;
                $requestFields['kanal']['required'] = true;
                break;
            case self::PAYMENT_TYPE_CARD:
                $requestFields = self::$cardPaymentRequestFields;
                break;
            case self::PAYMENT_TYPE_CARD_DIRECT:
                $requestFields = self::$cardDirectPaymentRequestFields;
                break;
            case self::PAYMENT_TYPE_SZKWAL:
                $requestFields = self::$szkwalRequestFields;
                break;
            case self::PAYMENT_TYPE_WHITE_LABEL:
                $requestFields = self::$whiteLabelRequestFields;
                break;
            default:
                throw new TException(sprintf('Unknown payment type: %s', $paymentType));
        }

        foreach ($requestFields as $fieldName => $field) {
            if ($field['required'] === true && !isset($config[$fieldName])) {
                $missing[] = $fieldName;
            }
        }
        if (sizeof($missing) !== 0) {
            throw new TException(sprintf('Missing mandatory fields: %s', join(',', $missing)));
        }
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
            case self::PAYMENT_TYPE_BASIC:
            case self::PAYMENT_TYPE_EHAT:
                $requestFields = $notResp ? self::$panelPaymentRequestFields : self::$panelPaymentResponseFields;
                break;
            case self::PAYMENT_TYPE_BASIC_API:
                $requestFields = self::$panelPaymentRequestFields;
                $requestFields['kanal']['required'] = true;
                break;
            case self::PAYMENT_TYPE_CARD:
                $requestFields = $notResp ? self::$cardPaymentRequestFields : self::$cardPaymentResponseFields;
                break;
            case self::PAYMENT_TYPE_CARD_DIRECT:
                $requestFields = self::$cardDirectPaymentRequestFields;
                break;
            case self::PAYMENT_TYPE_SZKWAL:
                $requestFields = $notResp ? self::$szkwalRequestFields : self::$szkwalResponseFields;
                break;
            case self::PAYMENT_TYPE_WHITE_LABEL:
                $requestFields = self::$whiteLabelRequestFields;
                break;
            default:
                throw new TException(sprintf('Unknown payment type: %s', $paymentType));
        }

        if (!is_string($name)) {
            throw new TException('Invalid field name');
        }
        if (!array_key_exists($name, $requestFields)) {
            throw new TException('Field with this name is not supported');
        }

        $fieldConfig = $requestFields[$name];

        if ($fieldConfig['required'] === false && ($value === '' || $value === false)) {
            return true;
        }

        if (isset($fieldConfig['validation']) === true) {

            foreach ($fieldConfig['validation'] as $validator) {

                switch ($validator) {
                    case 'uint':
                        self::validateUint($value, $name);
                        break;
                    case 'float':
                        self::validateFloat($value, $name);
                        break;
                    case 'string':
                        self::validateString($value, $name);
                        break;
                    case 'opis_dodatkowy':
                        self::validateDescription($value, $name);
                        break;
                    case 'email_list':
                        self::validateEmailList($value, $name);
                        break;
                    case 'options':
                        self::validateOptions($value, $fieldConfig['options'], $name);
                        break;
                    case 'country_code':
                        self::validateCountryCode($value, $name);
                        break;
                }
                if (strpos($validator, 'maxlenght') === 0) {
                    $max = explode('_', $validator);
                    $max = (int)$max[1];
                    self::validateMaxLenght($value, $max, $name);
                }
                if (strpos($validator, 'minlength') === 0) {
                    $min = explode('_', $validator);
                    $min = (int)$min[1];
                    self::validateMinLength($value, $min, $name);
                }
            }
        }

        if (isset($fieldConfig['filter'])) {
            $filterName = $fieldConfig['filter'];

            $negationFileter = in_array($filterName, array('mail', 'url'));

            if (!$negationFileter && (bool)preg_match(self::$filters[$filterName], $value)) {
                throw new TException(
                    sprintf('Value of field "%s" contains illegal characters', $name)
                );
            } elseif ($negationFileter && !(bool)preg_match(self::$filters[$filterName], $value)) {
                throw new TException(
                    sprintf('Value of field "%s" contains illegal characters', $name)
                );
            }
        }

        return true;
    }

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
            case self::PAYMENT_TYPE_BASIC:
            case self::PAYMENT_TYPE_EHAT:
                $responseFields = self::$panelPaymentResponseFields;
                break;
            case self::PAYMENT_TYPE_CARD:
                $responseFields = self::$cardPaymentResponseFields;
                break;
            case self::PAYMENT_TYPE_SZKWAL:
                $responseFields = self::$szkwalResponseFields;
                break;
            case self::CARD_DEREGISTER:
                $responseFields = self::$cardDeregisterResponseFields;
                break;
            default:
                throw new TException(sprintf('Unknown payment type: %s', $paymentType));
        }

        foreach ($responseFields as $fieldName => $field) {
            if (Util::post($fieldName, 'string') === false) {
                if ($field['required'] === true) {
                    $missed[] = $fieldName;
                }
            } else {
                $val = Util::post($fieldName, 'string');
                switch ($field['type']) {
                    case 'string':
                        $val = (string)$val;
                        break;
                    case 'int':
                        $val = (int)$val;
                        break;
                    case 'float':
                        $val = (float)$val;
                        break;
                    default:
                        throw new TException(sprintf('unknown field type in getResponse - field name= %s', $fieldName));
                }
                $ready[$fieldName] = $val;
            }
        }

        if (sizeof($missed) > 0) {
            throw new TException(sprintf('Missing fields in transferuj response: %s', join(',', $missed)));
        }

        foreach ($ready as $fieldName => $fieldVal) {
            self::validateOne($paymentType, $fieldName, $fieldVal, false);
        }

        return $ready;
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
            if ($value < 0) {
                throw new TException(sprintf('Field "%s" must be higher than zero', $name));
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
        if (!is_float($value) && !is_int($value)) {
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
            throw new TException(sprintf('Field "%s" must be a string', $name));
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
            throw new TException(sprintf('Field "%s" has unsupperted value', $name));
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
        if (!is_string($value) || (strlen($value) !== 2 && strlen($value) !== 3) || (!in_array($value, self::$isoCountryCodes) && !isset(self::$isoCountryCodes[$value]))) {
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
     */
    public static function validateCardCurrency($currency)
    {
        if (!is_int($currency) && strlen($currency) != 3) {
            throw new TException('Currency is invalid.');
        }
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
            if (sizeof($config) === 0) {
                throw new TException('Config is empty');
            }
        }
        $ready = array();
        foreach ($config as $key => $value) {
            if (Validate::validateOne($paymentType, $key, $value) === true) {
                $ready[$key] = $value;
            }
        }
        Validate::checkRequiredPaymentFields($paymentType, $ready);

        return $ready;
    }
}
