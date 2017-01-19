function CardPayment(url, pubkey) {


    this.url = url;
    this.pubkey = pubkey;

    $("#card_payment_form").attr("action", url);

    function SubmitPayment() {

        $("#continue_btn").fadeOut();
        $("#loading_scr").fadeIn();

        var cd = $('#card_number').val() + '|' + $('#expiry_date').val() + '|' + $('#cvc').val() + '|' + document.location.origin;
        var encrypt = new JSEncrypt();
        var decoded = Base64.decode(pubkey);
        encrypt.setPublicKey(decoded);
        var encrypted = encrypt.encrypt(cd);

        $("#carddata").val(encrypted);
        $("#card_number").val('');
        $("#cvc").val('');
        $("#expiry_date").val('');

        $('#card_payment_form').submit();
    }

    var DINERS = /^(30|36|38)/,
        ELECTRON = /^(4026|417500|4508|4844|4913|4917)/,
        JCB = /^35(2[8-9]|[3-8])/,
        MAESTRO = /^(50(18|20|38)|6304|67(59|6[1-3])|0604)/,
        MASTERCARD = /^5[1-5]/,
        VISA = /^40([0-1]|2[0-5]|2[7-9]|[3-9])|41([0-6]|7[0-4])|41(75(0[1-9]|[1-9])|7[6-9]|[8-9])|4[2-4]|450[0-7]|4509|45[1-9]|4[6-7]|48[0-3]|484[0-3]|484[5-9]|48[5-9]|490|491[0-2]|491[4-6]|491[8-9]|49[2-9]/;
    var goon = false;

    $('input#card_number').formance('format_credit_card_number').on('keyup change blur', function (event) {
        $('div.card_icon').removeClass('hover');
        if (!$(this).formance('validate_credit_card_number')) {
            $(this).addClass('wrong');
            goon = false;
        } else {
            $(this).removeClass('wrong');
            goon = true;
            var type = '';
            var cc_number = $(this).val();
            if (DINERS.test(cc_number)) {
                type = 'diners';
            } else if (ELECTRON.test(cc_number) || (VISA.test(cc_number))){
                type = 'visa';
            } else if (JCB.test(cc_number)) {
                type = 'jcb';
            } else if (MAESTRO.test(cc_number)) {
                type = 'maestro';
            } else if (MASTERCARD.test(cc_number)) {
                type = 'master';
            }
            if (type !== '')
                $('#' + type).addClass('hover');

        }
    });
    $('input#cvc').formance('format_credit_card_cvc').on('keyup change blur', function (event) {
        if (!$(this).formance('validate_credit_card_cvc')) {
            $(this).addClass('wrong');
            goon = false;
        } else
            $(this).removeClass('wrong');
    });

    function validationExpired(mm, yy) {
        var today = new Date();
        var expiry = new Date();
        var expired = false, mm = Math.floor(parseFloat(mm)), yy = Math.floor(parseFloat(yy)) + (Math.floor(today.getFullYear() / 100) * 100);
        if (!isNaN(mm) && !isNaN(yy)) {
            expiry.setYear(mm === 12 ? yy + 1 : yy);
            expiry.setMonth(mm === 12 ? 0 : mm);
            expiry.setDate(1);
            expiry.setHours(0);
            expiry.setMinutes(0);
            expiry.setSeconds(0);
            expiry.setMilliseconds(0);
            expired = !(expiry.getTime() > today.getTime());
        }
        return expired;
    }

    $('select#cc_month,select#cc_year').on('keyup change blur', function (event) {
        mm = $('#cc_month option:selected').val();
        yy = $('#cc_year option:selected').val();
        if (validationExpired(mm, yy)) {
            $('select#cc_month,select#cc_year').addClass('wrong');
            goon = false;
        } else
            $('select#cc_month,select#cc_year').removeClass('wrong');
    });

    $('input#expiry_date').formance('format_credit_card_expiry').on('keyup change blur', function (event) {
        if (!$(this).formance('validate_credit_card_expiry')) {
            $(this).addClass('wrong');
            goon = false;
        } else
            $(this).removeClass('wrong');
    });
    $('input#c_name').on('keyup change blur', function (event) {
        if ($(this).val().length < 3) {
            $(this).addClass('wrong');
            goon = false;
        } else
            $(this).removeClass('wrong');
    });
    $('input#c_email').on('keyup change blur', function (event) {
        if (!$(this).formance('validate_email')) {
            $(this).addClass('wrong');
            goon = false;
        } else
            $(this).removeClass('wrong');
    });

    $('#continue_btn').click(function () {
        $('input').each(function () {
            $(this).trigger('keyup');
        });
        if (document.getElementById("cc_month"))
            $('select#cc_month,select#cc_year').trigger('keyup');
        if (goon)
            SubmitPayment();
    });

}

