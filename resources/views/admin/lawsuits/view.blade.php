@extends('admin.layout.master')

@section('title')
    الدعاوى القضائية
@stop

@section('css')
<style>
.width-20-percent{
    width: 20% !important;
}
.font-inherit{
    font-family: inherit !important;
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
                        الرئيسية </a>
                    <span class="kt-subheader__breadcrumbs-separator"></span>
                    <a href="{{ route('types.index') }}" class="kt-subheader__breadcrumbs-link">
                        الدعاوى القضائية
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
                                البحث
                            </h3>
                        </div>
                    </div>
                    <!--begin::Form-->
                    <form class="kt-form kt-form--label-right">
                        <div class="kt-portlet__body">
                            <div class="form-group row">
                                <div class="col-lg-4">
                                    <label for="lawsuit_number">رقم الدعوى القضائية:</label>
                                    <input type="text" class="form-control searchable" id="lawsuit_number" name="lawsuit_number" placeholder="رقم الدعوى القضائية">
                                </div>
                                <div class="col-lg-4" >
                                    <label for="claimant">المدعى:</label>
                                    <input type="text" class="form-control searchable" id="claimant" name="claimant" placeholder="المدعى">
                                </div>
                                <div class="col-lg-4">
                                    <label for="defendant">المدعى عليه:</label>
                                    <input type="text" class="form-control searchable" id="defendant" name="defendant" placeholder="المدعى عليه">
                                </div>

                            </div>
                            <div class="form-group row">
                                <div class="col-lg-4" >
                                    <label for="is_archived">حالة الدعوى:</label>
                                    <select class="form-control kt-selectpicker searchable" id="is_archived" name="is_archived" data-live-search="true">
                                        <option value="">غير محدد</option>
                                        <option value="1">مؤرشفة</option>
                                        <option value="0">فعالة</option>
                                    </select>
                                </div>
                                <div class="col-lg-4" >
                                    <label for="type_id">نوع الدعوى:</label>
                                    <select class="form-control kt-selectpicker searchable select2" id="type_id" name="type_id" data-live-search="true">
                                        <option value="">غير محدد</option>
                                        @foreach($types as $type)
                                            <option value="{{$type->id}}">{{$type->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-lg-4" >
                                    <label for="court_id">المحكمة:</label>
                                    <select class="form-control kt-selectpicker searchable select2" id="court_id" name="court_id" data-live-search="true">
                                        <option value="">غير محدد</option>
                                        @foreach($courts as $court)
                                            <option value="{{$court->id}}">{{$court->name}}</option>
                                        @endforeach
                                    </select>
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

    <!-- begin:: Content -->
    <div class="kt-portlet kt-portlet--mobile">
        <div class="kt-portlet__head kt-portlet__head--lg">
            <div class="kt-portlet__head-label">
                <h3 class="kt-portlet__head-title">
                    إدارة الدعاوى القضائية
                </h3>
            </div>
            @can('lawsuits.add')
                <div class="kt-portlet__head-toolbar">
                    <div class="kt-portlet__head-wrapper">
                        <div class="kt-portlet__head-actions">
                            <a href="{{ route('lawsuits.add') }}" class="btn btn-brand btn-elevate btn-icon-sm">
                                إضافة جديد
                            </a>
                        </div>
                    </div>
                </div>
            @endcan
        </div>
        <div class="kt-portlet__body">
            <!--begin: Datatable -->
            <table class="table table-striped- table-bordered table-hover" id="lawsuits_table">
                <thead>
                <tr>
                    <th class="no-export">#</th>
                    <th>رقم الدعوى</th>
                    <th>المدعي</th>
                    <th>المدعى عليه</th>
                    <th>نوع الدعوى</th>
                    <th>المحكمة</th>
                    <th>الملاحظات</th>
                    <th class="no-export">حالة الدعوى</th>
                    <th class="width-20-percent no-export">أدوات</th>
                </tr>
                </thead>
                <tbody>
                </tbody>
            </table>

            <!--end: Datatable -->
        </div>
    </div>
    <!-- end:: Content -->
@stop

@section('js')
    <script src="assets/admin/js/pages/crud/forms/widgets/select2.js"></script>
    <script src="assets/admin/general/js/scripts/lawsuits.js" type="text/javascript"></script>
@stop
