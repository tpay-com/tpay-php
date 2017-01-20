<?php

/*
 * Created by tpay.com
 */

if ($data['show_regulations_checkbox'] === true) { ?>
    <input id="tpay-accept-regulations-checkbox" type="checkbox" value="0">
    <label for="tpay-accept-regulations-checkbox">
        <?php tpay\Lang::l('accept') ?> <a href="<?php echo $data['regulation_url'] ?>"
                                                 target="_blank"><?php tpay\Lang::l('regulations') ?></a>
    </label>
<?php } ?>
<select name="bank_list" id="tpay-bank-list" onchange="changeBank()"></select>
<?php echo $data['form'] ?>
<script>
    var s = document.createElement('script'),
        submit_form_input = document.getElementById('tpay-payment-submit'),
        regulations_form_input = document.getElementById('tpay-regulations-input'),
        regulation_checkbox = document.getElementById('tpay-accept-regulations-checkbox'),
        changeBank = function () {
            document.getElementById('tpay-channel-input').value = document.getElementById('tpay-bank-list').value;
        };
    s.src = 'https://secure.tpay.com/channels-<?php echo $data['merchant_id'] ?>1.js';
    s.onload = function () {
        var str = '', i;
        for (i in tr_channels) {
            var channel = tr_channels[i],
                id = channel[0],
                name = channel[1];
            str += '<option value="' + id + '" >' + name + '</option>';
        }
        document.getElementById('tpay-bank-list').innerHTML = str;
        changeBank();
    };
    document.getElementsByTagName('head')[0].appendChild(s);

    <?php if ($data['show_regulations_checkbox'] === true){ ?>

    submit_form_input.onclick = function () {
        if (regulations_form_input.value == 0) {
            alert('<?php tpay\Lang::l('acceptance_is_required') ?>');
            return false;
        }
        return true;
    };

    regulation_checkbox.onchange = function () {
        regulations_form_input.value = (this.checked) ? 1 : 0;
    };

    <?php } ?>

</script>
