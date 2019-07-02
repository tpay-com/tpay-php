<?php

/*
 * Created by tpay.com.
 * Date: 13.06.2017
 * Time: 14:26
 */

namespace tpayLibs\src\_class_tpay\PaymentForms;

use tpayLibs\src\_class_tpay\PaymentOptions\BasicPaymentOptions;
use tpayLibs\src\_class_tpay\Utilities\Util;

class PaymentBasicForms extends BasicPaymentOptions
{
    const ACTION_URL = 'action_url';
    /**
     * @var string
     */
    const FIELDS = 'fields';
    /**
     * @var string
     */
    const PAYMENT_FORM = 'paymentForm';

    const TPAY_TERMS_OF_SERVICE_URL = 'https://secure.tpay.com/regulamin.pdf';

    protected $panelURL = 'https://secure.tpay.com';

    /**
     * Create HTML form for basic panel payment based on transaction config
     * More information about config fields @see FieldsConfigValidator::$panelPaymentRequestFields
     *
     * @param array $config transaction config
     *
     * @param bool $redirect redirect automatically
     * @param bool $showRegulations show the Tpay regulations and the acceptance checkbox
     * @return string
     */
    public function getTransactionForm($config, $redirect = false, $showRegulations = false)
    {
        $config = $this->prepareConfig($config);

        $data = array(
            static::ACTION_URL => $this->panelURL,
            static::FIELDS => $config,
            'redirect' => $redirect,
            'show_regulations_checkbox' => $showRegulations,
            'regulation_url' => static::TPAY_TERMS_OF_SERVICE_URL,
        );

        return Util::parseTemplate(static::PAYMENT_FORM, $data);
    }

    /**
     * Create HTML form for payment with blik selection based on transaction config
     * More information about config fields @see FieldsConfigValidator::$blikPaymentRequestFields
     * @param string $formActionUrl the form will be submitted to this url
     * @return string
     * @internal param string $alias alias of registered user for One Click transactions
     */
    public function getBlikSelectionForm($formActionUrl)
    {
        $data = array(
            'regulation_url' => static::TPAY_TERMS_OF_SERVICE_URL,
            'action_url' => $formActionUrl,
        );

        return Util::parseTemplate('blikForm', $data);
    }

    /**
     * Create HTML form for payment with bank selection based on transaction config
     * More information about config fields @see FieldsConfigValidator::$panelPaymentRequestFields
     *
     * @param array $config transaction config
     * @param bool $smallList type of bank selection list big icons or small form with select
     * @param bool $showRegulations show accept regulations input
     * @param string $actionURL sets non default action URL of form
     * @param bool $onlineOnly show only banks booking online
     * @return string
     */
    public function getBankSelectionForm(
        $config = array(),
        $smallList = false,
        $showRegulations = true,
        $actionURL = null,
        $onlineOnly = false
    )
    {
        if (!empty($config)) {
            $config = $this->prepareConfig($config);
        }
        $config['group'] = 0;
        $config['accept_tos'] = 0;

        $data = array(
            static::ACTION_URL => is_null($actionURL) ? $this->panelURL : (string)$actionURL,
            static::FIELDS => $config,
            'redirect' => false,
            'show_regulations_checkbox' => $showRegulations,
            'regulation_url'  => static::TPAY_TERMS_OF_SERVICE_URL,
        );

        $form = Util::parseTemplate(static::PAYMENT_FORM, $data);

        $data = array(
            'merchant_id' => $this->merchantId,
            'form' => $form,
            'online_only' => (int)$onlineOnly,
            'small_list' => $smallList,
        );

        return Util::parseTemplate('bankSelection', $data);
    }

    /**
     * Returns the bank choice form without any payment buttons. Useful for gathering bank choice information.
     * @param bool $onlineOnly show only banks booking online
     * @param bool $showRegulations show Tpay terms and conditions checkbox
     * @return string
     */
    public function getSimpleBankList($onlineOnly = false, $showRegulations = true)
    {
        $data = [
            'merchant_id' => $this->merchantId,
            'online_only' => (int)$onlineOnly,
            'show_regulations_checkbox' => $showRegulations,
            'regulation_url' => static::TPAY_TERMS_OF_SERVICE_URL,
        ];

        return Util::parseTemplate('bankSelectionSimple', $data);
    }

}
