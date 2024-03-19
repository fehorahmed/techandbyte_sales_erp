@extends('layouts.app')
@section('title', 'Invoice')
@section('content')
    <div class="page-body">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header table-card-header">
                        <div class="d-inline" style="float: left">
                            <h4>@yield('title')</h4>
                        </div>
                        <h5 style="float: right"><a onclick="getprint('printarea')" class="btn btn-success">Print</a></h5>
                    </div>
                    <div class="card-block mt-4">
                        <div class="row" id="printarea">
                            <div class="col-12 text-center mt-5">
                                <h2>{{ config('app.name') }}</h2>
                            </div>
                            <div class="col-12">
                                <div class="invoice p-3 mb-3">
                                    <div class="row invoice-info">
                                        <div class="col-sm-4 invoice-col"> From <address>
                                                <strong>{{ $productPurchase->supplier->name ?? '' }}</strong>
                                                <br> {{ $productPurchase->supplier->address ?? '' }} <br> Phone:
                                                {{ $productPurchase->supplier->phone ?? '' }} <br> Email:
                                                {{ $productPurchase->supplier->email }}
                                            </address>
                                        </div>
                                        <div class="col-sm-4 invoice-col"> To <address>
                                                <strong>{{ config('app.name') }}</strong> <br>
                                                <b>Purchase Date :</b> {{ $productPurchase->purchase_date }} <br>
                                            </address>
                                        </div>
                                        <div class="col-sm-4 invoice-col">
                                            <br>
                                            <b>Order ID :</b> {{ $productPurchase->chalan_no }} <br>
                                            <b>LC no ID :</b> {{ $productPurchase->lc_no }} <br>
                                            <b>Payment Type :</b>
                                            {{ $productPurchase->payment_type == 1 ? 'CASH' : 'BANK' }} <br>
                                            @if ($productPurchase->payment_type == 2)
                                                <b>Bank :</b> {{ $productPurchase->bank->bank_name ?? '' }} <br>
                                                <b>Account Name :</b> {{ $productPurchase->bank->ac_name ?? '' }} <br>
                                                <b>Account No :</b> {{ $productPurchase->bank->ac_number ?? '' }} <br>
                                            @endif

                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-12 table-responsive">
                                            <table class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>SL.</th>
                                                        <th>Product Name</th>
                                                        <th>Qty</th>
                                                        <th>Rate</th>
                                                        <th>Total Amount</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @if ($productPurchase->products)
                                                        @php
                                                            $subTotal = 0;
                                                        @endphp
                                                        @foreach ($productPurchase->products as $product)
                                                            <tr>
                                                                <td>{{ $loop->iteration }}</td>
                                                                <td>{{ $product->product->product_name ?? '' }}</td>
                                                                <td>{{ $product->quantity }}</td>
                                                                <td>{{ $product->rate }}</td>
                                                                <td>{{ $product->total_amount }}</td>
                                                            </tr>
                                                            @php
                                                                $subTotal += $product->total_amount;
                                                            @endphp
                                                        @endforeach

                                                    @endif

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                        </div>
                                        <div class="col-6 mt-3">
                                            <div class="table-responsive">
                                                <table class="table">
                                                    <tbody>
                                                        <tr>
                                                            <th style="width:50%">Total:</th>
                                                            <td>৳{{ number_format($subTotal, 2) }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Duty Amount</th>
                                                            <td>৳{{ number_format($productPurchase->duty, 2) }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Freight Amount</th>
                                                            <td>৳{{ number_format($productPurchase->freight, 2) }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>C&F Amount</th>
                                                            <td>৳{{ number_format($productPurchase->c_and_f, 2) }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>AIT Total</th>
                                                            <td>৳{{ number_format($productPurchase->ait, 2) }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>AT Amount</th>
                                                            <td>৳{{ number_format($productPurchase->at, 2) }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>ETC Amount</th>
                                                            <td>৳{{ number_format($productPurchase->etc, 2) }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Total Amount</th>
                                                            <td>৳{{ number_format($productPurchase->grand_total_amount, 2) }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th>Total Paid</th>
                                                            <td>৳{{ number_format($productPurchase->paid_amount, 2) }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Due</th>
                                                            <td>৳{{ number_format($productPurchase->due_amount, 2) }}</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        var APP_URL = '{!! url()->full() !!}';

        function getprint(prinarea) {
            // $('#heading_area').show();
            $('body').html($('#' + prinarea).html());
            window.print();
            window.location.replace(APP_URL)
        }
    </script>
@endsection
