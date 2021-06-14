@extends('admin.layout.master')

@section('title')
    الرئيسية
@stop

@section('css')

@stop

@section('subheader')

@stop


@section('content')
    <div class="row">
        <div class="col-lg-12 col-xl-4 order-lg-1 order-xl-1">

            <!--begin:: Widgets/Activity-->
            <div class="kt-portlet kt-portlet--fit kt-portlet--head-lg kt-portlet--head-overlay kt-portlet--skin-solid kt-portlet--height-fluid">
                <div class="kt-widget17" style="position: inherit;">
                    <div class="kt-widget17__stats" style="display: contents;">
                        <div class="kt-widget17__items">
                            <div class="kt-widget17__item">
                                <span class="kt-widget17__icon">
                                    <i class="fa fa-users  text-danger"></i>
                                </span>
                                <span class="kt-widget17__subtitle">
                                    المستخدمين
                                </span>
                                <span class="kt-widget17__desc">
                                    {{{$users}}} مستخدم نشط
                                </span>
                            </div>
                            <div class="kt-widget17__item">
								<span class="kt-widget17__icon">
                                    <i class="fa fa-key  text-warning"></i>
                                </span>
                                <span class="kt-widget17__subtitle">
                                    الصلاحيات
                                </span>
                                <span class="kt-widget17__desc">
                                    {{$roles}} رتبة
                                </span>
                            </div>
                            <div class="kt-widget17__item">
								<span class="kt-widget17__icon">
                                    <i class="fa fa-home  text-success"></i>
                                </span>
                                <span class="kt-widget17__subtitle">
                                    المحاكم
                                </span>
                                <span class="kt-widget17__desc">
                                    {{$courts}}   محكمة معتمدة
                                </span>
                            </div>
                            <div class="kt-widget17__item">
								<span class="kt-widget17__icon">
                                    <i class="fa fa-layer-group  text-info"></i>
                                </span>
                                <span class="kt-widget17__subtitle">
                                    أنواع الدعاوى القضائية
                                </span>
                                <span class="kt-widget17__desc">
                                    {{$types}}  نوع
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!--end:: Widgets/Activity-->
        </div>
    </div>
    <div class="row">
        <div class="col-xl-6 col-lg-6">

            <!--begin:: Widgets/Profit Share-->
            <div class="kt-portlet kt-portlet--height-fluid">
                <div class="kt-widget14">
                    <div class="kt-widget14__header">
                        <h3 class="kt-widget14__title">
                            الدعاوي القانونية
                        </h3>
                        <span class="kt-widget14__desc">
                            نسب الدعاوي القانونية من حيث الفعالية
                        </span>
                    </div>
                    <div class="kt-widget14__content">
                        <div class="kt-widget14__chart">
                            <div class="chartjs-size-monitor">
                                <div class="chartjs-size-monitor-expand">
                                    <div class=""></div>
                                </div>
                                <div class="chartjs-size-monitor-shrink">
                                    <div class=""></div>
                                </div>
                            </div>
                            <div class="kt-widget14__stat">{{$all_lawsuits}}</div>
                            <canvas id="kt_chart_lawsuit_status" style="height: 140px; width: 140px; display: block;" width="140" height="140" class="chartjs-render-monitor"></canvas>
                        </div>
                        <div class="kt-widget14__legends">
                            <div class="kt-widget14__legend">
                                <span class="kt-widget14__bullet kt-bg-success"></span>
                                <span class="kt-widget14__stats">{{$active_lawsuits_percentage}}% قضايا نشطة</span>
                            </div>
                            <div class="kt-widget14__legend">
                                <span class="kt-widget14__bullet kt-bg-brand"></span>
                                <span class="kt-widget14__stats">{{$archived_lawsuits_percentage}}% قضايا مؤرشفة</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!--end:: Widgets/Profit Share-->
        </div>
        <div class="col-xl-6 col-lg-6">
            <div class="kt-portlet kt-portlet--height-fluid">
                <div class="kt-portlet__head">
                    <div class="kt-portlet__head-label">
                        <h3 class="kt-portlet__head-title">
                            توزيع الدعاوي القانونية على الموظفين
                        </h3>
                    </div>
                </div>
                <div class="kt-portlet__body">
                    <div class="kt-widget16">
                        <div class="kt-widget16__items">
                            <div class="kt-widget16__item">
                                <span class="kt-widget16__sceduled">
                                    الموظف
                                </span>
                                <span class="kt-widget16__amount">
                                    عدد الدعاوي
                                </span>
                            </div>
                            @foreach($lawyers as $lawyer)
                            <div class="kt-widget16__item">
                                <span class="kt-widget16__date">
                                    {{$lawyer['name']}}
                                </span>
                                <span class="kt-widget16__price {{($lawyer['count'] > 0) ? 'kt-font-success' : 'kt-font-brand'}} ">
                                    {{$lawyer['count']}}
                                </span>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row row-no-padding row-col-separator-xl">
        <div class="col-xl-4">

            <!--begin:: Widgets/Daily Sales-->
            <div class="kt-portlet kt-portlet--height-fluid">
                <div class="kt-widget14">
                    <div class="kt-widget14__header kt-margin-b-30">
                        <h3 class="kt-widget14__title">
                            الدعاوي القانونية
                        </h3>
                        <span class="kt-widget14__desc">
                            نسب الدعاوي القانونية من حيث المحكمة
						</span>
                    </div>
                    <div class="kt-widget14__chart" style="height:120px;"><div class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div>
                        <canvas id="kt_chart_court_lawsuits" style="display: block; width: 984px; height: 120px;" width="984" height="120" class="chartjs-render-monitor"></canvas>
                    </div>
                </div>
            </div>

            <!--end:: Widgets/Daily Sales-->
        </div>
        <div class="col-xl-4">
            <div class="kt-portlet kt-portlet--height-fluid">
                <div class="kt-portlet__head">
                    <div class="kt-portlet__head-label">
                        <h3 class="kt-portlet__head-title">
                            الدعاوي القانونية من حيث النوع
                        </h3>
                    </div>
                </div>
                <div class="kt-portlet__body">
                    <div class="kt-widget16">
                        <div class="kt-widget16__items">
                            <div class="kt-widget16__item">
                                <span class="kt-widget16__sceduled">
                                    نوع الدعوى
                                </span>
                                <span class="kt-widget16__amount">
                                    العدد
                                </span>
                            </div>
                            @foreach($items as $item)
                            <div class="kt-widget16__item">
                                <span class="kt-widget16__date">
                                    {{$item['name']}}
                                </span>
                                <span class="kt-widget16__price  kt-font-brand">
                                    {{$item['count']}}
                                </span>
                            </div>
                            @endforeach
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('js')
<script>
    // Class definition
    var KTCharts = function() {
        // Lawsuit Status Chart.
        var LawsuitStatus = function() {
            if (!KTUtil.getByID('kt_chart_lawsuit_status')) {
                return;
            }
            var randomScalingFactor = function() {
                return Math.round(Math.random() * 100);
            };

            var config = {
                type: 'doughnut',
                data: {
                    datasets: [{
                        data: [
                            {{$active_lawsuits}}, {{$archived_lawsuits}}
                        ],
                        backgroundColor: [
                            KTApp.getStateColor('success'),
                            KTApp.getStateColor('danger')
                        ]
                    }],
                    labels: [
                        'قضايا نشطة',
                        'قضايا مؤرشفة',
                    ]
                },
                options: {
                    cutoutPercentage: 75,
                    responsive: true,
                    maintainAspectRatio: false,
                    legend: {
                        display: false,
                        position: 'top',
                    },
                    title: {
                        display: false,
                        text: 'Technology'
                    },
                    animation: {
                        animateScale: true,
                        animateRotate: true
                    },
                    tooltips: {
                        enabled: true,
                        intersect: false,
                        mode: 'nearest',
                        bodySpacing: 5,
                        yPadding: 10,
                        xPadding: 10,
                        caretPadding: 0,
                        displayColors: false,
                        backgroundColor: KTApp.getStateColor('brand'),
                        titleFontColor: '#ffffff',
                        cornerRadius: 4,
                        footerSpacing: 0,
                        titleSpacing: 0
                    }
                }
            };

            var ctx = KTUtil.getByID('kt_chart_lawsuit_status').getContext('2d');
            var myDoughnut = new Chart(ctx, config);
        }
        // Court Lawsuits
        var CourtLawsuits = function() {
            var chartContainer = KTUtil.getByID('kt_chart_court_lawsuits');

            if (!chartContainer) {
                return;
            }

            var chartData = {
                labels: [
                    @foreach ($court_labels as $label)
                        "{{ $label }}",
                    @endforeach
                ],
                datasets: [{
                    //label: 'Dataset 1',
                    backgroundColor: KTApp.getStateColor('success'),
                    data: {{ json_encode($court_lawsuits,TRUE)}}
                }, {
                    //label: 'Dataset 2',
                    backgroundColor: '#f3f3fb',
                    data: {{ json_encode($court_lawsuits,TRUE)}}
                }]
            };

            var chart = new Chart(chartContainer, {
                type: 'bar',
                data: chartData,
                options: {
                    title: {
                        display: false,
                    },
                    tooltips: {
                        intersect: false,
                        mode: 'nearest',
                        xPadding: 10,
                        yPadding: 10,
                        caretPadding: 10
                    },
                    legend: {
                        display: false
                    },
                    responsive: true,
                    maintainAspectRatio: false,
                    barRadius: 4,
                    scales: {
                        xAxes: [{
                            display: false,
                            gridLines: false,
                            stacked: true
                        }],
                        yAxes: [{
                            display: false,
                            stacked: true,
                            gridLines: false
                        }]
                    },
                    layout: {
                        padding: {
                            left: 0,
                            right: 0,
                            top: 0,
                            bottom: 0
                        }
                    }
                }
            });
        }

        return {
            // Init demos
            init: function() {
                // init charts
                LawsuitStatus();
                CourtLawsuits();
            }
        };
    }();

    // Class initialization on page load
    jQuery(document).ready(function() {
        KTCharts.init();
    });
</script>


@stop
