

var Login = function () {

    var adminLogin = function () {
        $('#loginForm').submit(function(e) {
            e.preventDefault();

            var link = $(this).attr('action');
            var formData = $(this).serialize();
            var method = $(this).attr('method');

            Forms.doAction(link, formData, method, null, loginSuccessCallBack);
        });
    };

    var loginSuccessCallBack = function () {
        var delay = 1750;

        setTimeout(function() {
            window.location = admin_url;
        }, delay);
    };

    return {
        init: function () {
            adminLogin();
        }
    }
}();

$(document).ready(function() {
    Login.init();
});
