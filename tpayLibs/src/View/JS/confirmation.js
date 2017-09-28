var bank_account_div = document.getElementById('tpay-bank-account'),
    bank_select = document.getElementById('tpay-bank-select');

bank_select.onchange = function () {
    bank_account_div.innerText = this.value;
};
bank_account_div.innerText = bank_select.value;
