function ValidateEmail(email) {
    var expr = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
    return expr.test(email);
};

function ValidatePassword(password) {
    if(password.length > 5){
        return true;
    }else {
        return false;
    }
};

function ValidateZipcode(number) {
    var expr = /([0-9]{5})/;
    return expr.test(number);
};

function ValidatePhonepumber(number) {
    var expr = /\(?([0-9]{3})\)?([ .-]?)([0-9]{3})\2([0-9]{4})/;
    return expr.test(number);
};