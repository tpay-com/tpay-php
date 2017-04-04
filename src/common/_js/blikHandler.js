/**
 * Created by tpay.com
 */

var blikResult, button, register = 0, attempt = 0, title;
var buttonDiv = document.getElementById('tpayBlikButton');
var loaderGif = '<img src="https://tpay.com/wp-content/themes/corpress/assets/images/loading.gif">';
function showT6() {
    document.getElementById("code").style.visibility = "visible";
    document.getElementById("alias").style.visibility = "hidden";
}
function checkRegister() {
    var checkbox = document.getElementById("register");
    if (checkbox.checked = true) {
        checkbox.value = 1;
    } else {
        checkbox.value = 0;
    }
    register = checkbox.value;
}
function showAliases() {
    var x = document.getElementById("blikSwitch");
    for (var i = 1; i < blikResult.length - 1;) {
        var option = document.createElement("option");
        option.text = blikResult[i];
        option.value = blikResult[i + 1];
        x.add(option);
        i = i + 2
    }
    document.getElementById("alias").style.visibility = "visible";
}
function ajax(data) {

    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
            console.log(xhr.responseText);
            blikResult = xhr.responseText.split(",");
        }
    };

    xhr.open("GET", "initBlik.php?" + data, true);
    xhr.send();
}

function blikHandler() {
    // call first function and pass in a callback function which
    // first function runs when it has completed
    button = buttonDiv.innerHTML;
    buttonDiv.innerHTML = loaderGif;
    if (attempt === 0) {
        ajax('tryOneClick');
        setTimeout(function () {
            checkResponse();
            title = blikResult[0];
        }, 5000);
    } else if (attempt === 1) {
        var e = document.getElementById("blikSwitch");
        var key = e.options[e.selectedIndex].value;
        ajax('aliasKey=' + key + '&title=' + title);
        setTimeout(function () {
            checkResponse();
        }, 5000);
    } else {
        var code = document.getElementById("blikcode").value;
        ajax('code=' + code + '&title=' + title + '&register=' + register);
        setTimeout(function () {
            checkResponse();
        }, 5000);
    }
}
function checkResponse() {
    var i = 0;
    if (attempt === 0) {
        i = 1;
    }

    if (blikResult[i] === '1') {
        alert('sukces!');
    } else if (blikResult[i] === '0') {
        showT6();
        attempt = 2;
    } else {
        alert('alias niejednoznaczny');
        showAliases();
        attempt = 1;
    }
    buttonDiv.innerHTML = button;
}
