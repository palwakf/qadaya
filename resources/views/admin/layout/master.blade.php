<!DOCTYPE html>
<html lang="ar"  direction="ar" style="direction: rtl;" >
<!-- begin::Head -->
<head>
    <!--begin::Base Path (base relative path for assets of this page) -->
    <base href="{{ asset('/') }}">

    <!--end::Base Path -->
    <meta charset="utf-8" />
    <title>{{ env('APP_NAME') }} | @yield('title')</title>
    <meta name="description" content="Page with empty content">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!--begin::Fonts -->
    <script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js"></script>
    <script>
        WebFont.load({
            google: {
                "families": ["Poppins:300,400,500,600,700", "Roboto:300,400,500,600,700"]
            },
            active: function() {
                sessionStorage.fonts = true;
            }
        });
    </script>

    <!--end::Fonts -->
    <!--begin::Page Vendors Styles(used by this page) -->
    <link href="assets/admin/plugins/custom/datatables/datatables.bundle.rtl.css" rel="stylesheet" type="text/css" />
    <!--begin::Page Vendors Styles(used by this page) -->
    <link href="assets/admin/plugins/custom/fullcalendar/fullcalendar.bundle.rtl.css" rel="stylesheet" type="text/css" />
    <!--end::Page Vendors Styles -->

    <!--begin::Global Theme Styles(used by all pages) -->
    <link href="assets/admin/plugins/global/plugins.bundle.rtl.css" rel="stylesheet" type="text/css" />
    <link href="assets/admin/css/style.bundle.rtl.css" rel="stylesheet" type="text/css" />

    <!--end::Global Theme Styles -->

    <!--begin::Layout Skins(used by all pages) -->
    <link href="assets/admin/css/skins/header/base/light.rtl.css" rel="stylesheet" type="text/css" />
    <link href="assets/admin/css/skins/header/menu/light.rtl.css" rel="stylesheet" type="text/css" />
    <link href="assets/admin/css/skins/brand/dark.rtl.css" rel="stylesheet" type="text/css" />
    <link href="assets/admin/css/skins/aside/dark.rtl.css" rel="stylesheet" type="text/css" />
    @yield('css')
    <style>
        .kt-portlet .kt-portlet__body
        {
            padding: 23px;
        }
        .kt-notification .kt-notification__item:after
        {
            /*content: ">";*/
        }
        .kt-form.kt-form--label-right .form-group label:not(.kt-checkbox):not(.kt-radio):not(.kt-option)
        {
            text-align: right;
        }
        .custom-file-input:lang(en)~.custom-file-label::after
        {
            display: none;
        }
        .custom-file-label:after
        {
            display: none;
        }
        .custom-file-label
        {
            text-align: left !important;
        }
        .kt-aside-menu .kt-menu__nav
        {
            padding: 39px 0;
        }
        .la-angle-right:before
        {
            content: '\f111';
        }
        .la-angle-left:before
        {
            content: '\f112';
        }
    </style>
    <!--begin::Page Custom Styles -->
    <link href="assets/admin/general/css/scripts/custom-rtl.css" rel="stylesheet" type="text/css" />

    <!--end::Layout Skins -->
    <link rel="shortcut icon" href="uploads/admin/logo/icon-tab.png" />
</head>

<!-- end::Head -->

<!-- begin::Body -->
<body  class="kt-quick-panel--right kt-demo-panel--right kt-offcanvas-panel--right kt-header--fixed kt-header-mobile--fixed kt-subheader--enabled kt-subheader--fixed kt-subheader--solid kt-aside--enabled kt-aside--fixed kt-page--loading"  >
<!-- begin:: Page -->

<!-- begin:: Header Mobile -->
@include("admin.layout.header-mobile")

<!-- end:: Header Mobile -->
<div class="kt-grid kt-grid--hor kt-grid--root">
    <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--ver kt-page">

        <!-- begin:: Aside -->
        @include("admin.layout.aside")

        <!-- end:: Aside -->
        <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor kt-wrapper" id="kt_wrapper">

            <!-- begin:: Header -->
            @include("admin.layout.header")

            <!-- end:: Header -->
            <div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">

                <!-- begin:: Subheader -->
                <div class="kt-subheader   kt-grid__item" id="kt_subheader">
                    <div class="kt-container  kt-container--fluid ">
                        <div class="kt-subheader__main">
{{--                            <h3 class="kt-subheader__title">--}}
{{--                                هلا موفي </h3>--}}
{{--                            <span class="kt-subheader__separator kt-hidden"></span>--}}
                            <div class="kt-subheader__breadcrumbs">
                                <a href="{{ route('dashboard.view') }}" class="kt-subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
                                <span class="kt-subheader__breadcrumbs-separator"></span>
                                <a href="{{ route('dashboard.view') }}" class="kt-subheader__breadcrumbs-link">
                                    الرئيسية </a>
                                <span class="kt-subheader__breadcrumbs-separator"></span>
                                @yield('subheader')
                            </div>
                        </div>
                        @yield('action')
                    </div>
                </div>
                <!-- end:: Subheader -->

                <!-- begin:: Content -->
                <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
                    @yield('content')
                </div>
                <!-- end:: Content -->
            </div>

            <!-- begin:: Footer -->
            @include("admin.layout.footer")

            <!-- end:: Footer -->
        </div>
    </div>
