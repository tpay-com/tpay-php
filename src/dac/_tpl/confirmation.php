<link rel="stylesheet" type="text/css" href="<?php echo $data['static_files_url'] ?>dac/_css/confirmation.css"/>

<div id="transferuj-dac-confirmation">
    <div class="transferuj-row transferuj-header"><?php Transferuj\Lang::l('transfer_details') ?></div>
    <div class="transferuj-row">
        <div class="col-l">
            <?php Transferuj\Lang::l('merchant_info') ?>:
        </div>
        <div class="col-r">
            <?php echo $data['merchant_data'] ?>
        </div>
    </div>
    <div class="transferuj-row">
        <div class="col-l">
            <?php Transferuj\Lang::l('payment_amount') ?>:
        </div>
        <div class="col-r">
            <?php echo $data['transaction']['amount'] ?>
        </div>
    </div>
    <div class="transferuj-row">
        <div class="col-l">
            <?php Transferuj\Lang::l('disposable_account') ?>:
        </div>
        <div class="col-r">
            <?php echo $data['transaction']['account_number'] ?>
        </div>
    </div>
</div>