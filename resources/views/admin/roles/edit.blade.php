@extends('admin.layout.master')

@section('title')
    تعديل مجموعة
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
                    <a href="{{ route('dashboard.view') }}" class="kt-subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
                    <span class="kt-subheader__breadcrumbs-separator"></span>
                    <a href="{{ route('dashboard.view') }}" class="kt-subheader__breadcrumbs-link">
                        الرئيسية
                    </a>
                    <span class="kt-subheader__breadcrumbs-separator"></span>
                    <a href="{{ route('roles.view') }}" class="kt-subheader__breadcrumbs-link">
                        المجموعات
                    </a>
                    <span class="kt-subheader__breadcrumbs-separator"></span>
                    <a href="{{ route('roles.edit', ['id' => $info->id_hash]) }}" class="kt-subheader__breadcrumbs-link">
                        تعديل مجموعة
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
                            تعديل مجموعة
                        </h3>
                    </div>
                </div>
                <!--begin::Form-->
                <form class="kt-form kt-form--label-right" id="frmEdit" method="post" action="{{ route('roles.edit', ['id' => $info->id_hash]) }}">
                    <div class="kt-portlet__body">
                        <div class="form-group row">
                            <div class="col-lg-6">
                                <label class="">اسم المجموعة:</label>
                                <input type="text" class="form-control" name="name" value="{{ $info->name }}" placeholder="اسم المجموعة">
                            </div>
                            <div class="col-lg-6">
                                <label class="">الحالة:</label>
                                <select class="form-control kt-selectpicker" name="status" data-live-search="true">
                                    <option value="1" {{ $info->status == 1 ? "selected" : "" }}>فعال</option>
                                    <option value="0" {{ $info->status == 0 ? "selected" : "" }}>معطل</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="kt-portlet__foot">
                        <div class="kt-form__actions">
                            <div class="row">
                                <div class="col-lg-6 kt-align-right">
                                    <button type="submit" class="btn btn-brand save">حفظ التغييرات</button>
                                    <a href="{{ route('roles.view') }}" class="btn btn-secondary">الغاء</a>
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
    <script src="assets/admin/general/js/scripts/roles.js" type="text/javascript"></script>
@stop
