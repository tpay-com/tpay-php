var count = 1;
var contentTpay;
window.onload = function () {
    contentTpay = document.getElementById("groups_v").innerHTML;
};
document.getElementById("blikcode").onkeyup = function () {

    if (document.getElementById("blikcode").value !== "") {
        document.getElementById("groups_v").innerHTML = "";
        count = 0;
    } else if (count === 0) {
        document.getElementById("groups_v").innerHTML = contentTpay;
        count = 1;
    }
};
