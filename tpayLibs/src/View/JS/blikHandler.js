/**
 * Created by tpay.com
 */

var blikResult, button, register = 0, attempt = 0, title;
var buttonDiv = document.getElementById('tpayBlikButton');
var loaderGif = '<img src="https://tpay.com/wp-content/themes/corpress/assets/images/loading.gif">';
var code = document.getElementById("blikcode");

function showHide(ID, bool) {
    document.getElementById(ID).style.visibility = bool ? "visible" : "hidden";
}

function showT6() {
    showHide("codeFields", true);
    showHide("alias", false);
    showHide("t6InputMsg", false);
    if (code.value !== '') {
        attempt = 2;
    }
}
function checkRegister() {
    var checkbox = document.getElementById("register");
    checkbox.value = checkbox.checked ? 1 : 0;
    register = checkbox.value;
}
function showAliases() {
    var x = document.getElementById("blikSwitch");
    for (var i = 0; i < blikResult.length - 1;) {
        var option = document.createElement("option");
        option.text = blikResult[i];
        option.value = blikResult[i + 1];
        x.add(option);
        i = i + 2
    }
    showHide("alias", true);
}
function ajax(data) {

    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
            console.log(xhr.responseText);
            blikResult = xhr.responseText.split(",");
        }
    };

    xhr.open("GET", "OneClick.php?" + data, true);
    xhr.send();
}
$( document ).ready(function() {
    ajax(('getTitle'));
    setTimeout(function () {
        title = blikResult[0];
    }, 5000);
});


function blikHandler() {
    // call first function and pass in a callback function which
    // first function runs when it has completed
    button = buttonDiv.innerHTML;
    buttonDiv.innerHTML = loaderGif;
    if (attempt === 0) {
        ajax('tryOneClick&title=' + title);
        setTimeout(function () {
            checkResponse();
        }, 5000);
    } else if (attempt === 1) {
        var e = document.getElementById("blikSwitch");
        var key = e.options[e.selectedIndex].value;
        ajax('aliasKey=' + key + '&title=' + title);
        setTimeout(function () {
            checkResponse();
        }, 5000);
    } else {
        ajax('code=' + code.value + '&title=' + title + '&register=' + register);
        setTimeout(function () {
            checkResponse();
        }, 5000);
    }
}
function checkResponse() {
    var i = 0;

    if (blikResult[i] === '1') {
        document.getElementById("blikOneClickForm").innerHTML = "<p>SUKCES!</p>";
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
