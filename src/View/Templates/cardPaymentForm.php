<form id="tpay-payment" class="tpay-form" action="<?php
echo $data['action_url'] ?>" method="POST">
    <input type="hidden" name="sale_auth" value="<?php echo $data['sale_auth'] ?>"/>
    <input id="tpay-payment-submit" type="submit" value="<?php $lang->l('pay') ?>">
</form>
