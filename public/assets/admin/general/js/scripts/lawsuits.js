


var Lawsuits = function () {
    var view_tbl;
    var view_url = base_url + 'lawsuits';
    var list_url = base_url + 'lawsuits/list';
    var table_id = '#lawsuits_table';
    /////////////////// View //////////////////
    ///////////////////////////////////////////
    var viewTable = function () {
        var link = list_url;
        var columns = [
            {"data": "index", "title": "#", "orderable": false, "searchable": false},
            {"data": "lawsuit_number", "orderable": true, "searchable": true},
            {"data": "claimant", "orderable": true, "searchable": true},
            {"data": "defendant", "orderable": true, "searchable": true},
            {"data": "type_name", "orderable": true, "searchable": true},
            {"data": "court_name", "orderable": true, "searchable": true},
            {"data": "details", "orderable": true, "searchable": true},
            {"data": "status", "orderable": true, "searchable": true},
            {"data": "actions", "orderable": false, "searchable": false, "class" : "text-center"}
        ];

        var perPage = 25;
        var order = [[0, 'desc']];

        var ajaxFilter = function (d) {
            d.lawsuit_number = $('#lawsuit_number').val();
            d.is_archived = $('#is_archived').val();
            d.claimant = $('#claimant').val();
            d.defendant = $('#defendant').val();
            d.type_id = $('#type_id').val();
            d.court_id = $('#court_id').val();
        };

        console.log('request data');
        view_tbl = DataTable.init($(table_id), link, columns, order, ajaxFilter, perPage);
    };


    /////////////////// View Log //////////////////
    //////////////////////////////////////////////
    var logs_url = window.location.pathname;
    var lawsuit_id = logs_url.substring(logs_url.lastIndexOf('/') + 1);

    var view_logs_tbl;
    var view_logs_url = base_url + 'lawsuits/logs/' + lawsuit_id;
    var list_logs_url = base_url + 'lawsuits/logs/list/' + lawsuit_id;
    var table_logs_id = '#logs_table';
    var viewLogTable = function () {
        var linkURL = list_logs_url;
        var datatable_columns = [
            {"data": "index", "title": "#", "orderable": false, "searchable": false},
            {"data": "lawsuit_number", "orderable": true, "searchable": true},
            {"data": "claimant", "orderable": true, "searchable": true},
            {"data": "defendant", "orderable": true, "searchable": true},
            {"data": "type_name", "orderable": true, "searchable": true},
            {"data": "court_name", "orderable": true, "searchable": true},
            {"data": "details", "orderable": true, "searchable": true},
            {"data": "actions", "orderable": false, "searchable": false, "class" : "text-center"}
        ];

        var per_page = 25;
        var order_page = [[1, 'desc']];

        var ajaxFiltering = function (d) {
            d.lawsuit_number = $('#lawsuit_number').val();
        };

        view_logs_tbl = DataTable.init($(table_logs_id), linkURL, datatable_columns, order_page, ajaxFiltering, per_page);
    };

    /////////////////// ADD ///////////////////
    ///////////////////////////////////////////
    var add = function () {
        $('#frmAdd').submit(function(e) {
            e.preventDefault();
            var link = $(this).attr('action');
            var formData = $(this).serialize();
            var method = $(this).attr('method');

            Forms.doAction(link, formData, method, null, callBack);
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
            Forms.doAction(link, formData, method, null, callBack);
        });
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
                Forms.doAction(link, formData, method, view_tbl);
            });
        });
    };
    //////////////// Search ///////////////////
    ///////////////////////////////////////////
    var archiveItem = function () {
        $(document).on('click', '.archive_btn', function (e) {
            e.preventDefault();
            var btn = $(this);

            var link = btn.data('url');
            var formData = {};
            var method = "GET";
            Forms.doAction(link, formData, method, view_tbl);
        });
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
    /////////////////// ADD Log ///////////////////
    //////////////////////////////////////////////
    var addLog = function () {
        $('#frmAddLog').submit(function(e) {
            e.preventDefault();
            var link = $(this).attr('action');
            var formData = $(this).serialize();
            var method = $(this).attr('method');

            Forms.doAction(link, formData, method, null, callBack);
        });
    };
    /////////////////// EDIT //////////////////
    ///////////////////////////////////////////
    var editLog = function () {
        $('#frmEditLog').submit(function(e) {
            e.preventDefault();
            var link = $(this).attr('action');
            var formData = $(this).serialize();
            var method = $(this).attr('method');
            Forms.doAction(link, formData, method, null, callBack);
        });
    };
    //////////////// DELETE ///////////////////
    ///////////////////////////////////////////
    var deleteLogItem = function () {
        $(document).on('click', '.delete_log_btn', function (e) {
            e.preventDefault();
            var btn = $(this);

            Common.confirm(function() {
                var link = btn.data('url');
                var formData = {};
                var method = "GET";
                Forms.doAction(link, formData, method, view_logs_tbl);
                //Forms.doAction(link, formData, method, null, callBack);

            });
        });
    };
    ///////////////// CallBack Function //////////////
    /////////////////////////////////////////////////

    var callBack = function (obj) {
        if(obj.code === 200) {
            var delay = 1750;

            setTimeout(function () {
                window.location = obj.redirect;
            }, delay);
        }
    };
    ///////////////// INITIALIZE //////////////
    ///////////////////////////////////////////
    return {
        init: function () {
            viewTable();
            viewLogTable();
            add();
            addLog();
            edit();
            editLog();
            deleteItem();
            deleteLogItem();
            archiveItem();
            search();
        }
    }
}();

$(document).ready(function() {
    //Lawsuits.init();

});
$( window ).on( "load", Lawsuits.init() );

