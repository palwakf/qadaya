


var Dashboard = function () {

    var dashboard_view_url = dashboard_view;
    // var dashboard_profile_url = dashboard_profile;
    // var dashboard_password_url = dashboard_password;
    /////////////////// EDIT //////////////////
    ///////////////////////////////////////////
    var myProfile = function () {
        $('#frmMyProfile').submit(function(e) {
            e.preventDefault();
            var link = $(this).attr('action');
            var formData = $(this).serialize();
            var method = $(this).attr('method');
            Forms.doAction(link, formData, method, null, myProfileCallBack);
        });
    };

    var myProfileCallBack = function (obj) {
        if(obj.code === 200) {
            var delay = 1750;

            setTimeout(function () {
                window.location = dashboard_view_url;
            }, delay);
        }
    };
    /////////// Change Password ///////////////
    ///////////////////////////////////////////
    var changeMyPassword = function () {
        $('#frmChangeMyPassword').submit(function(e) {
            e.preventDefault();
            var link = $(this).attr('action');
            var formData = $(this).serialize();
            var method = $(this).attr('method');
            Forms.doAction(link, formData, method, null, changeMyPasswordCallBack);
        });
    };

    var changeMyPasswordCallBack = function (obj) {
        if(obj.code === 200) {
            var delay = 1750;

            setTimeout(function () {
                window.location = dashboard_view_url;
            }, delay);
        }
    };
    ///////////////// INITIALIZE //////////////
    ///////////////////////////////////////////
    return {
        init: function () {
            myProfile();
            changeMyPassword();
        }
    }
}();

$(document).ready(function() {
    Dashboard.init();
});
