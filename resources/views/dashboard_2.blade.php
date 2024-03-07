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
                                <h4 class="text-c-yellow f-w-600">$30200</h4>
                                <h6 class="text-muted m-b-0">All Earnings</h6>
                            </div>
                            <div class="col-4 text-right">
                                <i class="feather icon-bar-chart f-28"></i>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-c-yellow">
                        <div class="row align-items-center">
                            <div class="col-9">
                                <p class="text-white m-b-0">% change</p>
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
                                <h4 class="text-c-green f-w-600">290+</h4>
                                <h6 class="text-muted m-b-0">Page Views</h6>
                            </div>
                            <div class="col-4 text-right">
                                <i class="feather icon-file-text f-28"></i>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-c-green">
                        <div class="row align-items-center">
                            <div class="col-9">
                                <p class="text-white m-b-0">% change</p>
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
                                <h4 class="text-c-pink f-w-600">145</h4>
                                <h6 class="text-muted m-b-0">Task Completed</h6>
                            </div>
                            <div class="col-4 text-right">
                                <i class="feather icon-calendar f-28"></i>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-c-pink">
                        <div class="row align-items-center">
                            <div class="col-9">
                                <p class="text-white m-b-0">% change</p>
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
                                <h4 class="text-c-blue f-w-600">500</h4>
                                <h6 class="text-muted m-b-0">Downloads</h6>
                            </div>
                            <div class="col-4 text-right">
                                <i class="feather icon-download f-28"></i>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-c-blue">
                        <div class="row align-items-center">
                            <div class="col-9">
                                <p class="text-white m-b-0">% change</p>
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
                        <div id="sale_info" style="height:300px"></div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5>New Users</h5>
                    </div>
                    <div class="card-block">
                        <canvas id="newuserchart" height="250"></canvas>
                    </div>
                    <div class="card-footer ">
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
                    </div>
                </div>
            </div>
            <div class="col-xl-5 col-md-12">
                <div class="card table-card">
                    <div class="card-header">
                        <h5>Global Sales by Top Locations</h5>
                    </div>
                    <div class="card-block">
                        <div class="table-responsive">
                            <table class="table table-hover table-borderless">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Country</th>
                                        <th>Sales</th>
                                        <th class="text-right">Average</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><img src="../files/assets/images/widget/GERMANY.jpg" alt
                                                class="img-fluid img-30"></td>
                                        <td>Germany</td>
                                        <td>3,562</td>
                                        <td class="text-right">56.23%</td>
                                    </tr>
                                    <tr>
                                        <td><img src="../files/assets/images/widget/USA.jpg" alt class="img-fluid img-30">
                                        </td>
                                        <td>USA</td>
                                        <td>2,650</td>
                                        <td class="text-right">25.23%</td>
                                    </tr>
                                    <tr>
                                        <td><img src="../files/assets/images/widget/AUSTRALIA.jpg" alt
                                                class="img-fluid img-30"></td>
                                        <td>Australia</td>
                                        <td>956</td>
                                        <td class="text-right">12.45%</td>
                                    </tr>
                                    <tr>
                                        <td><img src="../files/assets/images/widget/UK.jpg" alt class="img-fluid img-30">
                                        </td>
                                        <td>United Kingdom</td>
                                        <td>689</td>
                                        <td class="text-right">8.65%</td>
                                    </tr>
                                    <tr>
                                        <td><img src="../files/assets/images/widget/BRAZIL.jpg" alt
                                                class="img-fluid img-30"></td>
                                        <td>Brazil</td>
                                        <td>560</td>
                                        <td class="text-right">3.56%</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="text-right  m-r-20">
                            <a href="#!" class="b-b-primary text-primary">View all Sales
                                Locations </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-md-6">

            </div>





        </div>
    </div>
@endsection