</div>

<!-- end:: Page -->

<!-- begin::Quick Panel -->
@include("admin.layout.quick-panel")

<!-- end::Quick Panel -->

<!-- begin::Scrolltop -->
<div id="kt_scrolltop" class="kt-scrolltop">
    <i class="fa fa-arrow-up"></i>
</div>

@yield('modal')

<!-- begin::Global Config(global config for global JS sciprts) -->
<script>
    var KTAppOptions = {
        "colors": {
            "state": {
                "brand": "#5d78ff",
                "dark": "#282a3c",
                "light": "#ffffff",
                "primary": "#5867dd",
                "success": "#34bfa3",
                "info": "#36a3f7",
                "warning": "#ffb822",
                "danger": "#fd3995"
            },
            "base": {
                "label": [
                    "#c5cbe3",
                    "#a1a8c3",
                    "#3d4465",
                    "#3e4466"
                ],
                "shape": [
                    "#f0f3ff",
                    "#d9dffa",
                    "#afb4d4",
                    "#646c9a"
                ]
            }
        }
    };
</script>

<!-- end::Global Config -->

<!--begin::Global Theme Bundle(used by all pages) -->
<script src="assets/admin/plugins/global/plugins.bundle.js" type="text/javascript"></script>
<script src="assets/admin/js/scripts.bundle.js" type="text/javascript"></script>

<script src="assets/admin/plugins/custom/datatables/datatables.bundle.js" type="text/javascript"></script>
<!--end::Global Theme Bundle -->

<!--begin::Page Vendors(used by this page) -->
<script src="//maps.google.com/maps/api/js?key=AIzaSyBTGnKT7dt597vo9QgeQ7BFhvSRP4eiMSM" type="text/javascript"></script>
<script src="assets/admin/plugins/custom/gmaps/gmaps.js" type="text/javascript"></script>
<!--end::Page Vendors -->

<!--begin::Page Scripts(used by this page) -->
<script src="assets/admin/js/pages/dashboard.js" type="text/javascript"></script>
<script src="assets/admin/js/pages/crud/forms/widgets/bootstrap-select.js" type="text/javascript"></script>
<script src="assets/admin/js/pages/components/extended/sweetalert2.js" type="text/javascript"></script>
<script src="assets/admin/js/pages/crud/forms/widgets/bootstrap-datepicker.js" type="text/javascript"></script>
{{--<script src="assets/admin/js/pages/crud/forms/widgets/bootstrap-markdown.js" type="text/javascript"></script>--}}

<!--begin::Page Vendors(used by this page) -->
<!--end::Page Vendors -->
<!--begin::Page Scripts(used by this page) -->
<script src="{{ route('admin.common.general') }}"></script>
<script src="assets/admin/general/js/scripts/common.js"></script>
<script src="assets/admin/general/js/scripts/datatable.js"></script>
@yield('js')
{{--<script src="vendor/laravel-filemanager/js/lfm.js"></script>--}}
<script>
    {{--var domain = "{{ url('admin/storage') }}";--}}
    {{--$('button[id^="lfm"]').filemanager('images', {--}}
    {{--    prefix: domain--}}
    {{--});--}}
</script>
<script>
    @if(Session::has('data'))
        Forms.notify("{{ Session::get('data')['title'] }}", "{{ Session::get('data')['code'] }}", "{{ Session::get('data')['message'] }}");
    @endif

    ;(function($){
        $.fn.datepicker.dates['ar'] = {
            days: ["الأحد", "الاثنين", "الثلاثاء", "الأربعاء", "الخميس", "الجمعة", "السبت", "الأحد"],
            daysShort: ["أحد", "اثنين", "ثلاثاء", "أربعاء", "خميس", "جمعة", "سبت", "أحد"],
            daysMin: ["أحد", "اثنين", "ثلاثاء", "أربعاء", "خميس", "جمعة", "سبت", "أحد"],
            // daysMin: ["ح", "ن", "ث", "ع", "خ", "ج", "س", "ح"],
            months: ["يناير", "فبراير", "مارس", "أبريل", "مايو", "يونيو", "يوليو", "أغسطس", "سبتمبر", "أكتوبر", "نوفمبر", "ديسمبر"],
            monthsShort: ["يناير", "فبراير", "مارس", "أبريل", "مايو", "يونيو", "يوليو", "أغسطس", "سبتمبر", "أكتوبر", "نوفمبر", "ديسمبر"],
            today: "هذا اليوم",
            clear: "تفريغ الخانات",
            rtl: true
        };
    }(jQuery));

    $('.refresh').selectpicker();

    $('.date').datepicker({
        language: 'ar',
        todayHighlight: true,
        clearBtn: true,
        todayBtn: 'linked',
        orientation: 'bottom',
        autoclose: true,
        format: 'yyyy-m-d',
    });

    $.fn.selectpicker.defaults = {
        selectAllText: 'تحديد الكل',
        deselectAllText: 'الغاء تحديد الكل',
    };
</script>
<!--end::Page Scripts -->
</body>

<!-- end::Body -->
</html>
