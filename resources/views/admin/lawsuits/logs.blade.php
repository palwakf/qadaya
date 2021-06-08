@extends('admin.layout.master')

@section('title')
    تفاصيل الدعوى القضائية
@stop

@section('css')
<style>
.not-allowed{
    cursor: not-allowed !important;
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
                    <a href="{{ route('lawsuits.view') }}" class="kt-subheader__breadcrumbs-link">
                        الدعاوى القضائية
                    </a>
                    <span class="kt-subheader__breadcrumbs-separator"></span>
                    <a href="{{ route('lawsuits.show', ['parent',$info->id]) }}" class="kt-subheader__breadcrumbs-link">
                        تفاصيل دعوى قضائية
                    </a>
                </div>
            </div>
        </div>
    </div>
@stop

@section('content')
    <!-- begin:: Content -->
    <div class="kt-portlet kt-portlet--mobile">
        <div class="kt-portlet__head kt-portlet__head--lg">
            <div class="kt-portlet__head-label">
                <h3 class="kt-portlet__head-title">
                    تفاصيل دعوى قضائية - درجات التقاضي
                </h3>
            </div>
            @if(auth()->user()->can('logs.add') && $info->is_archived == 0)
                <div class="kt-portlet__head-toolbar">
                    <div class="kt-portlet__head-wrapper">
                        <div class="kt-portlet__head-actions">
                            <a href="{{ route('logs.add', ['id' => $info->id]) }}" title="تحويل القضية" class="btn btn-brand btn-elevate btn-icon-sm">
                                إضافة درجة تقاضي
                            </a>
                        </div>
                    </div>
                </div>
            @else
                <div class="kt-portlet__head-toolbar">
                    <div class="kt-portlet__head-wrapper">
                        <div class="kt-portlet__head-actions">
                            <a href="javascript:void(0)" disabled title="لا يمكن اضافة درجة تقاضي على قضية مؤرشفة" class="btn btn-brand btn-elevate btn-icon-sm  not-allowed">
                                مؤرشفة !
                            </a>
                        </div>
                    </div>
                </div>
            @endif
        </div>
        <div class="kt-portlet__body">
            <!--begin: Datatable -->
            <table class="table table-striped- table-bordered table-hover" id="logs_table">
                <thead>
                <tr>
                    <th>#</th>
                    <th>رقم الدعوى</th>
                    <th>المدعي</th>
                    <th>المدعى عليه</th>
                    <th>نوع الدعوى</th>
                    <th>المحكمة</th>
                    <th>الملاحظات</th>
                    <th>أدوات</th>
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
    <script src="assets/admin/general/js/scripts/lawsuits.js" type="text/javascript"></script>
@stop
