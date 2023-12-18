@extends('layouts.app')
@section('title','Dashboard')
@section('content')
<div class="page-body">
    <div class="page-header">
        <div class="row align-items-end">
            <div class="col-lg-8">
                <div class="page-header-title">
                    <div class="d-inline">
                        <h4>@yield('title')</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-3 col-md-6">
            <div class="card bg-c-yellow update-card">
                <div class="card-block">
                    <div class="row align-items-end">
                        <div class="col-8">
                            <h4 class="text-white">$30200</h4>
                            <h6 class="text-white m-b-0">All Earnings</h6>
                        </div>
                        <div class="col-4 text-right"><div class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div>
                            <canvas id="update-chart-1" height="50" style="display: block; width: 45px; height: 50px;" width="45" class="chartjs-render-monitor"></canvas>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <p class="text-white m-b-0"><i class="feather icon-clock text-white f-14 m-r-10"></i>update
                        : 2:15 am</p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-c-green update-card">
                <div class="card-block">
                    <div class="row align-items-end">
                        <div class="col-8">
                            <h4 class="text-white">290+</h4>
                            <h6 class="text-white m-b-0">Page Views</h6>
                        </div>
                        <div class="col-4 text-right"><div class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div>
                            <canvas id="update-chart-2" height="50" width="45" style="display: block; width: 45px; height: 50px;" class="chartjs-render-monitor"></canvas>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <p class="text-white m-b-0"><i class="feather icon-clock text-white f-14 m-r-10"></i>update
                        : 2:15 am</p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-c-pink update-card">
                <div class="card-block">
                    <div class="row align-items-end">
                        <div class="col-8">
                            <h4 class="text-white">145</h4>
                            <h6 class="text-white m-b-0">Task Completed</h6>
                        </div>
                        <div class="col-4 text-right"><div class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div>
                            <canvas id="update-chart-3" height="50" width="45" style="display: block; width: 45px; height: 50px;" class="chartjs-render-monitor"></canvas>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <p class="text-white m-b-0"><i class="feather icon-clock text-white f-14 m-r-10"></i>update
                        : 2:15 am</p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-c-lite-green update-card">
                <div class="card-block">
                    <div class="row align-items-end">
                        <div class="col-8">
                            <h4 class="text-white">500</h4>
                            <h6 class="text-white m-b-0">Downloads</h6>
                        </div>
                        <div class="col-4 text-right"><div class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div>
                            <canvas id="update-chart-4" height="50" width="45" style="display: block; width: 45px; height: 50px;" class="chartjs-render-monitor"></canvas>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <p class="text-white m-b-0"><i class="feather icon-clock text-white f-14 m-r-10"></i>update
                        : 2:15 am</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
