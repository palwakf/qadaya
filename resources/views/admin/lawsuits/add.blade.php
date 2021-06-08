@extends('admin.layout.master')

@section('title')
    إضافة دعوى قضائية
@stop
@section('css')
    <style>
    .margin-top-9{
        margin-top: 9px;
    }
    .margin-left-10{
        margin-left: 10px;
    }
    .red-star{
        color: red;
        font-size:initial;
    }
    </style>
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
                    <a href="{{ route('lawsuits.view') }}" class="kt-subheader__breadcrumbs-link">
                        الدعاوى القضائية
                    </a>
                    <span class="kt-subheader__breadcrumbs-separator"></span>
                    <a href="{{ route('lawsuits.add') }}" class="kt-subheader__breadcrumbs-link">
                        إضافة دعوى قضائية
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
                            إضافة دعوى قضائية
                        </h3>
                    </div>
                </div>
                <!--begin::Form-->
                <form class="kt-form kt-form--label-right" id="frmAdd" method="post" action="{{ route('lawsuits.add') }}">
                    <div class="kt-portlet__body">
                        <div class="form-group row">
                            <div class="col-lg-4">
                                <label class="">رقم الدعوى:</label> <span class="red-star">*</span>
                                <input type="text" class="form-control" name="lawsuit_number" value="{{ old('lawsuit_number') }}" placeholder="رقم الدعوى">
                            </div>
                            <div class="col-lg-4">
                                <label class="">المدعي:</label> <span class="red-star">*</span>
                                <input type="text" class="form-control" name="claimant" value="{{ old('claimant') }}" placeholder="المدعي">
                            </div>
                            <div class="col-lg-4">
                                <label class="">المدعى عليه:</label> <span class="red-star">*</span>
                                <input type="text" class="form-control" name="defendant" value="{{ old('defendant') }}" placeholder="المدعى عليه">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-4">
                                <label class="">نوع الدعوة:</label> <span class="red-star">*</span>
                                <select class="form-control select2" name="type_id">
                                    <option disabled selected>اختر نوع الدعوة القضائية</option>
                                    @foreach($types as $type)
                                        <option value="{{$type->id}}" {{ old('type_id') == $type->id ? ' selected' : ''  }}>{{$type->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-4">
                                <label class="">المحكمة:</label> <span class="red-star">*</span>
                                <select class="form-control select2" name="court_id">
                                    <option disabled selected>اختر المحكمة</option>
                                    @foreach($courts as $court)
                                        <option value="{{$court->id}}" {{ old('court_id') == $court->id ? ' selected' : ''  }}>{{$court->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-4">
                                <label class="">الموظف المسؤول:</label> <span class="red-star">*</span>
                                @if(auth()->user()->hasRole('Admin'))
                                <select class="form-control select2" name="user_id" >
                                    <option disabled selected>اختر الموظف المسؤول عن القضية</option>
                                    @foreach($employees as $employee)
                                        <option value="{{$employee->id}}" {{ old('user_id') == $employee->id ? ' selected' : ''  }}>{{$employee->name}}</option>
                                    @endforeach
                                </select>
                                @else
                                    <input type="text" class="form-control" value="{{ auth()->user()->name }}" disabled placeholder="{{ auth()->user()->name }}">
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-4">
                                <label class="">تاريخ الايداع:</label>
                                <input type="text" class="form-control date" name="deposit_date" value="{{ old('deposit_date') }}" placeholder="تاريخ الايداع">
                            </div>
                            <div class="col-lg-4">
                                <label class="">قيمة الايداع</label>
                                <input type="number" class="form-control" name="deposit_value" value="{{ old('deposit_value') }}" placeholder="قيمة الايداع">
                            </div>
                            <div class="col-lg-4">
                                <label class="currency_label">العملة:</label>
                                <div class="margin-top-9">
                                    <input type="radio" class="kt-radio-btn" name="deposit_currency" value="jod" id="jod"> <label for="jod" class="margin-left-10">دينار أردني </label>
                                    <input type="radio" class="kt-radio-btn" name="deposit_currency" value="usd" id="usd"> <label for="usd" class="margin-left-10">دولار أمريكي </label>
                                    <input type="radio" class="kt-radio-btn" name="deposit_currency" value="ils" id="ils"> <label for="ils" class="margin-left-10">شيكل </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-12">
                                <label class="">الملاحظات:</label>
                                <textarea id="summernote" class="form-control summernote" name="details"  placeholder="الملاحظات">{{ old('details') }}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="kt-portlet__foot">
                        <div class="kt-form__actions">
                            <div class="row">
                                <div class="col-lg-6 kt-align-right">
                                    <button type="submit" class="btn btn-brand save">حفظ</button>
                                    <a href="{{ route('lawsuits.view') }}" class="btn btn-secondary">الغاء</a>
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
    <script src="assets/admin/js/pages/crud/forms/widgets/select2.js"></script>
    <script src="assets/admin/js/pages/crud/forms/editors/summernote.js"></script>
    <script src="assets/admin/general/js/scripts/lawsuits.js" type="text/javascript"></script>
    <script>
        $(document).ready(function() {
            $('.select2').select2();
            $('#summernote').summernote();
        });
    </script>
@stop
