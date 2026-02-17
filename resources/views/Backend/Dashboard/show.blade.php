@extends('Backend._layout._main')
@section('toolbar')

    Anno:
    <select name="anno" id="anno" data-control="select2" data-hide-search="true"
            class="form-select form-select-sm fw-bolder w-200px">
        @for($n=$annoCorrente;$n>=intval(config('configurazione.primoAnno'));$n--)
            <option value="{{$n}}" @selected($n==$anno)>{{$n}}</option>
        @endfor
    </select>
    <a href="{{action([\App\Http\Controllers\Backend\DashboardController::class,'show'],['esporta'=>$anno])}}" class="btn btn-sm btn-primary" style="white-space: nowrap;">Esporta {{$anno}}</a>


@endsection
@section('content')
    <div class="row">
        <div class="col">
            <div class="card card-dashed flex-center min-w-150px my-4 p-6 mt-0">
                                <span class="fs-4 fw-bold  pb-1 px-2">
                                    Orologi
                                </span>
                <span class="fs-lg-2tx fw-bold d-flex justify-content-center">
                                    <span data-kt-countup="true" data-kt-countup-value="34" class="counted"
                                          data-kt-initialized="1">{{$statOrologi['orologi']}}</span>
                                </span>
            </div>
        </div>
        <div class="col">
            <div class="card card-dashed flex-center min-w-150px my-3 p-6 mt-0">
                                <span class="fs-4 fw-bold  pb-1 px-2">
                                    In Carico
                                </span>
                <span class="fs-lg-2tx fw-bold d-flex justify-content-center">
                                    <span data-kt-countup="true" data-kt-countup-value="34" class="counted"
                                          data-kt-initialized="1">{{$statOrologi['orologi']-$statOrologi['venduti']}}</span>
                                </span>
            </div>
        </div>
        <div class="col">
            <div class="card card-dashed flex-center min-w-150px my-3 p-6 mt-0">
                                <span class="fs-4 fw-bold  pb-1 px-2">
                                    Venduti
                                </span>
                <span class="fs-lg-2tx fw-bold d-flex justify-content-center">
                                    <span data-kt-countup="true" data-kt-countup-value="34" class="counted"
                                          data-kt-initialized="1">{{$statOrologi['venduti']}}</span>
                                </span>
            </div>
        </div>
    </div>
    <div class="row ">
        <!--begin::Col-->
        <div class="col-xl-12">
            <!--begin::Chart Widget 1-->
            <div class="card card-flush h-lg-100">
                <!--begin::Header-->
                <div class="card-header pt-5">
                    <!--begin::Title-->
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label fw-bold text-dark">Uscite {{$graficoUscite['anno']}}</span>
                    </h3>
                    <!--end::Title-->
                    <!--begin::Toolbar-->
                    <div class="card-toolbar">

                    </div>
                    <!--end::Toolbar-->
                </div>
                <!--end::Header-->
                <!--begin::Body-->
                <div class="card-body pt-0 px-0">
                    <!--begin::Chart-->
                    <div id="kt_charts_uscite" class="min-h-auto ps-4 pe-6 mb-3" style="height: 350px"></div>
                    <!--end::Chart-->
                </div>
                <!--end::Body-->
            </div>
            <!--end::Chart Widget 1-->
        </div>
    </div>
    <div class="row  mt-3">
        <!--begin::Col-->
        <div class="col-xl-12">
            <!--begin::Chart Widget 1-->
            <div class="card card-flush h-lg-100">
                <!--begin::Header-->
                <div class="card-header pt-5">
                    <!--begin::Title-->
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label fw-bold text-dark">Entrate {{$graficoEntrate['anno']}}</span>
                    </h3>
                    <!--end::Title-->
                    <!--begin::Toolbar-->
                    <div class="card-toolbar">

                    </div>
                    <!--end::Toolbar-->
                </div>
                <!--end::Header-->
                <!--begin::Body-->
                <div class="card-body pt-0 px-0">
                    <!--begin::Chart-->
                    <div id="kt_charts_entrate" class="min-h-auto ps-4 pe-6 mb-3" style="height: 350px"></div>
                    <!--end::Chart-->
                </div>
                <!--end::Body-->
            </div>
            <!--end::Chart Widget 1-->
        </div>
    </div>
    <div class="row  mt-3">
        <!--begin::Col-->
        <div class="col-xl-12">
            <!--begin::Chart Widget 1-->
            <div class="card card-flush h-lg-100">
                <!--begin::Header-->
                <div class="card-header pt-5">
                    <!--begin::Title-->
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label fw-bold text-dark">Utile {{$graficoUtile['anno']}}</span>
                    </h3>
                    <!--end::Title-->
                    <!--begin::Toolbar-->
                    <div class="card-toolbar">

                    </div>
                    <!--end::Toolbar-->
                </div>
                <!--end::Header-->
                <!--begin::Body-->
                <div class="card-body pt-0 px-0">
                    <!--begin::Chart-->
                    <div id="kt_charts_utile" class="min-h-auto ps-4 pe-6 mb-3" style="height: 350px"></div>
                    <!--end::Chart-->
                </div>
                <!--end::Body-->
            </div>
            <!--end::Chart Widget 1-->
        </div>
    </div>
    <div class="row mt-3">
        <div class="col">
            <div class="card card-dashed flex-center min-w-150px my-4 p-6 mt-0">
                                <span class="fs-4 fw-bold  pb-1 px-2">
                                    Totale Uscite {{$annoCorrente}}
                                </span>
                <span class="fs-lg-2tx fw-bold d-flex justify-content-center">
                                    <span data-kt-countup="true" data-kt-countup-value="34" class="counted"
                                          data-kt-initialized="1">{{\App\importo(array_sum($graficoUscite['arrDati']['prezzo_di_acquisto']))}}</span>
                                </span>
            </div>
        </div>
        <div class="col">
            <div class="card card-dashed flex-center min-w-150px my-3 p-6 mt-0">
                                <span class="fs-4 fw-bold  pb-1 px-2">
                                    Totale Entrate {{$annoCorrente}}
                                </span>
                <span class="fs-lg-2tx fw-bold d-flex justify-content-center">
                                    <span data-kt-countup="true" data-kt-countup-value="34" class="counted"
                                          data-kt-initialized="1">{{\App\importo(array_sum($graficoEntrate['arrDati']['prezzo_di_vendita']))}}</span>
                                </span>
            </div>
        </div>
        <div class="col">
            <div class="card card-dashed flex-center min-w-150px my-3 p-6 mt-0">
                                <span class="fs-4 fw-bold  pb-1 px-2">
                                    Totale Utile {{$annoCorrente}}
                                </span>
                <span class="fs-lg-2tx fw-bold d-flex justify-content-center">
                                    <span data-kt-countup="true" data-kt-countup-value="34" class="counted"
                                          data-kt-initialized="1">{{\App\importo(array_sum($graficoUtile['arrDati']['utile']))}}</span>
                                </span>
            </div>
        </div>
    </div>
