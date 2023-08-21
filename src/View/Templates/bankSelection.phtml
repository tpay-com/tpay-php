<link rel="stylesheet" type="text/css" href="<?php echo $data['static_files_url'] ?>View/Styles/style.css"/>
<div class="tpay-insidebg" id="main-payment">
    <div class="tpay-header-wrapper">
        <div class="tpay-header-logo">
            <img class="tpay-logo" src="https://tpay.com/img/banners/tpay_logo_white.svg"/>
        </div>
        <div class="tpay-header-belt"></div>
    </div>
    <div id="groups_v" class="tpay-panel-inside-content">
        <div id="bank-selection-form" class="tpay-groups-wrapper">
            <?php if ($data['small_list'] === true) { ?>
                <select name="bank_list" id="tpay-bank-list" onchange="changeOption()" class="tpay-select"></select>
            <?php } ?>
        </div>
        <?php if (isset($data['form'])) {echo $data['form'];} ?>
    </div>
</div>

<script>
    var s = document.createElement('script'),
        bank_selection_form = document.getElementById('bank-selection-form'),
        changeBank = function (bank_id) {
            var input = document.getElementById('tpay-channel-input'),
                bank_block = document.getElementById('bank-' + bank_id),
                active_bank_blocks = document.getElementsByClassName('tpay-active');

            input.value = bank_id;

            if (active_bank_blocks.length > 0) {
                active_bank_blocks[0].className = active_bank_blocks[0].className.replace('tpay-active', '');
            }
            if (bank_block !== null) {
                bank_block.className = bank_block.className + ' tpay-active';
            }
        },
        changeOption = function () {
            document.getElementById('tpay-channel-input').value = document.getElementById('tpay-bank-list').value;
        };
    s.src = 'https://secure.tpay.com/groups-<?php echo $data['merchant_id'].$data['online_only'] ?>.js';
    s.onload = function () {
        var str = '',
            i,
            str2 = '',
            tile,
            others = [157, 106, 109, 148, 104],
            group,
            id,
            groupName,
            logoSrc;
        <?php if ($data['small_list'] === false) { ?>
        for (i in tr_groups) {
            group = tr_groups[i];
            id = group[0];
            groupName = group[1];
            logoSrc = group[3];

            tile = getBankTile(id, groupName, logoSrc);
            if (inArray(id, others) === false) {
                str += tile;
            } else {
                str2 += tile;
            }
        }
        bank_selection_form.innerHTML = str + str2;
        <?php } else { ?>
        for (i in tr_groups) {
            group = tr_groups[i];
            id = group[0];
            groupName = group[1];
            str += getBankOption(id, groupName);
        }
        document.getElementById('tpay-bank-list').innerHTML = str;
        <?php } ?>
    };

    function getBankTile(groupId, groupName, logoSrc) {
        return '<div class="tpay-group-holder tpay-with-logo" id="bank-' + groupId + '" onclick="changeBank(' + groupId + ')">' +
            '<div class="tpay-group-name">' + groupName + '</div>' +
            '<div class="tpay-group-logo-holder">' +
            '<img src="' + logoSrc + '" class="tpay-group-logo" alt="' + groupName + '">' +
            '</div></div></div>';
    }

    function getBankOption(groupId, groupName) {
        return '<option value="' + groupId + '" >' + groupName + '</option>';
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
