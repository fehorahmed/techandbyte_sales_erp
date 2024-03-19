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
                                                <strong>{{ $inventoryOrder->supplier->name ?? '' }}</strong>
                                                <br> {{ $inventoryOrder->supplier->address ?? '' }} <br> Phone:
                                                {{ $inventoryOrder->supplier->phone ?? '' }} <br> Email:
                                                {{ $inventoryOrder->supplier->email }}
                                            </address>
                                        </div>
                                        <div class="col-sm-4 invoice-col"> To <address>
                                                <strong>{{ config('app.name') }}</strong>
                                                <br> <b>Purchase Date :</b> {{ $inventoryOrder->purchase_date }} <br>
                                            </address>
                                        </div>
                                        <div class="col-sm-4 invoice-col">
                                            <br>
                                            <b>Order ID :</b> {{ $inventoryOrder->chalan_no }} <br>
                                            <b>LC no ID :</b> {{ $inventoryOrder->lc_no }} <br>
                                            <b>Payment Type :</b>
                                            {{ $inventoryOrder->payment_type == 1 ? 'CASH' : ($inventoryOrder->payment_type == 2 ? 'BANK' : '') }}
                                            <br>
                                            @if ($inventoryOrder->payment_type == 2)
                                                <b>Bank :</b> {{ $inventoryOrder->bank->bank_name ?? '' }} <br>
                                                <b>Account Name :</b> {{ $inventoryOrder->bank->ac_name ?? '' }} <br>
                                                <b>Account No :</b> {{ $inventoryOrder->bank->ac_number ?? '' }} <br>
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
                                                        <th>Purchase Rate</th>
                                                        <th>Selling Rate</th>
                                                        <th>Total Amount</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @if ($inventoryOrder->products)
                                                        @php
                                                            $subTotal = 0;
                                                        @endphp
                                                        @foreach ($inventoryOrder->products as $product)
                                                            <tr>
                                                                <td>{{ $loop->iteration }}</td>
                                                                <td>{{ $product->product->product_name ?? '' }}</td>
                                                                <td>{{ $product->quantity }}</td>
                                                                <td>{{ $product->rate }}</td>
                                                                <td>{{ $product->selling_rate }}</td>
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
                                        <div class="col-7"></div>
                                        <div class="col-5 mt-3">
                                            <div class="table-responsive">
                                                <table class="table">
                                                    <tbody>
                                                        <tr>
                                                            <th style="width:50%">Total:</th>
                                                            <td>৳{{ number_format($subTotal, 2) }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Duty Amount</th>
                                                            <td>৳{{ number_format($inventoryOrder->duty, 2) }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Freight Amount</th>
                                                            <td>৳{{ number_format($inventoryOrder->freight, 2) }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>C&F Amount</th>
                                                            <td>৳{{ number_format($inventoryOrder->c_and_f, 2) }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>AIT Total</th>
                                                            <td>৳{{ number_format($inventoryOrder->ait, 2) }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>AT Amount</th>
                                                            <td>৳{{ number_format($inventoryOrder->at, 2) }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>ETC Amount</th>
                                                            <td>৳{{ number_format($inventoryOrder->etc, 2) }}</td>
                                                        </tr>

                                                        <tr>
                                                            <th>Total Amount</th>
                                                            <td>৳{{ number_format($inventoryOrder->grand_total_amount, 2) }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th>Previous Paid</th>
                                                            <td>৳{{ number_format($inventoryOrder->previous_paid, 2) }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th>Paid</th>
                                                            <td>৳{{ number_format($inventoryOrder->paid_amount, 2) }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Due</th>
                                                            <td>৳{{ number_format($inventoryOrder->due_amount, 2) }}</td>
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
