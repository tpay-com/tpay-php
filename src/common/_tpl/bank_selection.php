<style>
    #bank-selection-form { overflow: hidden }
    .bank-block.bank-active {  box-shadow: 0 0 10px 3px #15428F }
    .bank-block label input { display: none }
    .bank-block {
        width: 150px;
        height: 70px;
        float: left;
        position: relative;
        border: 1px solid #B2B2B2;
        margin: 6px;
        background-size: contain;
        background-position: center center;
        background-repeat: no-repeat;
        background-color: #FFF;
    }
    .bank-block label {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        cursor: pointer;
    }
</style>

<div id="bank-selection-form"></div>

<?php if ($data['show_regulations_checkbox'] === true){ ?>
    <input id="transferuj-accept-regulations-checkbox" type="checkbox" value="0">
    <label for="transferuj-accept-regulations-checkbox">
        <?php Transferuj\Lang::l('accept') ?> <a href="<?php echo $data['regulation_url'] ?>" target="_blank"><?php Transferuj\Lang::l('regulations') ?></a>
    </label>
<?php } ?>

<?php echo $data['form'] ?>

<script>
    var s = document.createElement('script'),
        regulation_checkbox = document.getElementById('transferuj-accept-regulations-checkbox'),
        submit_form_input = document.getElementById('transferuj-payment-submit'),
        regulations_form_input = document.getElementById('transferuj-regulations-input'),
        bank_selection_form = document.getElementById('bank-selection-form'),
        changeBank = function (bank_id) {
            var input = document.getElementById('transferuj-channel-input'),
                bank_block = document.getElementById('bank-' + bank_id),
                active_bank_blocks = document.getElementsByClassName('bank-active'),
                class_name = 'bank-active', cn;

            input.value = bank_id;

            if (active_bank_blocks.length > 0) {
                cn = active_bank_blocks[0].className;
                cn = cn.replace(new RegExp("\\s?\\b" + class_name + "\\b", "g"), '');
                active_bank_blocks[0].className = cn;
            }

            if (bank_block !== null) {
                bank_block.className = bank_block.className + ' bank-active';
            }
        };
    s.src = 'https://secure.transferuj.pl/channels-<?php echo $data['merchant_id'] ?>1.js';
    s.onload = function () {
        var str = '', first = true, i;
        for (i in tr_channels) {
            var channel = tr_channels[i],
                id = channel[0],
                width_style = (channel[0] == 40) ? 'width:270px' : '',
                checked, class_name;

            if (first) {
                checked = ' checked';
                class_name = ' bank-active';
                first = false;
                changeBank(id);
            } else {
                checked = '';
                class_name = ''
            }
            str += '<div class="bank-block' + class_name + '" id="bank-' + id + '" style="background-image:url(' + channel[3] + ');' + width_style + '"><label onclick="changeBank(' + id + ')"><input type="radio" name="bank-select" value="' + id + '" ' + checked + '/></label></div>';
        }
        bank_selection_form.innerHTML = str;
    };
    document.getElementsByTagName('head')[0].appendChild(s);

    <?php if ($data['show_regulations_checkbox'] === true){ ?>

    submit_form_input.onclick =  function(){
        if (regulations_form_input.value == 0){
            alert('<?php Transferuj\Lang::l('acceptance_is_required') ?>');
            return false;
        }
        return true;
    };

    regulation_checkbox.onchange = function(){
        regulations_form_input.value = (this.checked) ? 1 : 0;
    };

    <?php } ?>
</script>