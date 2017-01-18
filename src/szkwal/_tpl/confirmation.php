<link rel="stylesheet" type="text/css" href="<?php echo $data['static_files_url'] ?>szkwal/_css/confirmation.css"/>

<div id="transferuj-szkwal-confirmation">
    <div class="transferuj-row">
        <?php Transferuj\Lang::l('payment_method') ?>:
    </div>
    <div class="transferuj-row">
        <select id="transferuj-bank-select">
            <?php foreach ($data['banks'] as $b) { ?>
                <option value="<?php echo $b['account_number'] ?>"><?php echo $b['fullname'] ?></option>
            <?php } ?>
        </select>
    </div>
    <div class="transferuj-row">
        <div class="col-l"><?php Transferuj\Lang::l('merchant_info') ?></div>
        <div class="col-r"><?php echo $data['merchant_data'] ?></div>
    </div>
    <div class="transferuj-row">
        <div class="col-l"><?php Transferuj\Lang::l('account_number') ?></div>
        <div id="transferuj-bank-account" class="col-r"></div>
    </div>
    <div class="transferuj-row">
        <div class="col-l"><?php Transferuj\Lang::l('payment_title') ?></div>
        <div class="col-r client-title"><?php echo $data['title'] ?></div>
    </div>
    <?php if ($data['amount'] !== false) { ?>
        <div class="transferuj-row">
            <div class="col-l"><?php Transferuj\Lang::l('amount') ?></div>
            <div class="col-r"><?php echo $data['amount']
                ?>
            </div>
        </div>
        <?php
    }
    ?>
    <div>
        <?php Transferuj\Lang::l('szkwal_info') ?>
    </div>
</div>

<script type="text/javascript" src="<?php echo $data['static_files_url'] ?>szkwal/_js/confirmation.js"></script>
