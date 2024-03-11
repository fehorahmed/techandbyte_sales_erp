@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')
    <div class="page-body">
        <div class="row">

            <div class="col-xl-3 col-md-6">
                <div class="card">
                    <div class="card-block">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h4 class="text-c-yellow f-w-600">৳ {{ $monthly_sale_info_query->t_amount ?? 0 }}</h4>
                                <h6 class="text-muted m-b-0">Monthly Total Sale</h6>
                            </div>
                            <div class="col-4 text-right">
                                <i class="feather icon-bar-chart f-28"></i>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-c-yellow">
                        <div class="row align-items-center">
                            <div class="col-9">
                                <p class="text-white m-b-0">Total Sale</p>
                            </div>
                            <div class="col-3 text-right">
                                <i class="feather icon-trending-up text-white f-16"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card">
                    <div class="card-block">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h4 class="text-c-green f-w-600">৳ {{ $monthly_sale_info_query->p_amount ?? 0 }}</h4>
                                <h6 class="text-muted m-b-0">Monthly Total Paid</h6>
                            </div>
                            <div class="col-4 text-right">
                                <i class="feather icon-file-text f-28"></i>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-c-green">
                        <div class="row align-items-center">
                            <div class="col-9">
                                <p class="text-white m-b-0">Paid</p>
                            </div>
                            <div class="col-3 text-right">
                                <i class="feather icon-trending-up text-white f-16"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card">
                    <div class="card-block">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h4 class="text-c-pink f-w-600">৳ {{ $monthly_sale_info_query->d_amount ?? 0 }}</h4>
                                <h6 class="text-muted m-b-0">Monthly Total Due</h6>
                            </div>
                            <div class="col-4 text-right">
                                <i class="ti-pulse f-28"></i>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-c-pink">
                        <div class="row align-items-center">
                            <div class="col-9">
                                <p class="text-white m-b-0">Due</p>
                            </div>
                            <div class="col-3 text-right">
                                <i class="feather icon-trending-up text-white f-16"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card">
                    <div class="card-block">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h4 class="text-c-blue f-w-600">৳ {{ $monthly_purchase_info_query->t_amount ?? 0 }}</h4>
                                <h6 class="text-muted m-b-0">Monthly Purchase</h6>
                            </div>
                            <div class="col-4 text-right">
                                <i class="ti-server f-28"></i>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-c-blue">
                        <div class="row align-items-center">
                            <div class="col-9">
                                <p class="text-white m-b-0">Purchase</p>
                            </div>
                            <div class="col-3 text-right">
                                <i class="feather icon-trending-up text-white f-16"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="col-xl-8 col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Sale Information</h5>
                        <span class="text-muted">Weekly sale information</span>
                        <div class="card-header-right">
                            <ul class="list-unstyled card-option">
                                <li><i class="feather icon-maximize full-card"></i></li>
                                <li><i class="feather icon-minus minimize-card"></i>
                                </li>
                                <li><i class="feather icon-trash-2 close-card"></i></li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-block">
                        <div id="visitor" style="height:300px"></div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Today Sale Information</h5>
                    </div>
                    <div class="card-block">
                        <canvas id="newuserchart" height="250"></canvas>
                    </div>
                    {{-- <div class="card-footer ">
                        <div class="row text-center b-t-default">
                            <div class="col-4 b-r-default m-t-15">
                                <h5>85%</h5>
                                <p class="text-muted m-b-0">Satisfied</p>
                            </div>
                            <div class="col-4 b-r-default m-t-15">
                                <h5>6%</h5>
                                <p class="text-muted m-b-0">Unsatisfied</p>
                            </div>
                            <div class="col-4 m-t-15">
                                <h5>9%</h5>
                                <p class="text-muted m-b-0">NA</p>
                            </div>
                        </div>
                    </div> --}}
                </div>
            </div>
            <div class="col-xl-6 col-md-12">
                <div class="card table-card">
                    <div class="card-header">
                        <h5>Today Sales List</h5>
                    </div>
                    <div class="card-block">
                        <div class="table-responsive">
                            <table class="table table-hover table-borderless">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Invoice</th>
                                        <th>Amount</th>
                                        <th>Paid</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($today_sales as $sale_item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $sale_item->invoice }}</td>
                                            <td>{{ $sale_item->total_amount }}</td>
                                            <td>{{ $sale_item->paid_amount }}</td>

                                            <td><a target="_blank"
                                                    href="{{ route('sale.sale_receipt_details', ['invoice' => $sale_item->id]) }}"
                                                    class="btn btn-primary btn-sm"> View </a> </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="text-right  m-r-20">
                            <a href="{{ route('sale.sale_receipt_all') }}" class="b-b-primary text-primary">View all Sales
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-6 col-md-12">
                <div class="card table-card">
                    <div class="card-header">
                        <h5>Today Purchese List</h5>
                    </div>
                    <div class="card-block">
                        <div class="table-responsive">
                            <table class="table table-hover table-borderless">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Invoice</th>
                                        <th>Amount</th>
                                        <th>Paid</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($today_purcheses as $purchese_item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $purchese_item->chalan_no }}</td>
                                            <td>{{ $purchese_item->grand_total_amount }}</td>
                                            <td>{{ $purchese_item->paid_amount }}</td>

                                            <td><a target="_blank"
                                                    href="{{ route('purchase.purchase_receipt_details', ['productPurchase' => $purchese_item->id]) }}"
                                                    class="btn btn-primary btn-sm"> View </a> </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="text-right  m-r-20">
                            <a href="{{ route('purchase.purchase_receipt_all') }}" class="b-b-primary text-primary">View
                                all
                                Purchases
                            </a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

