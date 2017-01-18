<?php

if (isset($_GET['check_sms'])) {
    $transferuj = new Transferuj\PaymentSMS();
    $result = $transferuj->verifyCode();

    echo '<h1>sprawdzenie SMS</h1>';
    echo 'result: ' . (int)$result;
    die;
}

?>

<script type="text/javascript">tfHash = 'abdws';</script>
<script type="text/javascript" src="https://sms.transferuj.pl/widget/loader.js"></script>
