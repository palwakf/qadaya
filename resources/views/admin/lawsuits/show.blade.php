@extends('admin.layout.master')

@section('title')
    تفاصيل دعوى قضائية
@stop

@section('css')
<style>
th{
    text-align: center;
    background-color: #ECE9E7;
}
td{
    text-align: center;
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
                    <a href="{{ route('lawsuits.show', ['kind' => $kind ,'id' => $info->id]) }}" class="kt-subheader__breadcrumbs-link">
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
                    تفاصيل دعوى قضائية
                </h3>
            </div>
            @if(auth()->user()->can('logs.show'))
                <div class="kt-portlet__head-toolbar">
                    <div class="kt-portlet__head-wrapper">
                        <div class="kt-portlet__head-actions">
                            <a href="{{ route('lawsuits.logs', ['id' => $history_id]) }}" class="btn btn-brand btn-elevate btn-icon-sm">
                                السجل القضائي
                            </a>
                        </div>
                    </div>
                </div>
            @endif
        </div>
        <div class="kt-portlet__body">
            <!--begin: Datatable -->
            <table class="table table-bordered">
                <tr>
                    <th>رقم الدعوى</th>
                    <th>المدعي</th>
                    <th>المدعى عليه</th>
                </tr>
                <tr>
                    <td>{{$info->lawsuit_number}}</td>
                    <td>{{$info->claimant}}</td>
                    <td>{{$info->defendant}}</td>
                </tr>
                <tr>
                    <th>نوع الدعوى</th>
                    <th>المحكمة</th>
                    <th>الموظف المسؤول</th>
                </tr>
                <tr>
                    <td>{{$info->type_name}}</td>
                    <td>{{$info->court_name}}</td>
                    <td>{{$info->employee_name}}</td>
                </tr>
                <tr>
                    <th>تاريخ الايداع</th>
                    <th>قيمة الايداع</th>
                    <th>العملة</th>
                </tr>
                <tr>
                    <td>{!! $info->deposit_date ?? '<span class="text-danger">غير مدخل</span>' !!}</td>
                    <td>{!! $info->deposit_value ?? '<span class="text-danger">غير مدخل</span>' !!}</td>
                    <td>{!! $info->currency_name ?? '<span class="text-danger">غير مدخل</span>' !!}</td>
                </tr>
                <tr>
                    <th colspan="3">الملاحظات</th>
                </tr>
                <tr>
                    <td colspan="3">{!!  $info->details ?? '<span class="text-danger">غير مدخل</span>' !!}</td>
                </tr>
            </table>


            <!--end: Datatable -->
        </div>
    </div>
    <!-- end:: Content -->
@stop

@section('js')
{{--    <script src="assets/admin/general/js/scripts/lawsuits.js" type="text/javascript"></script>--}}
@stop
