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
     * Path to template directory
     * @var string
     */
    private $templateDir = 'common/_tpl/';
    /**
     * URL to tpay regulations file
     * @var string
     */
    private $regulationURL = 'https://secure.tpay.com/regulamin.pdf';

    /**
     * Create HTML form for EHat payment based on transaction config
     * More information about config fields @see FieldsConfigValidator::$panelPaymentRequestFields
     *
     * @param array $config transaction config
     *
     * @return string
     */
    public function getEHatForm($config)
    {
        $config = $this->prepareConfig($config);

        $config['kanal'] = 58;
        $config['akceptuje_regulamin'] = 1;

        $data = array(
            static::ACTION_URL => $this->panelURL,
            static::FIELDS     => $config,
        );

        return Util::parseTemplate($this->templateDir . static::PAYMENT_FORM, $data);
    }

    /**
     * Create HTML form for basic panel payment based on transaction config
     * More information about config fields @see FieldsConfigValidator::$panelPaymentRequestFields
     *
     * @param array $config transaction config
     *
     * @return string
     */
    public function getTransactionForm($config)
    {
        $config = $this->prepareConfig($config);

        $data = array(
            static::ACTION_URL => $this->panelURL,
            static::FIELDS     => $config,
        );

        return Util::parseTemplate($this->templateDir . static::PAYMENT_FORM, $data);
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

        return Util::parseTemplate($this->templateDir . 'blikForm', $data);
    }

    /**
     * Create HTML form for payment with bank selection based on transaction config
     * More information about config fields @see FieldsConfigValidator::$panelPaymentRequestFields
     *
     * @param array $config transaction config
     * @param bool $smallList type of bank selection list big icons or small form with select
     * @param bool $showRegulations show accept regulations input
     *
     * @return string
     *
     * @throws TException
     */
    public function getBankSelectionForm($config, $smallList = false, $showRegulations = true)
    {
        $config = $this->prepareConfig($config);
        $config['kanal'] = 0;
        $config['akceptuje_regulamin'] = ($showRegulations) ? 0 : 1;

        $data = array(
            static::ACTION_URL => $this->panelURL,
            static::FIELDS     => $config,
        );

        $form = Util::parseTemplate($this->templateDir . static::PAYMENT_FORM, $data);

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
        return Util::parseTemplate($this->templateDir . $templateFile, $data);
    }
}
