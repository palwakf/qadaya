


var Customers = function () {

    var view_tbl;
    var view_url = base_url + prefix + '/customers';
    var list_url = base_url + prefix + '/customers/list';
    var table_id = '#customers_table';
    /////////////////// View //////////////////
    ///////////////////////////////////////////
    var viewTable = function () {
        var link = list_url;
        var columns = [
            {"data": "index", "title": "#", "orderable": false, "searchable": false},
            {"data": "created_at", "orderable": true, "searchable": true},
            {"data": "name", "orderable": false, "searchable": true},
            {"data": "email", "orderable": true, "searchable": true},
            {"data": "mobile", "orderable": true, "searchable": true},
            {"data": "gender", "orderable": true, "searchable": true},
            {"data": "country_id", "orderable": false, "searchable": false},
            {"data": "status", "orderable": false, "searchable": false},
            {"data": "actions", "orderable": false, "searchable": false, "class" : "text-center"}
        ];
        var perPage = 25;
        var order = [[1, 'desc']];

        var ajaxFilter = function (d) {
            d.first_name = $('#first_name').val();
            d.last_name = $('#last_name').val();
            d.email = $('#email').val();
            d.status = $('#status').val();
        };

        view_tbl = DataTable.init($(table_id), link, columns, order, ajaxFilter, perPage);
    };
    /////////////////// EDIT //////////////////
    ///////////////////////////////////////////
    var edit = function () {
        $('#frmEdit').submit(function(e) {
            e.preventDefault();
            var link = $(this).attr('action');
            var formData = $(this).serialize();
            var method = $(this).attr('method');
            Forms.doAction(link, formData, method, null, editCallBack);
        });
    };

    var editCallBack = function (obj) {
        if(obj.code === 200) {
            var delay = 1750;

            setTimeout(function () {
                $(".save").removeClass("kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light").html('حفظ التغييرات').removeAttr('disabled');
            }, delay);
        }
    };
    /////////// Change Password ///////////////
    ///////////////////////////////////////////
    var changePassword = function () {
        $('#frmChangePassword').submit(function(e) {
            e.preventDefault();
            var link = $(this).attr('action');
            var formData = $(this).serialize();
            var method = $(this).attr('method');
            Forms.doAction(link, formData, method, null, changePasswordCallBack);
        });
    };

    var changePasswordCallBack = function (obj) {
        if(obj.code === 200) {
            var delay = 1750;

            setTimeout(function () {
                $(".save").removeClass("kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light").html('حفظ التغييرات').removeAttr('disabled');
                $('.clear').val('');
            }, delay);
        }
    };
    //////////////// DELETE ///////////////////
    ///////////////////////////////////////////
    var deleteItem = function () {
        $(document).on('click', '.delete_btn', function (e) {
            e.preventDefault();
            var btn = $(this);

            Common.confirm(function() {
                var link = btn.data('url');
                var formData = {};
                var method = "GET";

                Forms.doAction(link, formData, method, null, deletePasswordCallback);
            });
        });
    };

    var deletePasswordCallback = function (obj) {
        if(obj.code === 200) {
            var delay = 1750;

            setTimeout(function () {
                window.location = view_url;
            }, delay);
        }
    };
    //////////////// Search ///////////////////
    ///////////////////////////////////////////
    var search = function () {
        $('.searchable').on('input change', function (e) {
            e.preventDefault();
            view_tbl.draw(false);
        });

        $('.search').on('click', function (e) {
            e.preventDefault();
            view_tbl.draw(false);
        });

        $('#frmSearch').keydown(function (e) {
            if (e.keyCode == 13) {
                e.preventDefault();
                view_tbl.draw(false);
            }
        });
    };
    ///////////////// INITIALIZE //////////////
    ///////////////////////////////////////////
    return {
        init: function () {
            viewTable();
            edit();
            changePassword();
            deleteItem();
            search();
        }
    }
}();

$(document).ready(function() {
    Customers.init();
});
