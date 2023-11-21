<link rel="stylesheet" type="text/css" href="<?php echo $data['static_files_url'] ?>View/Styles/style.css"/>
<div class="tpay-insidebg" id="main-payment">
    <div id="groups_v" class="tpay-panel-inside-content">
        <div id="bank-selection-form" class="tpay-groups-wrapper"></div>
        <input type="hidden" name="tpay-selected-group" id="tpay-selected-group">
        <?php if ($data['show_regulations_checkbox'] === true) { ?>
            <div class="tpay-amPmCheckbox">
                <input id="tpay-accept-tos-checkbox" type="checkbox" name="tpay-tos" value="0">
                <label for="tpay-accept-tos-checkbox" class="tpay-info-label">
                    <?php $lang->l('accept') ?> <a href="<?php echo $data['regulation_url'] ?>"
                                                   target="_blank" rel="noreferrer noopener"><?php $lang->l('regulations_url') ?></a>
                    <?php $lang->l('regulations'); ?>
                </label>
            </div>
        <?php } ?>
    </div>
</div>

<script>
    var s = document.createElement('script'),
        bank_selection_form = document.getElementById('bank-selection-form'),
        changeBank = function (bank_id) {
            var input = document.getElementById('tpay-selected-group'),
                bank_block = document.getElementById('bank-' + bank_id),
                active_bank_blocks = document.getElementsByClassName('tpay-active');

            input.value = bank_id;

            if (active_bank_blocks.length > 0) {
                active_bank_blocks[0].className = active_bank_blocks[0].className.replace('tpay-active', '');
            }
            if (bank_block !== null) {
                bank_block.className = bank_block.className + ' tpay-active';
            }
        };
    s.src = 'https://secure.tpay.com/groups-<?php echo $data['merchant_id'].$data['online_only'] ?>.js';
    s.onload = function () {
        var str = '',
            i,
            str2 = '',
            temp,
            others = [157, 106, 109, 148, 104],
            group,
            id,
            groupName,
            logoSrc;

        for (i in tr_groups) {
            group = tr_groups[i];
            id = group[0];
            groupName = group[1];
            logoSrc = group[3];

            temp = getBankTile(id, groupName, logoSrc);
            if (inArray(id, others) === false) {
                str += temp;
            } else {
                str2 += temp;
            }
        }
        bank_selection_form.innerHTML = str + str2;
    };

    if (document.getElementById('tpay-accept-tos-checkbox')) {
        var regulation_checkbox = document.getElementById('tpay-accept-tos-checkbox');
        regulation_checkbox.onchange = function () {
            regulation_checkbox.value = (this.checked) ? 1 : 0;
        };
    }

    function getBankTile(groupId, groupName, logoSrc) {
        return '<div class="tpay-group-holder tpay-with-logo" id="bank-' + groupId + '" onclick="changeBank(' + groupId + ')">' +
            '<div class="tpay-group-name">' + groupName + '</div>' +
            '<div class="tpay-group-logo-holder">' +
            '<img src="' + logoSrc + '" class="tpay-group-logo" alt="' + groupName + '">' +
            '</div></div></div>';
    }

    function inArray(needle, haystack) {
        var length = haystack.length;
        for (var i = 0; i < length; i++) {
            if (haystack[i] == needle) return true;
        }
        return false;
    }

    document.getElementsByTagName('head')[0].appendChild(s);
</script>