@endsection
@push('customCss')
@endpush
@push('customScript')
    <script src="/assets_backend/js-miei/numeral.min.js"></script>
    <script src="/assets_backend/js-miei/numeralIt.min.js"></script>
    <script>
        $(function () {
            numeral.locale('it');
            $('#anno').on('select2:select', function (e) {
                location.href = location.pathname + '?anno=' + $(this).val();
            });
            var graficoUscite =@json($graficoUscite);
            var graficoEntrate =@json($graficoEntrate);
            var graficoUtile =@json($graficoUtile);

            var KTChartsUscite = function () {
                var e = {self: null, rendered: !1}, t = function () {
                    var t = document.getElementById("kt_charts_uscite");
                    if (t) {
                        var a = t.hasAttribute("data-kt-negative-color") ? t.getAttribute("data-kt-negative-color") : KTUtil.getCssVariableValue("--kt-danger"),
                            l = parseInt(KTUtil.css(t, "height")), r = KTUtil.getCssVariableValue("--kt-gray-500"),
                            o = KTUtil.getCssVariableValue("--kt-border-dashed-color"),
                            i = {
                                series: [{
                                    name: "Contratti",
                                    data: graficoUscite['arrDati']['prezzo_di_acquisto']
                                }],
                                chart: {
                                    fontFamily: "inherit",
                                    type: "bar",
                                    stacked: !0,
                                    height: l,
                                    toolbar: {show: !1}
                                },
                                plotOptions: {bar: {columnWidth: "35%", barHeight: "70%", borderRadius: [6, 6]}},
                                legend: {show: !1},
                                dataLabels: {enabled: !1},
                                xaxis: {
                                    categories: graficoUscite['arrDati']['labels'],
                                    axisBorder: {show: !1},
                                    axisTicks: {show: !1},
                                    tickAmount: 10,
                                    labels: {style: {colors: [r], fontSize: "12px"}},
                                    crosshairs: {show: !1}
                                },
                                yaxis: {
                                    //min: -50,
                                    //max: 80,
                                    tickAmount: 6, labels: {
                                        style: {colors: [r], fontSize: "12px"}, formatter: function (e) {
                                            return new Intl.NumberFormat('it-IT', {
                                                minimumFractionDigits: 0,
                                                maximumFractionDigits: 0,
                                            }).format(e);
                                        }
                                    }
                                },
                                fill: {opacity: 1},
                                states: {
                                    normal: {filter: {type: "none", value: 0}},
                                    hover: {filter: {type: "none", value: 0}},
                                    active: {allowMultipleDataPointsSelection: !1, filter: {type: "none", value: 0}}
                                },
                                tooltip: {
                                    style: {fontSize: "12px", borderRadius: 4}, y: {
                                        formatter: function (e) {
                                            return new Intl.NumberFormat('it-IT', {
                                                minimumFractionDigits: 0,
                                                maximumFractionDigits: 0,
                                            }).format(e)
                                        }
                                    }
                                },
                                colors: ['#f1416c'],
                                grid: {borderColor: o, strokeDashArray: 4, yaxis: {lines: {show: !0}}}
                            };
                        e.self = new ApexCharts(t, i), setTimeout((function () {
                            e.self.render(), e.rendered = !0
                        }), 200)
                    }
                };
                return {
                    init: function () {
                        t();
                    }
                }
            }();
            KTChartsUscite.init();
            var KTChartsEntrate = function () {
                var e = {self: null, rendered: !1}, t = function () {
                    var t = document.getElementById("kt_charts_entrate");
                    if (t) {
                        var a = t.hasAttribute("data-kt-negative-color") ? t.getAttribute("data-kt-negative-color") : KTUtil.getCssVariableValue("--kt-danger"),
                            l = parseInt(KTUtil.css(t, "height")), r = KTUtil.getCssVariableValue("--kt-gray-500"),
                            o = KTUtil.getCssVariableValue("--kt-border-dashed-color"),
                            i = {
                                series: [{
                                    name: "Contratti",
                                    data: graficoEntrate['arrDati']['prezzo_di_vendita']
                                }],
                                chart: {
                                    fontFamily: "inherit",
                                    type: "bar",
                                    stacked: !0,
                                    height: l,
                                    toolbar: {show: !1}
                                },
                                plotOptions: {bar: {columnWidth: "35%", barHeight: "70%", borderRadius: [6, 6]}},
                                legend: {show: !1},
                                dataLabels: {enabled: !1},
                                xaxis: {
                                    categories: graficoEntrate['arrDati']['labels'],
                                    axisBorder: {show: !1},
                                    axisTicks: {show: !1},
                                    tickAmount: 10,
                                    labels: {style: {colors: [r], fontSize: "12px"}},
                                    crosshairs: {show: !1}
                                },
                                yaxis: {
                                    //min: -50,
                                    //max: 80,
                                    tickAmount: 6, labels: {
                                        style: {colors: [r], fontSize: "12px"}, formatter: function (e) {
                                            return new Intl.NumberFormat('it-IT', {
                                                minimumFractionDigits: 0,
                                                maximumFractionDigits: 0,
                                            }).format(e);
                                        }
                                    }
                                },
                                fill: {opacity: 1},
                                states: {
                                    normal: {filter: {type: "none", value: 0}},
                                    hover: {filter: {type: "none", value: 0}},
                                    active: {allowMultipleDataPointsSelection: !1, filter: {type: "none", value: 0}}
                                },
                                tooltip: {
                                    style: {fontSize: "12px", borderRadius: 4}, y: {
                                        formatter: function (e) {
                                            return new Intl.NumberFormat('it-IT', {
                                                minimumFractionDigits: 0,
                                                maximumFractionDigits: 0,
                                            }).format(e)
                                        }
                                    }
                                },
                                colors: ['#50cd89', a],
                                grid: {borderColor: o, strokeDashArray: 4, yaxis: {lines: {show: !0}}}
                            };
                        e.self = new ApexCharts(t, i), setTimeout((function () {
                            e.self.render(), e.rendered = !0
                        }), 200)
                    }
                };
                return {
                    init: function () {
                        t();
                    }
                }
            }();
            KTChartsEntrate.init();
            var KTChartsUtile = function () {
                var e = {self: null, rendered: !1}, t = function () {
                    var t = document.getElementById("kt_charts_utile");
                    if (t) {
                        var a = t.hasAttribute("data-kt-negative-color") ? t.getAttribute("data-kt-negative-color") : KTUtil.getCssVariableValue("--kt-danger"),
                            l = parseInt(KTUtil.css(t, "height")), r = KTUtil.getCssVariableValue("--kt-gray-500"),
                            o = KTUtil.getCssVariableValue("--kt-border-dashed-color"),
                            i = {
                                series: [{
                                    name: "Contratti",
                                    data: graficoUtile['arrDati']['utile']
                                }],
                                chart: {
                                    fontFamily: "inherit",
                                    type: "bar",
                                    stacked: !0,
                                    height: l,
                                    toolbar: {show: !1}
                                },
                                plotOptions: {bar: {columnWidth: "35%", barHeight: "70%", borderRadius: [6, 6]}},
                                legend: {show: !1},
                                dataLabels: {enabled: !1},
                                xaxis: {
                                    categories: graficoUtile['arrDati']['labels'],
                                    axisBorder: {show: !1},
                                    axisTicks: {show: !1},
                                    tickAmount: 10,
                                    labels: {style: {colors: [r], fontSize: "12px"}},
                                    crosshairs: {show: !1}
                                },
                                yaxis: {
                                    //min: -50,
                                    //max: 80,
                                    tickAmount: 6, labels: {
                                        style: {colors: [r], fontSize: "12px"}, formatter: function (e) {
                                            return new Intl.NumberFormat('it-IT', {
                                                minimumFractionDigits: 0,
                                                maximumFractionDigits: 0,
                                            }).format(e);
                                        }
                                    }
                                },
                                fill: {opacity: 1},
                                states: {
                                    normal: {filter: {type: "none", value: 0}},
                                    hover: {filter: {type: "none", value: 0}},
                                    active: {allowMultipleDataPointsSelection: !1, filter: {type: "none", value: 0}}
                                },
                                tooltip: {
                                    style: {fontSize: "12px", borderRadius: 4}, y: {
                                        formatter: function (e) {
                                            return new Intl.NumberFormat('it-IT', {
                                                minimumFractionDigits: 0,
                                                maximumFractionDigits: 0,
                                            }).format(e)
                                        }
                                    }
                                },
                                colors: ['#009ef7', a],
                                grid: {borderColor: o, strokeDashArray: 4, yaxis: {lines: {show: !0}}}
                            };
                        e.self = new ApexCharts(t, i), setTimeout((function () {
                            e.self.render(), e.rendered = !0
                        }), 200)
                    }
                };
                return {
                    init: function () {
                        t();
                    }
                }
            }();
            KTChartsUtile.init();

        });
    </script>
@endpush
