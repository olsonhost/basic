var registerPart = $('.register-part');
var loginPart = $('.login-part')

var loginSubmit = $('#login-submit');
var regSubmit = $('#reg-submit');

var loginEmail = $('#login-email');
var loginPassword = $('#login-password');

var regName = $('#reg-name');
var regEmail = $('#reg-email');
var regPassword = $('#reg-password');
var regPassword2 = $('#reg-password2');


$('.joinbutton').on('click', function () {
    loginPart.hide();
    registerPart.show();
    doClearForms();

})

$('.loginbutton').on('click', function () {
    registerPart.hide();
    loginPart.show();
})

function doClearForms() {
    loginEmail.val('');
    loginPassword.val('');
    regName.val('');
    regEmail.val('');
    regPassword.val('');
    regPassword2.val('');
}

function doLoginCheck() {
    if ((loginEmail.val() != '') && (loginPassword.val() != '')) {
        loginSubmit.prop('disabled', false);
    } else {
        loginSubmit.prop('disabled', true);
    }
}

function doPasswordCheck() {
    if ((regEmail.val() != '') && (regPassword.val() != '') && (regPassword.val() == regPassword2.val())) {
        console.log('pass');
        regSubmit.prop('disabled', false);
    } else {
        console.log('fail');
        regSubmit.prop('disabled', true);
    }
}
