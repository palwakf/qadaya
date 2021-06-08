/**
 * Created by Mohammed on 10/7/17.
 */

var Forms = function () {

    var notify = function (title, code, message) {
        $.notify({
            // options
            // icon: 'la la-thumbs-up',
            title: title,
            message: message,
            // url: 'https://github.com/mouse0270/bootstrap-notify',
            // target: '_blank'
        },{
            // settings
            element: 'body',
            position: null,
            type: code,
            allow_dismiss: true,
            newest_on_top: true,
            showProgressbar: false,
            placement: {
                from: "bottom",
                align: Common.getCurrentLanguage() === 'ar' ? "left" : "right"
            },
            offset: 20,
            spacing: 10,
            z_index: 1031,
            delay: 5000,
            timer: 1000,
            url_target: '_blank',
            mouse_over: null,
            animate: {
                enter: 'animated fadeInDown',
                exit: 'animated fadeOutUp'
            },
            onShow: null,
            onShown: null,
            onClose: null,
            onClosed: null,
            icon_type: 'class',

        });
    };

    var getNotificationLayout = function () {
        return ((Common.getCurrentLanguage() === 'ar' && Common.getCurrentDirection() === 'rtl') ? "left" : "right");
    };

    var getNotificationType = function (code) {
        if (code >= 200 && code <= 299) {
            return 'success'
        }
        else if (code >= 300 && code <= 399) {
            return 'info';
        }
        else if (code >= 400 && code <= 499) {
            return 'warning';
        }
        else if (code >= 500 && code <= 599) {
            return 'danger';
        }
        else {
            return 'alert';
        }
    };

    return {
        init: function () {
            //serializeForm();
        },

        doAction: function (link, data, type, dataTable, callback, showNotification) {

            var method = (type !== "") ? type : "GET";
            showNotification = (typeof showNotification === "boolean") ? showNotification : true;
            var flag = (typeof(data) === 'string') ? 'application/x-www-form-urlencoded; charset=UTF-8' : false;

            $.ajax({
                type: method,
                url: link,
                data: data,
                dataType: 'json',
                processData: flag,
                contentType: flag,
            }).done(function (data) {
                if (showNotification) {
                    notify(data.title, getNotificationType(data.code), data.message);
                }

                if (data.code === 200) {
                    // var res_actor = link.split("/");
                    // var res_movie = link.split("/");
                    // var actor = res.indexOf('actors');
                    // var movie = res.indexOf('movies');
                    // var result_actor = res_actor[actor+1];
                    // var result_movie = res_movie[movie+1];
                    // if (result_movie !== 'information')
                    // {
                    //     $(".save").html(Common.getCurrentLanguage() === 'ar' ? "جارِ الحفظ، رجاءً انتظر, .." : "Saving, please wait, ..").attr("disabled", "disabled");
                    // }
                    // if (result_actor !== 'information')
                    // {
                    //     $(".save").html(Common.getCurrentLanguage() === 'ar' ? "جارِ الحفظ، رجاءً انتظر, .." : "Saving, please wait, ..").attr("disabled", "disabled");
                    // }
                    if (dataTable !== null) {
                        dataTable.draw(false);
                    }
                    if (typeof callback === "function") {
                        callback(data);
                    }
                }
            }).fail(function (request, status, error) {
                var message = "(";
                message += request.status;
                message += ") ";
                message += request.statusText;
                // notify(message, getNotificationType(500));
                notify('أوه!', getNotificationType(500), 'عذراً - حدث خطأ أثناء معالجة البيانات');

                if(parseInt(request.status) === 401) {
                    var delay = 1750;

                    setTimeout(function() {
                        window.location = base_url;
                    }, delay);
                }
            });
        },
        doActionHtml: function (link, data, type, callback) {

            var method = (type !== "") ? type : "GET";

            $.ajax({
                type: method,
                url: link,
                data: data,
                dataType: 'html',
            }).done(function (data) {
                if (typeof callback === "function") {
                    callback(data);
                }
            }).fail(function (request, status, error) {
                var message = "(";
                message += request.status;
                message += ") ";
                message += request.statusText;

                notify('Internal Error', getNotificationType(500), 'Internal Server Error');

                if(parseInt(request.status) === 401) {
                    var delay = 1750;

                    setTimeout(function() {
                        window.location = base_url;
                    }, delay);
                }
            });
        },
        notify: function (title, code, message) {
            return notify(title, getNotificationType(code), message);
        },
        refreshUniform: function () {
            $.uniform.update();
        }
    }
}();
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
var Common = function () {

    var html_el = $('html');
    var current_language = html_el.attr('lang');
    var current_layout_direction = html_el.attr('dir');

    var detectLang = function () {
        current_language = html_el.attr('lang');
        current_layout_direction = html_el.attr('dir');
    };

    var initializeSelect = function () {
        var select = $('select');
        //
        // if(select.length) {
        //     select.select2({
        //         minimumResultsForSearch: Infinity,
        //         width: '100%'
        //     });
        // }
    };

    var initializeToken = function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'Accept-Language': Common.getCurrentLanguage() === 'ar' ? "ar" : "en"
            }
        });
    };

    return {
        init: function () {
            detectLang();
            initializeSelect();
            initializeToken();

            var styled = $('.styled');

            if(styled.length) {
                styled.uniform({
                    radioClass: 'choice'
                });
            }
        },
        getCurrentLanguage: function () {
            return current_language;
        },
        getCurrentDirection: function () {
            return current_layout_direction;
        },
        confirm: function (callback) {
            swal.fire({
                title: Common.getCurrentLanguage() === 'ar' ? "هل أنت متأكد؟" : "Are you sure?",
                text: Common.getCurrentLanguage() === 'ar' ? "لا يمكن استعادتها لاحقا!" : "Can't be restored later!",
                buttonsStyling: false,
                confirmButtonText: Common.getCurrentLanguage() === 'ar' ? "<i class=\"la la-thumbs-up\"></i>نعم, احذفها" : "<i class=\"la la-thumbs-up\"></i> Yes, delete it",
                confirmButtonClass: "btn btn-danger",
                showCancelButton: true,
                cancelButtonText: Common.getCurrentLanguage() === 'ar' ? "<i class=\"la la-thumbs-down\"></i> لا, شكراً" : "<i class=\"la la-thumbs-down\"></i> No, thanks",
                cancelButtonClass: "btn btn-light btn-elevate",
            }).then(function(result){
                if (result.value) {
                    callback();
                }
            });
        },

        accept: function (callback) {
            swal.fire({
                title: Common.getCurrentLanguage() === 'ar' ? "هل تريد قبول الطلب؟" : "Are you sure?",
                text: Common.getCurrentLanguage() === 'ar' ? "قبول طلب جديد!" : "Can't be restored later!",
                buttonsStyling: false,
                confirmButtonText: Common.getCurrentLanguage() === 'ar' ? "<i class=\"la la-thumbs-up\"></i>نعم, اقبله" : "<i class=\"la la-thumbs-up\"></i> Yes, delete it",
                confirmButtonClass: "btn btn-danger",
                showCancelButton: true,
                cancelButtonText: Common.getCurrentLanguage() === 'ar' ? "<i class=\"la la-thumbs-down\"></i> لا, شكراً" : "<i class=\"la la-thumbs-down\"></i> No, thanks",
                cancelButtonClass: "btn btn-light btn-elevate",
            }).then(function(result){
                if (result.value) {
                    callback();
                }
            });
        },

        generateURL: function(query) {
            return base_url + query;
        },
        redirect: function(query) {
            var delay = 1750;

            setTimeout(function() {
                window.location = Common.generateURL(query);
            }, delay);
        },
    }
}();

$(document).ready(function() {
    Forms.init();
    Common.init();
});
