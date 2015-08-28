<form id="transferuj-payment" action="<?php echo $data['confirmation_url'] ?>" method="POST">
    <input type="hidden" name="sale_auth" value="<?php echo $data['sale_auth'] ?>">
    <input type="hidden" name="order_id" value="<?php echo $data['order_id'] ?>">
    <button class="transferuj" type="submit"><?php Transferuj\Lang::l('debit') ?></button>
</form>
