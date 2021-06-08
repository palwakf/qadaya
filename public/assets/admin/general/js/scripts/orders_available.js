


var OrdersAvailable = function () {

    var view_tbl;
    var list_url = base_url + prefix + '/orders_available/list';
    var view_url = base_url + prefix + '/orders_available';
    var table_id = '#orders_available_table';
    /////////////////// View //////////////////
    ///////////////////////////////////////////
    var viewTable = function () {
        var link = list_url;
        var columns = [
            {"data": "index", "title": "#", "orderable": false, "searchable": false},
            {"data": "created_at", "orderable": true, "searchable": true},
            {"data": "customer_id", "orderable": true, "searchable": true},
            {"data": "user_id", "orderable": true, "searchable": true},
            {"data": "language_id", "orderable": true, "searchable": true},
            {"data": "package_id", "orderable": true, "searchable": true},
            {"data": "attachments", "orderable": false, "searchable": false},
            {"data": "completed", "orderable": true, "searchable": true},
            {"data": "status", "orderable": false, "searchable": false},
            {"data": "actions", "orderable": false, "searchable": false, "class" : "text-center"}
        ];
        var perPage = 25;
        var order = [[1, 'desc']];

        var ajaxFilter = function (d) {
            d.name = $('#name').val();
            d.status = $('#status').val();
        };

        view_tbl = DataTable.init($(table_id), link, columns, order, ajaxFilter, perPage);
    }
    //////////////// ACCEPT ///////////////////
    ///////////////////////////////////////////
    var acceptOrder = function () {
        $(document).on('click', '.accept_btn', function (e) {
            e.preventDefault();
            var btn = $(this);

            Common.accept(function() {
                var link = btn.data('url');
                var formData = {};
                var method = "post";

                Forms.doAction(link, formData, method, view_tbl);
            });
        });
    };
    //////////////// REJECT ///////////////////
    ///////////////////////////////////////////
    var rejectOrder = function () {
        $(document).on('click', '.reject_btn', function (e) {
            e.preventDefault();
            var btn = $(this);

            Common.accept(function() {
                var link = btn.data('url');
                var formData = {};
                var method = "post";

                Forms.doAction(link, formData, method, view_tbl);
            });
        });
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
            acceptOrder();
            search();
            // rejectOrder();
        }
    }
}();

$(document).ready(function() {
    OrdersAvailable.init();
});
