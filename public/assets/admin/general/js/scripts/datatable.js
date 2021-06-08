


var DataTable = function () {

    var initDataTable = function (table, link, columns, order, ajaxFilter, perPage, hasIndex) {

        hasIndex = (typeof hasIndex === "boolean") ? hasIndex : true;

        var oTable = table.DataTable({
            "processing": true,
            "serverSide": true,
            "searching": false,
            "bLengthChange": false,
            "pageLength": perPage,
            "bJQueryUI": false,
            "ajax": {
                url: link,
                data: ajaxFilter
            },
            responsive: true,
            // DOM Layout settings
            dom: "<'row'<'col-sm-12'tr>><'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>",
            language: {
                "sProcessing": Common.getCurrentLanguage() === 'ar' ? ".:: معالجة ::." : ".:: Processing ::.",
                'lengthMenu': Common.getCurrentLanguage() === 'ar' ? "اظهار _MENU_" : "Display _MENU_",
                "sLengthMenu": Common.getCurrentLanguage() === 'ar' ? "أظهر _MENU_ مدخلات" : "Show _MENU_ Record",
                "sZeroRecords": Common.getCurrentLanguage() === 'ar' ? "لم يعثر على أية سجلات" : "No records found",
                "emptyTable": Common.getCurrentLanguage() === 'ar' ? "لا تتوفر بيانات في الجدول" : "No data in the table",
                "sInfo": Common.getCurrentLanguage() === 'ar' ? "إظهار _START_ إلى _END_ من أصل _TOTAL_ مدخل" : "Show _START_ to _END_ from _TOTAL_ record",
                "sInfoEmpty": Common.getCurrentLanguage() === 'ar' ? "يعرض 0 إلى 0 من أصل 0 سجل" : "Show 0 to 0 from 0 record",
                "sInfoFiltered": Common.getCurrentLanguage() === 'ar' ? "(منتقاة من مجموع _MAX_ مُدخل)" : "(Selected from total _MAX_ entrance)",
                "sInfoPostFix": "",
                "sSearch": "ابحث: ",
                "sUrl": "",
            },
            "order": order,
            "columnDefs": [{
                "targets": "_all",
                "defaultContent": ""
            }],

            "columns": columns,
            "fnDrawCallback": function (oSettings) {
                if(hasIndex) {
                    oTable.column(0).nodes().each(function (cell, i) {
                        cell.innerHTML = (parseInt(oTable.page.info().start)) + i + 1;
                    });
                }
                $('[data-popup="tooltip"]').tooltip();
            }
        });

        $('.dataTables_length select').select2({
            minimumResultsForSearch: Infinity,
            width: 'auto'
        });

        return oTable;
    };

    return {
        init: function (table, link, columns, order, ajaxFilter, perPage, hasIndex) {
            // $.extend($.fn.dataTable.defaults, {
            //     autoWidth: false,
            //     columnDefs: [{
            //         orderable: false,
            //         width: '100px',
            //         targets: [5]
            //     }],
            //     dom: '<"datatable-header"fl><"datatable-scroll"t><"datatable-footer"ip>',
            //     language: detectLang(),
            //     drawCallback: function () {
            //         $(this).find('tbody tr').slice(-3).find('.dropdown, .btn-group').addClass('dropup');
            //     },
            //     preDrawCallback: function () {
            //         $(this).find('tbody tr').slice(-3).find('.dropdown, .btn-group').removeClass('dropup');
            //     }
            // });

            return initDataTable(table, link, columns, order, ajaxFilter, perPage, hasIndex);
        },
        updateDataTable: function (oTable) {
            oTable.draw(false);
        },
        destroyDataTable: function (oTable) {
            oTable.fnDestroy();
        }
    }
}();
