<?php

/*
 * Created by tpay.com.
 * Date: 13.06.2017
 * Time: 14:26
 */

namespace tpayLibs\src\_class_tpay\PaymentForms;

use tpayLibs\src\_class_tpay\PaymentOptions\BasicPaymentOptions;
use tpayLibs\src\_class_tpay\Utilities\TException;
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

    protected $panelURL = 'https://secure.tpay.com';

    /**
     * URL to tpay regulations file
     * @var string
     */
    private $regulationURL = 'https://secure.tpay.com/regulamin.pdf';

    /**
     * Create HTML form for basic panel payment based on transaction config
     * More information about config fields @see FieldsConfigValidator::$panelPaymentRequestFields
     *
     * @param array $config transaction config
     *
     * @param bool $redirect redirect automatically
     * @return string
     */
    public function getTransactionForm($config, $redirect = false)
    {
        $config = $this->prepareConfig($config);

        $data = array(
            static::ACTION_URL => $this->panelURL,
            static::FIELDS     => $config,
            'redirect'         => $redirect,
        );

        return Util::parseTemplate(static::PAYMENT_FORM, $data);
    }

    /**
     * Create HTML form for payment with blik selection based on transaction config
     * More information about config fields @see FieldsConfigValidator::$blikPaymentRequestFields
     * @return string
     * @internal param string $alias alias of registered user for One Click transactions
     *
     */
    public function getBlikSelectionForm()
    {
        $data = array(
            'regulation_url' => $this->regulationURL,
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
     * @return string
     */
    public function getBankSelectionForm($config = array(), $smallList = false, $showRegulations = true,
        $actionURL = null)
    {
        if (!empty($config)) {
            $config = $this->prepareConfig($config);
        }
        $config['group'] = 0;
        $config['accept_tos'] = ($showRegulations) ? 0 : 1;

        $data = array(
            static::ACTION_URL => is_null($actionURL) ? $this->panelURL : (string)$actionURL,
            static::FIELDS     => $config,
            'redirect'         => false,
        );

        $form = Util::parseTemplate(static::PAYMENT_FORM, $data);

        $data = array(
            'merchant_id'               => $this->merchantId,
            'regulation_url'            => $this->regulationURL,
            'show_regulations_checkbox' => $showRegulations,
            'form'                      => $form
        );
        if ($smallList) {
            $templateFile = 'bankSelectionList';
        } else {
            $templateFile = 'bankSelection';
        }
        return Util::parseTemplate($templateFile, $data);
    }
}
