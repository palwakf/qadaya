


var Orders = function () {

    var view_tbl;
    var view_url = base_url + prefix + '/orders';
    var list_url = base_url + prefix + '/orders/list';
    var table_id = '#orders_table';
    /////////////////////////////////
    var id = $('#order_id').attr('data-id');

    var view_item_url = base_url + prefix + '/orders/attachments/' + id;
    var list_item_url = base_url + prefix + '/orders/attachments/list/' + id;

    var table_item_id = '#orders_attachments_table';
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
    };
    //////////////// View Item ///////////////
    //////////////////////////////////////////
    var viewItemTable = function () {
        var link = list_item_url;
        var columns = [
            {"data": "index", "title": "#", "orderable": false, "searchable": false},
            {"data": "audited_attachment", "orderable": false, "searchable": false},
            // {"data": "remove", "orderable": false, "searchable": false, "class" : "text-center"}
        ];
        var perPage = 25;
        var order = [[0, 'desc']];

        var ajaxFilter = function (d) {

        };

        view_item_url = DataTable.init($(table_item_id), link, columns, order, ajaxFilter, perPage);
    };
    /////////////////// ADD ///////////////////
    ///////////////////////////////////////////
    var add = function () {
        $('#frmAdd').submit(function(e) {
            e.preventDefault();
            var link = $(this).attr('action');
            var formData = $(this).serialize();
            var method = $(this).attr('method');

            Forms.doAction(link, formData, method, null, addCallBack);
        });
    };

    var addCallBack = function (obj) {
        if(obj.code === 200) {
            var delay = 1750;

            setTimeout(function () {
                window.location = view_url;
            }, delay);
        }
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

                Forms.doAction(link, formData, method, view_tbl, callBackDeleteItem);
            });
        });
    };

    var callBackDeleteItem = function (obj) {
        if(obj.code === 200) {
            var delay = 1750;

            setTimeout(function () {
                window.location = view_url;
            }, delay);
        }
    };
    ///////////// ADD ATTACHMENT ///////////////
    ///////////////////////////////////////////
    var addAttachment = function () {
        $('#frmAddAttachment').submit(function(e) {
            e.preventDefault();
            var link = $(this).attr('action');
            var formData = new FormData(this);
            var method = $(this).attr('method');

            Forms.doAction(link, formData, method, null, addAttachmentCallBack);
        });
    };

    var addAttachmentCallBack = function (obj) {
        if(obj.code === 200) {
            var delay = 1750;

            setTimeout(function () {
                window.location = list_item_url;
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
            viewItemTable();
            add();
            edit();
            deleteItem();
            addAttachment();
            // deleteOrderItem();
            search();
        }
    }
}();

$(document).ready(function() {
    Orders.init();
});
