<form id="transferuj-payment" class="transferuj-form" action="<?php echo $data['action_url'] ?>" method="POST">
    <?php foreach ($data['fields'] as $name => $value) { ?>
        <input <?php if ($name === 'kanal') {
            echo ' id="transferuj-channel-input" ';
        } else if ($name === 'akceptuje_regulamin') {
            echo ' id="transferuj-regulations-input" ';
        } ?> type="hidden"
             name="<?php echo $name ?>"
             value="<?php echo $value ?>">
        <?php
    }
    ?>
    <input id="transferuj-payment-submit" type="submit" value="<?php Transferuj\Lang::l('pay') ?>">
</form>
