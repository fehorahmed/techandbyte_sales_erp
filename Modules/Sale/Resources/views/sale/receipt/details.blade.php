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
                                                <strong>{{ $invoice->customer->name ?? '' }}</strong>
                                                <br> 795 Folsom Ave, Suite 600 <br> San Francisco, CA 94107 <br> Phone:
                                                (804) 123-5432 <br> Email: info@almasaeedstudio.com
                                            </address>
                                        </div>
                                        <div class="col-sm-4 invoice-col"> To <address>
                                                <strong>{{ config('app.name') }}</strong>
                                                <br> 795 Folsom Ave, Suite 600 <br> San Francisco, CA 94107 <br> Phone:
                                                (555) 539-1037 <br> Email: john.doe@example.com
                                            </address>
                                        </div>
                                        <div class="col-sm-4 invoice-col">
                                            <b>Invoice #007612</b>
                                            <br>
                                            <br>
                                            <b>Order ID:</b> 4F3S8J <br>
                                            <b>Payment Due:</b> 2/22/2014 <br>
                                            <b>Account:</b> 968-34567
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
                                                        {{-- <th>Discount%</th>
                                                    <th>Dis. Value</th>
                                                    <th>Vat %</th>
                                                    <th>VAT Value</th> --}}
                                                        <th>Total Amount</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @if ($invoice->products)
                                                        @php
                                                            $subTotal = 0;
                                                        @endphp
                                                        @foreach ($invoice->products as $product)
                                                            <tr>
                                                                <td>{{ $loop->iteration }}</td>
                                                                <td>{{ $product->product->product_name ?? '' }}</td>
                                                                <td>{{ $product->quantity }}</td>
                                                                <td>{{ $product->rate }}</td>
                                                                {{-- <td>{{ $product->discount_per }}</td>
                                                                <td>{{ $product->discount }}</td>
                                                                <td>{{ $product->vat_amnt_per }}</td>
                                                                <td>{{ $product->vat_amnt }}</td> --}}
                                                                <td>{{ $product->total_price }}</td>
                                                            </tr>
                                                            @php
                                                                $subTotal += $product->total_price;
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
                                                            <th>Total Vat</th>
                                                            <td>৳{{ number_format($invoice->total_vat_amnt, 2) }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Sale Discount</th>
                                                            <td>৳{{ number_format($invoice->total_discount, 2) }}</td>
                                                        </tr>
                                                        {{-- <tr>
                                                            <th>Total Discount</th>
                                                            <td>৳{{ number_format($invoice->total_discount + $invoice->invoice_discount, 2) }}
                                                            </td>
                                                        </tr> --}}
                                                        <tr>
                                                            <th>Grand Total</th>
                                                            <td>৳{{ number_format($invoice->total_amount, 2) }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Paid Amount</th>
                                                            <td>৳{{ number_format($invoice->paid_amount, 2) }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Due Amount</th>
                                                            <td>৳{{ number_format($invoice->due_amount, 2) }}</td>
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
