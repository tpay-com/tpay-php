<?php
const STATIC_FILES_URL = 'static_files_url';
const CARD_SAVE_ALLOWED = 'card_save_allowed';
?>

<form method="post" id="card_payment_form" name="card_payment_form"
      class="tpay-groups-wrapper">
    <input type="hidden" name="carddata" id="carddata" value=""/>
    <input type="hidden" name="card_vendor" id="card_vendor" value=""/>
    <div class="tpay-channel-form-wrapper tpay-content-wrapper-class">
        <div id="card_payment" class="tpay-input-wrapper">
            <div class="tpay-col">
                <div class="tpay-row">
                    <div class="tpay-input-wrapper">
                        <div class="tpay-input-credit-card-number">
                            <div class="tpay-input-label"><?php $lang->l('card_number') ?></div>
                            <input id="card_number"
                                   pattern="\d*"
                                   autocompletetype="cc-number"
                                   size="30"
                                   type="tel"
                                   autocomplete="off"
                                   maxlength="23"
                                   placeholder="XXXX XXXX XXXX XXXX"
                                   tabindex="1"
                                   value=""
                                   class="tpay-input-value"
                            />
                            <div class="tpay-card-icon "></div>
                        </div>
                    </div>

                    <?php if ($data['showPayerFields']) { ?>
                        <div class="tpay-input-wrapper">
                            <div class="tpay-input-label"><?php $lang->l('name_on_card') ?></div>
                            <input type="text"
                                   id="c_name"
                                   placeholder="<?php $lang->l('name_surname') ?>"
                                   autocomplete="off"
                                   name="client_name"
                                   maxlength="64"
                                   tabindex="4"
                                   value=""
                                   class="tpay-input-value"
                            />
                        </div>
                    <?php } ?>
                </div>
            </div>
            <div class="tpay-col">
                <div class="tpay-row">
                    <div class="tpay-expiration-date-input tpay-input-wrapper">
                        <div class="tpay-input-label"><?php $lang->l('expiration_date') ?></div>
                        <input id="expiry_date"
                               maxlength="9"
                               type="tel"
                               placeholder="01 / 2020"
                               autocomplete="off"
                               autocompletetype="cc-exp"
                               tabindex="2"
                               value=""
                               class="tpay-input-value"
                        />
                    </div>
                    <div class="tpay-cvv-input tpay-input-wrapper">
                        <div class="tpay-input-label tpay-input-cvc" title="<?php $lang->l('signature') ?>">CVC</div>
                        <input id="cvc"
                               maxlength="4"
                               type="tel"
                               autocomplete="off"
                               autocompletetype="cc-cvc"
                               placeholder="XXX"
                               tabindex="3"
                               value=""
                               class="tpay-input-value"
                        />
                    </div>
                    <?php if ($data['showPayerFields']) { ?>
                        <div class="tpay-input-wrapper">
                            <div class="tpay-input-label">E-mail</div>
                            <input type="text"
                                   id="c_email"
                                   data-formance_algorithm="complex"
                                   autocomplete="off"
                                   placeholder="E-mail"
                                   name="client_email"
                                   value=""
                                   maxlength="64"
                                   tabindex="5"
                                   class="tpay-input-value"
                            />
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
    <?php if ($data[CARD_SAVE_ALLOWED]) { ?>
        <div class="tpay-amPmCheckbox">
            <input type="checkbox" id="card_save" name="card_save"/>
            <label for="card_save"
                   class="tpay-info-label"
                   title="<?php $lang->l('save_card_info') ?>"><?php $lang->l('save_card') ?>
            </label>
        </div>
    <?php } ?>
    <p id="info_msg_not_supported" style="display: none"><?php $lang->l('not_supported_card') ?></p>
    <p id="info_msg_not_valid" style="display: none"><?php $lang->l('not_valid_card') ?></p>
</form>

<script type="text/javascript" src="<?php echo $data[STATIC_FILES_URL] ?>View/JS/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo $data[STATIC_FILES_URL] ?>View/JS/jquery.formance.min.js"></script>
<script type="text/javascript" src="<?php echo $data[STATIC_FILES_URL] ?>View/JS/jsencrypt.min.js"></script>
<script type="text/javascript" src="<?php echo $data[STATIC_FILES_URL] ?>View/JS/string_routines.js"></script>
<script type="text/javascript" src="<?php echo $data[STATIC_FILES_URL] ?>View/JS/jquery.payment.js"></script>
<script type="text/javascript" src="<?php echo $data[STATIC_FILES_URL] ?>View/JS/cardPayment.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        new CardPayment('<?php echo $data['payment_redirect_path'] ?>', "<?php echo $data['rsa_key'] ?>");
    });
</script>
