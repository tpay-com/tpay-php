<script type="text/javascript">
    function redirect() {
        document.getElementById('tpay-payment').submit();
    }
</script>
<link rel="stylesheet" type="text/css" href="<?php echo $data['static_files_url'] ?>View/Styles/style.css"/>
<body <?php if ($data['redirect']) {
    echo 'onload="redirect()"';
} ?>>
<form id="tpay-payment" class="tpay-form" action="<?php echo $data['action_url'] ?>" method="POST"
      accept-charset="UTF-8">
    <?php foreach ($data['fields'] as $name => $value) { ?>
        <input <?php if ($name === 'group') {
            echo ' id="tpay-channel-input" ';
        }
        if ($name === 'accept_tos') {
            echo ' id="tpay-regulations-input" ';
        } ?> type="hidden"
             name="<?php echo $name ?>"
             value="<?php echo $value ?>">
        <?php
    }
    ?>
    <?php if ($data['show_regulations_checkbox'] === true) { ?>
        <div class="tpay-amPmCheckbox">
            <input id="tpay-accept-regulations-checkbox" type="checkbox" name="regulations" value="0">
            <label for="tpay-accept-regulations-checkbox" class="tpay-info-label">
                <?php $lang->l('accept') ?> <a href="<?php echo $data['regulation_url'] ?>"
                                               target="_blank" rel="noopener noreferrer"><?php $lang->l('regulations_url') ?></a>
                <?php $lang->l('regulations'); ?>
            </label>
        </div>
    <?php } ?>
    <div class="tpay-buttons-holder">
        <input class="tpay-pay-button" id="tpay-payment-submit" type="submit" value="<?php $lang->l('pay') ?>">
    </div>
</form>
</body>

<script type="text/javascript">
    var regulation_checkbox = document.getElementById('tpay-accept-regulations-checkbox'),
        submit_form_input = document.getElementById('tpay-payment-submit'),
        regulations_form_input = document.getElementById('tpay-regulations-input');
    <?php if ($data['show_regulations_checkbox'] === true){ ?>
    submit_form_input.onclick = function () {
        if (regulations_form_input.value == 0) {
            alert('<?php $lang->l('acceptance_is_required') ?>');
            return false;
        }
        return true;
    };
    regulation_checkbox.onchange = function () {
        regulations_form_input.value = (this.checked) ? 1 : 0;
    };
    <?php } ?>
</script>
