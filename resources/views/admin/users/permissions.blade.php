@extends('admin.layout.master')

@section('title')
    صلاحيات المستخدمين
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
                        المستخدمين
                    </a>
                    <span class="kt-subheader__breadcrumbs-separator"></span>
                    <a href="{{ route('roles.add') }}" class="kt-subheader__breadcrumbs-link">
                        صلاحيات المستخدمين
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
                            صلاحيات المستخدم : {{ $info->name }}
                        </h3>
                    </div>
                </div>
                <!--begin::Form-->
                <form role="form" method="post" id="frmPermissions" action="" class="form-horizontal">
                    <div class="kt-portlet__body">
                        <div class="row">
                            @foreach($permissions as $row)
                                <div class="col-md-12">
                                    <h3 class="font-blue form-section">{{ $row->title }}</h3>
                                    <div class="icheck-list form-group">
                                        <label class="col-md-3">
                                            <input id="permissions[]" name="permissions[]" type="checkbox"
                                                   {{ in_array($row->id,array_column ($role_permissions,'permission_id')) ? 'checked' : '' }}
                                                   value="{{ $row->name }}" class="icheck" data-checkbox="icheckbox_flat-blue">
                                            {{ $row->title }}
                                        </label>
                                        @foreach($row->children as $item)
                                            <label class="col-md-3">
                                                <input id="permissions[]" name="permissions[]" type="checkbox"
                                                       {{ in_array($item->id,array_column ($role_permissions,'permission_id')) ? 'checked' : '' }}
                                                       value="{{ $item->name }}" class="icheck" data-checkbox="icheckbox_flat-blue">
                                                {{ $item->title }}
                                            </label>
                                        @endforeach
                                    </div>
                                    <hr>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="kt-portlet__foot">
                        <div class="kt-form__actions">
                            <div class="row">
                                <div class="col-lg-6 kt-align-right">
                                    <button type="submit" class="btn btn-brand save">حفظ</button>
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
