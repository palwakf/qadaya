<!DOCTYPE html>
<html lang="ar"  direction="rtl" style="direction: rtl;" >
<!-- begin::Head -->
<head>
    <!--begin::Base Path (base relative path for assets of this page) -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <base href="{{ asset('/') }}">
    <!--end::Base Path -->
    <meta charset="utf-8" />
    <title>{{ env('APP_NAME') }} | تسجيل الدخول</title>
    <meta name="description" content="Login page example">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

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

    <!--begin::Page Custom Styles(used by this page) -->
    <link href="assets/admin/css/pages/login/login-5.rtl.css" rel="stylesheet" type="text/css" />

    <!--end::Page Custom Styles -->

    <!--begin::Global Theme Styles(used by all pages) -->
    <link href="assets/admin/plugins/global/plugins.bundle.rtl.css" rel="stylesheet" type="text/css" />
    <link href="assets/admin/css/style.bundle.rtl.css" rel="stylesheet" type="text/css" />

    <!--end::Global Theme Styles -->

    <!--begin::Layout Skins(used by all pages) -->
    <link href="assets/admin/css/skins/header/base/light.rtl.css" rel="stylesheet" type="text/css" />
    <link href="assets/admin/css/skins/header/menu/light.rtl.css" rel="stylesheet" type="text/css" />
    <link href="assets/admin/css/skins/brand/dark.rtl.css" rel="stylesheet" type="text/css" />
    <link href="assets/admin/css/skins/aside/dark.rtl.css" rel="stylesheet" type="text/css" />

    <!--begin::Page Custom Styles -->
    <link href="assets/admin/general/css/scripts/custom-rtl.css" rel="stylesheet" type="text/css" />

    <!--end::Page Custom Styles -->
    <style>
        ol.contacts {
            list-style-type: circle;
        }
    </style>
    <!--end::Layout Skins -->
    <link rel="shortcut icon" href="uploads/admin/logo/icon-tab.png" />
</head>

<!-- end::Head -->

<!-- begin::Body -->
<body class="kt-quick-panel--right kt-demo-panel--right kt-offcanvas-panel--right kt-header--fixed kt-header-mobile--fixed kt-subheader--fixed kt-subheader--enabled kt-subheader--solid kt-aside--enabled kt-aside--fixed kt-page--loading">

<!-- begin:: Page -->
<div class="kt-grid kt-grid--ver kt-grid--root">
    <div class="kt-grid kt-grid--hor kt-grid--root  kt-login kt-login--v5 kt-login--signin" id="kt_login">
        <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--desktop kt-grid--ver-desktop kt-grid--hor-tablet-and-mobile" style="background-image: url(assets/admin/media/bg/bg-3.jpg);">
            <div class="kt-login__left">
                <div class="kt-login__wrapper">
                    <div class="kt-login__content">
                        <a class="kt-login__logo" href="{{ route('admin.login.view') }}">
                            <img src="uploads/admin/logo/logo.png">
                        </a>
                        <h3 class="kt-login__title">{{ env('APP_NAME') }} ، ..</h3>
                        <span class="kt-login__desc">
                            وصف النظام
                        </span>
                    </div>
                </div>
            </div>
            <div class="kt-login__right">
                <div class="kt-login__wrapper">
                    <div class="kt-login__signin">
                        <div class="kt-login__head">
                            <h3 class="kt-login__title">تسجيل الدخول إلى حسابك <sup></sup>
                            </h3>
                        </div>
                        <div class="kt-login__form">
                            <form class="kt-form" id="loginForm" action="{{ route('admin.login.view') }}" method="post">
                                <div class="form-group">
                                    <input class="form-control" type="text" placeholder="إسم المستخدم" name="username" value="" autocomplete="off">
                                </div>
                                <div class="form-group">
                                    <input class="form-control form-control-last" type="Password" placeholder="كلمة المرور" value="" name="password">
                                </div>
                                <div class="row kt-login__extra">
                                    <div class="col kt-align-left">
                                        <label class="kt-checkbox">
                                            <input type="checkbox" name="remember_token"> تذكرني
                                            <span></span>
                                        </label>
                                    </div>
                                    <div class="col kt-align-right">
                                        <a href="javascript:;" id="kt_login_forgot" class="kt-link">نسيت كلمة المرور؟</a>
                                    </div>
                                </div>
                                <div class="kt-login__actions">
                                    <button id="" type="submit" class="btn btn-brand btn-pill btn-elevate">تسجيل الدخول</button>
                                    {!! csrf_field() !!}
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="kt-login__forgot">
                        <div class="kt-login__head">
                            <h3 class="kt-login__title">هل نسيت كلمة المرور؟</h3>
                            <div class="kt-login__desc">أدخل بريدك الإلكتروني لإعادة تعيين كلمة المرور الخاصة بك:</div>
                        </div>
                        <div class="kt-login__form">
                            <form class="kt-form" action="">
                                <div class="form-group">
                                    <input class="form-control" type="text" placeholder="البريد الإلكتروني" name="email" autocomplete="off">
                                </div>
                                <div class="kt-login__actions">
                                    <button id="kt_login_forgot_submit" class="btn btn-brand btn-pill btn-elevate">إرسال</button>
                                    <button id="kt_login_forgot_cancel" class="btn btn-outline-brand btn-pill">الغاء</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- end:: Page -->

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
                "label": ["#c5cbe3", "#a1a8c3", "#3d4465", "#3e4466"],
                "shape": ["#f0f3ff", "#d9dffa", "#afb4d4", "#646c9a"]
            }
        }
    };
</script>

<!-- end::Global Config -->

<!--begin::Global Theme Bundle(used by all pages) -->
<script src="assets/admin/plugins/global/plugins.bundle.js" type="text/javascript"></script>
<script src="assets/admin/js/scripts.bundle.js" type="text/javascript"></script>

<!--end::Global Theme Bundle -->

<!--begin::Page Scripts(used by this page) -->
<script src="assets/admin/js/pages/custom/login/login-general.js" type="text/javascript"></script>
<script src="assets/admin/js/pages/components/extended/bootstrap-notify.js" type="text/javascript"></script>

<!--end::Page Scripts -->

<!--begin::Page Common Scripts -->
<script src="{{ route('admin.common.general') }}"></script>
<script src="assets/admin/general/js/scripts/common.js" type="text/javascript"></script>
<script src="assets/admin/general/js/scripts/login.js" type="text/javascript"></script>
<!--end::Page Common Scripts -->
</body>
<!-- end::Body -->
</html>
