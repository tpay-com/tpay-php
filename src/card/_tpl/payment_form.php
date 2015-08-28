<form id="transferuj-payment" class="transferuj-form" action="<?php echo $data['action_url'] ?>" method="POST">
    <input type="hidden" name="sale_auth" value="<?php echo $data['sale_auth'] ?>"/>
    <input type="hidden" name="id" value="<?php echo $data['merchant_id'] ?>"/>
    <input id="transferuj-payment-submit" type="submit" value="<?php Transferuj\Lang::l('pay') ?>">
</form>