@extends('admin.layout.master')

@section('title')
    إضافة مستخدم
@stop

@section('css')

@stop

@section('subheader')
    <div class="kt-subheader   kt-grid__item" id="kt_subheader">
        <div class="kt-container  kt-container--fluid ">
            <div class="kt-subheader__main">
                <h3 class="kt-subheader__title">
                    وزارة الأوقاف والشؤون الدينية </h3>
                <span class="kt-subheader__separator kt-hidden"></span>
                <div class="kt-subheader__breadcrumbs">
                    <a href="{{ route('dashboard.view') }}" class="kt-subheader__breadcrumbs-home"><i
                            class="flaticon2-shelter"></i></a>
                    <span class="kt-subheader__breadcrumbs-separator"></span>
                    <a href="{{ route('dashboard.view') }}" class="kt-subheader__breadcrumbs-link">
                        الرئيسية
                    </a>
                    <span class="kt-subheader__breadcrumbs-separator"></span>
                    <a href="{{ route('users.view') }}" class="kt-subheader__breadcrumbs-link">
                        المستخدمين
                    </a>
                    <span class="kt-subheader__breadcrumbs-separator"></span>
                    <a href="{{ route('users.add') }}" class="kt-subheader__breadcrumbs-link">
                        إضافة مستخدم
                    </a>
                </div>
            </div>
        </div>
    </div>
@stop

@section('content')
    <!-- begin:: Content -->
    <div class="row">
        <div class="col-lg-12">
            <!--begin::Portlet-->
            <div class="kt-portlet">
                <div class="kt-portlet__head">
                    <div class="kt-portlet__head-label">
                        <h3 class="kt-portlet__head-title">
                            إضافة مستخدم
                        </h3>
                    </div>
                </div>
                <!--begin::Form-->
                <form class="kt-form kt-form--label-right" id="frmAdd" method="post"
                      action="{{ route('users.add') }}">
                    <div class="kt-portlet__body">
                        <div class="form-group row">
                            <div class="col-lg-6">
                                <label>اسم المستخدم:</label>
                                <input type="text" class="form-control" name="username" value="{{ old('username') }}"
                                       placeholder="اسم المستخدم">
                            </div>
                            <div class="col-lg-6">
                                <label class="">الاسم الكامل:</label>
                                <input type="text" class="form-control" name="name" value="{{ old('name') }}"
                                       placeholder="الاسم الكامل">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-6">
                                <label>كلمة المرور:</label>
                                <input type="password" class="form-control" autocomplete="new-password" name="password"
                                       placeholder="كلمة المرور">
                            </div>
                            <div class="col-lg-6">
                                <label class="">تأكيد كلمة المرور:</label>
                                <input type="password" class="form-control" name="password_confirmation"
                                       placeholder="تأكيد كلمة المرور">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-6">
                                <label>البريد الإلكتروني:</label>
                                <input type="email" class="form-control" name="email" value="{{ old('email') }}"
                                       placeholder="البريد الإلكتروني">
                            </div>
                            <div class="col-lg-6">
                                <label class="">الصلاحية:</label>
                                <select class="form-control kt-selectpicker" name="roles[]" data-live-search="true" multiple>
                                    @foreach($roles as $role)
                                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-6">
                                <label class="">الحالة:</label>
                                <select class="form-control kt-selectpicker" name="status" data-live-search="true">
                                    <option value="1">فعال</option>
                                    <option value="0">معطل</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="kt-portlet__foot">
                        <div class="kt-form__actions">
                            <div class="row">
                                <div class="col-lg-6 kt-align-right">
                                    <button type="submit" class="btn btn-brand save">حفظ</button>
                                    <a href="{{ route('users.view') }}" class="btn btn-secondary">الغاء</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <!--end::Form-->
            </div>
            <!--end::Portlet-->
        </div>
    </div>
    <!-- End:: Content -->
@stop

@section('js')
    <script src="assets/admin/general/js/scripts/users.js" type="text/javascript"></script>
@stop
