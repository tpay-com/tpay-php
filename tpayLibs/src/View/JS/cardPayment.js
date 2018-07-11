function CardPayment(url, pubkey) {


    this.url = url;
    this.pubkey = pubkey;

    $("#card_payment_form").attr("action", url);

    function SubmitPayment() {

        $("#card_continue_btn").fadeOut();
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

    var
        DINERS = /3(?:0[0-5]|[68][0-9])[0-9]{11}/,
        JCB = /^(?:2131|1800|35[0-9]{3})[0-9]{11}$/,
        MAESTRO = /^(50(18|20|38)|6304|67(59|6[1-3])|0604)$/,
        AMERICAN = /^(?:3[47][0-9]{13})$/,
        // DISCOVER = /^(?:6(?:011|5[0-9][0-9])[0-9]{12})$/,
        MASTERCARD = /^5[1-5]\d{14}$|^2(?:2(?:2[1-9]|[3-9]\d)|[3-6]\d\d|7(?:[01]\d|20))\d{12}$/,
        VISA = /^40([0-1]|2[0-5]|2[7-9]|[3-9])|41([0-6]|7[0-4])|41(75(0[1-9]|[1-9])|7[6-9]|[8-9])|4[2-4]|450[0-7]|4509|45[1-9]|4[6-7]|48[0-3]|484[0-3]|484[5-9]|48[5-9]|490|491[0-2]|491[4-6]|491[8-9]|49[2-9]/;
    var goon = false;

    $('input#card_number').formance('format_credit_card_number').on('keyup change blur', function (event) {
        $('div.card_icon').removeClass('hover');
        goon = false;
        var cc_number = $(this).val().replace(/\s/g, ''),
            supported = ['master', 'visa'],
            type = getCreditCardType(cc_number);
        if (supported.indexOf(type) > -1 && cc_number.length > 11) {
            $(this).removeClass('wrong');
            $('#info_msg').css('visibility', 'hidden');
            goon = true;
        } else if (cc_number.length < 12) {
            goon = false;
            $(this).addClass('wrong');
            $('#info_msg').css('visibility', 'hidden');
        } else {
            $('#info_msg').css('visibility', 'visible');
            goon = false;
            $(this).addClass('wrong');
        }
        if (type !== '') {
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

    function getCreditCardType(cc_number) {
        var type = '';
        if (MASTERCARD.exec(cc_number)) {
            type = 'master';
        } else if (JCB.exec(cc_number)) {
            type = 'jcb';
        } else if (DINERS.exec(cc_number)) {
            type = 'diners';
        } else if (MAESTRO.exec(cc_number)) {
            type = 'maestro';
        } else if (AMERICAN.exec(cc_number)) {
            type = 'amex';
        } else if (VISA.exec(cc_number)) {
            type = 'visa';
        }

        return type;
    }

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

    $('#card_continue_btn').click(function () {
        $('input').each(function () {
            $(this).trigger('keyup');
        });
        if (document.getElementById("cc_month"))
            $('select#cc_month,select#cc_year').trigger('keyup');
        if (goon)
            SubmitPayment();
    });

}