@section('script')


    <script>
        "use strict";
        $(document).ready(function() {
            function e(e, t, a) {
                return null == a && (a = "rgba(0,0,0,0)"), {
                    labels: ["1", "2", "3", "4", "5", "6", "7", "8", "9", "10", "11", "12", "13", "14", "15"],
                    datasets: [{
                        label: "",
                        borderColor: e,
                        borderWidth: 2,
                        hitRadius: 30,
                        pointRadius: 3,
                        pointHoverRadius: 4,
                        pointBorderWidth: 5,
                        pointHoverBorderWidth: 12,
                        pointBackgroundColor: Chart.helpers.color("#000000").alpha(0).rgbString(),
                        pointBorderColor: e,
                        pointHoverBackgroundColor: e,
                        pointHoverBorderColor: Chart.helpers.color("#000000").alpha(.1).rgbString(),
                        fill: !0,
                        lineTension: 0,
                        backgroundColor: a,
                        data: t
                    }]
                }
            }

            function t() {
                return {
                    title: {
                        display: !1
                    },
                    tooltips: {
                        position: "nearest",
                        mode: "index",
                        intersect: !1,
                        yPadding: 10,
                        xPadding: 10
                    },
                    legend: {
                        display: !1,
                        labels: {
                            usePointStyle: !1
                        }
                    },
                    responsive: !0,
                    maintainAspectRatio: !0,
                    hover: {
                        mode: "index"
                    },
                    scales: {
                        xAxes: [{
                            display: !1,
                            gridLines: !1,
                            scaleLabel: {
                                display: !0,
                                labelString: "Month"
                            }
                        }],
                        yAxes: [{
                            display: !1,
                            gridLines: !1,
                            scaleLabel: {
                                display: !0,
                                labelString: "Value"
                            },
                            ticks: {
                                beginAtZero: !0
                            }
                        }]
                    },
                    elements: {
                        point: {
                            radius: 4,
                            borderWidth: 12
                        }
                    },
                    layout: {
                        padding: {
                            left: 10,
                            right: 10,
                            top: 25,
                            bottom: 25
                        }
                    }
                }
            }
            var a = (AmCharts.makeChart("visitor", {
                type: "serial",
                hideCredits: !0,
                theme: "light",
                dataDateFormat: "YYYY-MM-DD",
                precision: 2,
                valueAxes: [{
                    id: "v1",
                    title: "Weekly Sales",
                    position: "left",
                    autoGridCount: !1,
                    labelFunction: function(e) {
                        return "৳" + Math.round(e)
                    }
                }, {
                    id: "v2",
                    title: "New Visitors",
                    gridAlpha: 0,
                    position: "right",
                    autoGridCount: !1
                }],
                graphs: [{
                    id: "g3",
                    valueAxis: "v1",
                    lineColor: "#feb798",
                    fillColors: "#feb798",
                    fillAlphas: 1,
                    type: "column",
                    title: "Total Sale",
                    valueField: "t_amount",
                    clustered: !1,
                    columnWidth: .5,
                    legendValueText: "৳[[value]]",
                    balloonText: "[[title]]<br /><b style='font-size: 130%'>৳[[value]]</b>"
                }, {
                    id: "g4",
                    valueAxis: "v1",
                    lineColor: "#fe9365",
                    fillColors: "#fe9365",
                    fillAlphas: 1,
                    type: "column",
                    title: "Total Due",
                    valueField: "p_amount",
                    clustered: !1,
                    columnWidth: .3,
                    legendValueText: "৳[[value]]",
                    balloonText: "[[title]]<br /><b style='font-size: 130%'>৳[[value]]</b>"
                }],
                chartCursor: {
                    pan: !0,
                    valueLineEnabled: !0,
                    valueLineBalloonEnabled: !0,
                    cursorAlpha: 0,
                    valueLineAlpha: .2
                },
                categoryField: "date",
                categoryAxis: {
                    parseDates: !0,
                    dashLength: 1,
                    minorGridEnabled: !0
                },
                legend: {
                    useGraphSettings: !0,
                    position: "top"
                },
                balloon: {
                    borderThickness: 1,
                    cornerRadius: 5,
                    shadowAlpha: 0
                },
                // {!! $weekly_sale_info !!}
                //  dataProvider: [
                //         @foreach ($weekly_sale_info as $item)
                //             {
                //                 date: "{{ $item->date }}",
                //                 t_amount: {{ $item->t_amount }},
                //                 p_amount: {{ $item->p_amount }},
                //             },
                //         @endforeach
                //     ],
                dataProvider: [{
                    date: "2013-01-16",
                    p_amount: 71,
                    t_amount: 75,

                }, {
                    date: "2013-01-17",
                    p_amount: 74,
                    t_amount: 78,

                }, {
                    date: "2013-01-18",
                    p_amount: 78,
                    t_amount: 88,

                }, {
                    date: "2013-01-19",
                    p_amount: 85,
                    t_amount: 89,

                }, {
                    date: "2013-01-20",
                    p_amount: 82,
                    t_amount: 89,

                }, {
                    date: "2013-01-21",
                    p_amount: 83,
                    t_amount: 85,

                }, {
                    date: "2013-01-22",
                    p_amount: 88,
                    t_amount: 92,

                }]
            }), AmCharts.makeChart("proj-earning", {
                type: "serial",
                hideCredits: !0,
                theme: "light",
                dataProvider: [{
                    type: "UI",
                    visits: 10
                }, {
                    type: "UX",
                    visits: 15
                }, {
                    type: "Web",
                    visits: 12
                }, {
                    type: "App",
                    visits: 16
                }, {
                    type: "SEO",
                    visits: 8
                }],
                valueAxes: [{
                    gridAlpha: .3,
                    gridColor: "#fff",
                    axisColor: "transparent",
                    color: "#fff",
                    dashLength: 0
                }],
                gridAboveGraphs: !0,
                startDuration: 1,
                graphs: [{
                    balloonText: "Active User: <b>[[value]]</b>",
                    fillAlphas: 1,
                    lineAlpha: 1,
                    lineColor: "#fff",
                    type: "column",
                    valueField: "visits",
                    columnWidth: .5
                }],
                chartCursor: {
                    categoryBalloonEnabled: !1,
                    cursorAlpha: 0,
                    zoomable: !1
                },
                categoryField: "type",
                categoryAxis: {
                    gridPosition: "start",
                    gridAlpha: 0,
                    axesAlpha: 0,
                    lineAlpha: 0,
                    fontSize: 12,
                    color: "#fff",
                    tickLength: 0
                },
                export: {
                    enabled: !1
                }
            }), document.getElementById("newuserchart").getContext("2d"));
            window.myDoughnut = new Chart(a, {
                type: "doughnut",
                data: {
                    datasets: [{
                        data: [{{ isset($daily_sale_info_query[0])?$daily_sale_info_query[0]->t_amount:0 }},
                            {{ isset($daily_sale_info_query[0])?$daily_sale_info_query[0]->p_amount:0 }},
                            {{ isset($daily_sale_info_query[0])?$daily_sale_info_query[0]->d_amount:0 }}
                        ],
                        backgroundColor: ["#fe9365", "#01a9ac", "#fe5d70"],
                        label: "Dataset 1"
                    }],
                    labels: ["Total Sale", "Paid", "Due"]
                },
                options: {
                    maintainAspectRatio: !1,
                    responsive: !0,
                    legend: {
                        position: "bottom"
                    },
                    title: {
                        display: !0,
                        text: ""
                    },
                    animation: {
                        animateScale: !0,
                        animateRotate: !0
                    }
                }
            });
            var a = document.getElementById("sale-chart1").getContext("2d"),
                a = (new Chart(a, {
                    type: "line",
                    data: e("#b71c1c", [25, 30, 15, 20, 25, 30, 15, 25, 35, 30, 20, 10, 12, 1],
                        "transparent"),
                    options: t()
                }), document.getElementById("sale-chart2").getContext("2d")),
                a = (new Chart(a, {
                    type: "line",
                    data: e("#00692c", [30, 15, 25, 35, 30, 20, 25, 30, 15, 20, 25, 10, 12, 1],
                        "transparent"),
                    options: t()
                }), document.getElementById("sale-chart3").getContext("2d"));
            new Chart(a, {
                type: "line",
                data: e("#096567", [15, 20, 25, 10, 30, 15, 25, 35, 30, 20, 25, 30, 12, 1], "transparent"),
                options: t()
            })
        });
    </script>


    <script type="text/javascript" src="{{ asset('themes/backend/files/assets/js/script.js') }}"></script>
@endsection
