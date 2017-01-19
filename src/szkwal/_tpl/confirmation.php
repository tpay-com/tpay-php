<?php ?>
<link rel="stylesheet" type="text/css" href="<?php echo $data['static_files_url'] ?>szkwal/_css/confirmation.css"/>

<div id="tpay-szkwal-confirmation">
    <div class="tpay-row">
        <?php tpay\Lang::l('payment_method') ?>:
    </div>
    <div class="tpay-row">
        <select id="tpay-bank-select">
            <?php foreach ($data['banks'] as $b) { ?>
                <option value="<?php echo $b['account_number'] ?>"><?php echo $b['fullname'] ?></option>
            <?php } ?>
        </select>
    </div>
    <div class="tpay-row">
        <div class="col-l"><?php tpay\Lang::l('merchant_info') ?></div>
        <div class="col-r"><?php echo $data['merchant_data'] ?></div>
    </div>
    <div class="tpay-row">
        <div class="col-l"><?php tpay\Lang::l('account_number') ?></div>
        <div id="tpay-bank-account" class="col-r"></div>
    </div>
    <div class="tpay-row">
        <div class="col-l"><?php tpay\Lang::l('payment_title') ?></div>
        <div class="col-r client-title"><?php echo $data['title'] ?></div>
    </div>
    <?php if ($data['amount'] !== false) { ?>
        <div class="tpay-row">
            <div class="col-l"><?php tpay\Lang::l('amount') ?></div>
            <div class="col-r"><?php echo $data['amount']
                ?>
            </div>
        </div>
        <?php
    }
    ?>
    <div>
        <?php tpay\Lang::l('szkwal_info') ?>
    </div>
</div>

<script type="text/javascript" src="<?php echo $data['static_files_url'] ?>szkwal/_js/confirmation.js"></script>
