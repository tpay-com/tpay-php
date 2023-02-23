function CardPayment(url, pubkey) {
    this.url = url;
    this.pubkey = pubkey;
    $("#card_payment_form").attr("action", url);
    var numberInput = $('#card_number'),
        expiryInput = $('#expiry_date'),
        cvcInput = $('#cvc'),
        nameInput = $('#c_name'),
        emailInput = $('#c_email'),
        termsOfServiceInput = $('#tpay-cards-accept-regulations-checkbox');
    const TRIGGER_EVENTS = 'input change blur';

    const PEMPatternsByType = {
      public: {
        header: /-+BEGIN PUBLIC KEY-+/,
        footer: /-+END PUBLIC KEY-+/,
      },
      private: {
        header: /-+BEGIN PRIVATE KEY-+/,
        footer: /-+END PRIVATE KEY-+/,
      },
    };

    function binaryStringToArrayBuffer(str) {
      const buf = new ArrayBuffer(str.length);
      const bufView = new Uint8Array(buf);
      for (let i = 0, strLen = str.length; i < strLen; i += 1) {
        bufView[i] = str.charCodeAt(i);
      }
      return buf;
    }

    function arrayBufferToBase64(buffer) {
      const bufView = new Uint8Array(buffer);
      let inputString = "";
      for (let i = 0, byteLength = bufView.byteLength; i < byteLength; i += 1) {
        inputString += String.fromCharCode(bufView[i]);
      }
      return window.btoa(inputString);
    }

    function extractDER(pem, type) {
      if (typeof pem !== "string") {
        throw new TypeError("The pem argument must be a string");
      }
      // fetch the part of the PEM string between header and footer
      if (!PEMPatternsByType[type]) {
        throw new Error(
          "Unknown key type: " +
            type +
            " - supported key types: " +
            Object.keys(PEMPatternsByType).join(", ")
        );
      }
      const { header: headerPattern, footer: footerPattern } =
        PEMPatternsByType[type];
      const headerMatch = pem.match(headerPattern);
      const footerMatch = pem.match(footerPattern);
      if (!headerMatch || !footerMatch) {
        throw new Error("No header/footer found in PEM");
      }
      const pemContents = pem.slice(
        headerMatch.index + headerMatch[0].length,
        footerMatch.index
      );
      // base64 decode the string to get the binary data
      const binaryDerString = window.atob(pemContents);
      // convert from a binary string to an ArrayBuffer
      return binaryStringToArrayBuffer(binaryDerString);
    }

    function encodeCardDetails(publicKey, cardDetails) {
      const extractedDER = extractDER(window.atob(publicKey), "public");
      return window.crypto.subtle
        .importKey(
          "spki",
          extractedDER,
          { name: "RSA-OAEP", hash: "SHA-256" },
          false,
          ["encrypt"]
        )
        .then(function (cryptoKey) {
          return window.crypto.subtle
            .encrypt(
              { name: "RSA-OAEP" },
              cryptoKey,
              new TextEncoder().encode(cardDetails)
            )
            .then(function (cryptoText) {
              return arrayBufferToBase64(cryptoText);
            });
        });
    }

    function SubmitPayment() {
      const cardNumber = numberInput.val().replace(/\s/g, "");
      const cd =
        cardNumber +
        "|" +
        expiryInput.val().replace(/\s/g, "") +
        "|" +
        cvcInput.val().replace(/\s/g, "") +
        "|" +
        document.location.origin;

      encodeCardDetails(pubkey, cd).then(function (encryptedDetails) {
        $("#card_continue_btn").fadeOut();
        $("#loading_scr").fadeIn();
        $("#carddata").val(encryptedDetails);
        $("#card_vendor").val($.payment.cardType(cardNumber));
        numberInput.val("");
        expiryInput.val("");
        cvcInput.val("");
        $("#card_payment_form").trigger("submit");
      });
    }

    function setWrong($elem) {
        $elem.addClass('wrong').removeClass('valid');
    }

    function setValid($elem) {
        $elem.addClass('valid').removeClass('wrong');
    }

    function validateCcNumber($elem) {
        var isValid = false,
            ccNumber = $.payment.formatCardNumber($elem.val()),
            supported = ['mastercard', 'maestro', 'visa'],
            type = $.payment.cardType(ccNumber),
            notValidNote = $('#info_msg_not_valid'),
            cardTypeHolder = $('.tpay-card-icon'),
            notSupportedNote = $('#info_msg_not_supported');
        $elem.val($.payment.formatCardNumber($elem.val()));
        cardTypeHolder.attr('class', 'tpay-card-icon');
        if (supported.indexOf(type) < 0 && type !== null && ccNumber.length > 1) {
            showElem(notSupportedNote);
            hideElem(notValidNote);
            setWrong($elem);
        } else if (supported.indexOf(type) > -1 && $.payment.validateCardNumber(ccNumber)) {
            setValid($elem);
            hideElem(notSupportedNote);
            hideElem(notValidNote);
            isValid = true;
        } else if (ccNumber.length < 4) {
            hideElem(notSupportedNote);
            hideElem(notValidNote);
            setWrong($elem);
        } else {
            setWrong($elem);
            showElem(notValidNote);
            hideElem(notSupportedNote);
        }
        if (type !== '') {
            cardTypeHolder.addClass('tpay-' + type + '-icon');
        }

        return isValid;
    }

    function hideElem($elem) {
        $elem.css('display', 'none');
    }

    function showElem($elem) {
        $elem.css('display', 'block');
    }

    function validateExpiryDate($elem) {
        var isValid = false, expiration;
        $elem.val($.payment.formatExpiry($elem.val()));
        expiration = $elem.payment('cardExpiryVal');
        if (!$.payment.validateCardExpiry(expiration.month, expiration.year)) {
            setWrong($elem);
        } else {
            setValid($elem);
            isValid = true;
        }

        return isValid;
    }

    function validateCvc($elem) {
        var isValid = false;
        if (!$.payment.validateCardCVC($elem.val(), $.payment.cardType(numberInput.val().replace(/\s/g, '')))) {
            setWrong($elem);
        } else {
            setValid($elem);
            isValid = true;
        }

        return isValid;
    }

    function validateName($elem) {
        var isValid = false;
        if ($elem.val().length < 3) {
            setWrong($elem);
        } else {
            isValid = true;
            setValid($elem);
        }

        return isValid;
    }

    function validateEmail($elem) {
        var isValid = false;
        if (!$elem.formance('validate_email')) {
            setWrong($elem);
        } else {
            isValid = true;
            setValid($elem);
        }

        return isValid;
    }

    function checkName() {
        if (nameInput.length > 0) {
            return validateName(nameInput);
        }

        return true;
    }

    function checkEmail() {
        if (emailInput.length > 0) {
            return validateEmail(emailInput);
        }

        return true;
    }

    function validateTos($elem) {
        if ($elem.is(':checked')) {
            setValid($elem);

            return true;
        } else {
            setWrong($elem);

            return false;
        }
    }

    function checkForm() {
        var isValidForm = false;
        if (
            validateCcNumber(numberInput)
            && validateExpiryDate(expiryInput)
            && validateCvc(cvcInput)
            && checkName()
            && checkEmail()
            && validateTos(termsOfServiceInput)
        ) {
            isValidForm = true;
        }

        return isValidForm;
    }

    $('#card_continue_btn').click(function () {
        var savedId = $('input[name=savedId]:checked').val();
        if ((savedId === 'new' || !$('input[name=savedId]').length) && checkForm()) {
            SubmitPayment();
        }
        if ($.isNumeric(savedId) && validateTos(termsOfServiceInput)) {
            $('#saved_card_payment_form').submit();
        }
    });
    numberInput.on(TRIGGER_EVENTS, function () {
        validateCcNumber($(this));
    });
    expiryInput.on(TRIGGER_EVENTS, function () {
        validateExpiryDate($(this));
    });
    cvcInput.on(TRIGGER_EVENTS, function () {
        validateCvc($(this));
    });
    nameInput.on(TRIGGER_EVENTS, function () {
        validateName($(this));
    });
    emailInput.on(TRIGGER_EVENTS, function () {
        validateEmail($(this));
    });
    termsOfServiceInput.on(TRIGGER_EVENTS, function () {
        validateTos($(this));
    });

}

$('document').ready(function () {
    $('input[name=savedId]').first().prop('checked', "checked");
    handleForm();
});

function handleForm() {
    $('input[name=savedId]').each(function () {
        $(this).click(function () {
            if ($(this).is(":checked")) {
                if ($(this).val() !== 'new') {
                    $('#card_form').css({opacity: 1.0}).animate({opacity: 0.0}, 500);
                    setTimeout(
                        function () {
                            $('#card_form').css({display: "none"})
                        }, 500
                    );
                }
            }

        });
    });
    $('#newCard').click(function () {
        if ($(this).is(":checked")) {
            $('#card_form').css({opacity: 0.0, display: "block"}).animate({opacity: 1.0}, 500);
        }
    });
}
