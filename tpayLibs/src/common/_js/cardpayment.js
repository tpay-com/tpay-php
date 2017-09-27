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

    var
        DINERS = /3(?:0[0-5]|[68][0-9])[0-9]{11}/,
        JCB = /^(?:2131|1800|35[0-9]{3})[0-9]{11}$/,
        MAESTRO = /^(50(18|20|38)|6304|67(59|6[1-3])|0604)$/,
        AMERICAN = /^(?:3[47][0-9]{13})$/,
        // DISCOVER = /^(?:6(?:011|5[0-9][0-9])[0-9]{12})$/,
        MASTERCARD = /^(?:5[1-5][0-9]{14})$/,
        VISA = /^(?:4[0-9]{12}(?:[0-9]{3})?)$/;
    var goon = false;

    $('input#card_number').formance('format_credit_card_number').on('keyup change blur', function (event) {
        $('div.card_icon').removeClass('hover');
        if (!$(this).formance('validate_credit_card_number')) {
            $(this).addClass('wrong');
            goon = false;
        } else {
            $(this).removeClass('wrong');
            $('#info_msg').css('visibility', 'hidden');
            goon = true;
            var type = '',
                supported = ['master', 'visa', ''];
            var cc_number = $(this).val().replace(/\s/g, '');

            if ((VISA.exec(cc_number))) {
                type = 'visa';
            } else if (JCB.exec(cc_number)) {
                type = 'jcb';
            } else if (DINERS.exec(cc_number)) {
                type = 'diners';
            } else if (MAESTRO.exec(cc_number)) {
                type = 'maestro';
            } else if (AMERICAN.exec(cc_number)) {
                type = 'amex';
            } else if (MASTERCARD.exec(cc_number)) {
                type = 'master';
            }

            if (supported.indexOf(type) < 0) {
                $('#info_msg').css('visibility', 'visible');
                goon = false;
            }
            if (type !== '') {
                $('#' + type).addClass('hover');
            }
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

