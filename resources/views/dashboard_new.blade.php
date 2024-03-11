@extends('layouts.app')
@section('title','Dashboard')
@section('style')
    <style>
        .pcoded-main-container {
            background: #ffffff;
        }
        .item_box{
            background-color: #c00000;
            padding: 10px 0;
            border: 1px solid #000;
            /*margin-left: -20px;*/
        }
        .margin_left_item{
            margin-left: -70px;
        }
        .margin_bottom_zero{
            margin-bottom: 0px;
        }
    </style>
@endsection
@section('content')
<div class="page-body">
{{--    <div class="page-header">--}}
{{--        <div class="row align-items-end">--}}
{{--            <div class="col-lg-8">--}}
{{--                <div class="page-header-title">--}}
{{--                    <div class="d-inline">--}}
{{--                        <h4>@yield('title')</h4>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}

    <div class="row">
        <div class="col-xl-7 col-md-6">
            <img width="100%" src="{{ asset('themes/backend/files/assets/images/motorcycle.jpg') }}">
        </div>
        <div class="col-xl-5 col-md-6">
            <div class="card" style="box-shadow: none">
                <div class="card-block">
                    <div class="row align-items-end margin_left_item">
                        <div class="col-6 offset-3 text-center item_box">
                            <h6 class="text-white margin_bottom_zero"><strong>Today's Sale:</strong></h6>
                            <h5 class="text-white m-b-0"><strong>{{$today_sales}}</strong></h5>
                        </div>
                    </div>
                    <div class="row align-items-end margin_left_item">
                        <div class="col-5 text-center item_box">
                            <h6 class="text-white margin_bottom_zero"><strong>Today's Expense:</strong></h6>
                            <h5 class="text-white m-b-0"><strong>{{$today_expense}}</strong></h5>
                        </div>
                        <div class="col-5 offset-2 text-center item_box">
                            <h6 class="text-white margin_bottom_zero"><strong>Total Stock Value</strong></h6>
                            <h5 class="text-white m-b-0"><strong>{{$today_stock_value??0}}</strong></h5>
                        </div>
                    </div>
                    <div class="row align-items-end mb-4 margin_left_item">
                        <div class="col-6 offset-3 text-center item_box">
                            <h6 class="text-white margin_bottom_zero"><strong>Cash In Hand</strong></h6>
                            <h5 class="text-white m-b-0"><strong>{{$cash_in_hand->amount??0}}</strong></h5>
                        </div>
                    </div>
                    <div class="row align-items-end mb-4 margin_left_item">
                        <div class="col-6 offset-3 text-center item_box">
                            <h6 class="text-white margin_bottom_zero"><strong>DATA</strong></h6>
                            <h5 class="text-white m-b-0"><strong>100,000</strong></h5>
                        </div>
                    </div>
                    <div class="row align-items-end margin_left_item">
                        <div class="col-6 offset-3 text-center item_box">
                            <h6 class="text-white margin_bottom_zero"><strong>DATA</strong></h6>
                            <h5 class="text-white m-b-0"><strong>100,000</strong></h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
