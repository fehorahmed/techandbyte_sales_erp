@extends('layouts.app')
@section('title', 'Transaction Add')
@section('content')
    <div class="page-body">

    <div class="container">
        <div>
            <div class="card">
                <div class="card-block">
                    <div class="col-sm-12 invoice-btn-group text-right">
                        <button type="button" class="btn btn-primary btn-print-invoice m-b-10 btn-sm waves-effect waves-light m-r-20">Print</button>
                    </div>
                    <div class="col-sm-12 invoice-btn-group text-right">
                        <h2 class="text-center mb-5">Receipt</h2>
                    </div>
                    <div class="row invoive-info">
                        <div class="col-md-6 col-sm-6">
                            <h6>Payment Information :</h6>
                            <table class="table table-responsive invoice-table invoice-order table-borderless">
                                <tbody>
                                <tr>
                                    <th>Date :  &nbsp;</th>
                                    <td> {{ date('d-M-Y', strtotime($transaction->date))}}</td>
                                </tr>
                                <tr>
                                    <th>Payment From :  &nbsp;</th>
                                    <td> {{$transaction->subHeadType->name ?? ''}}</td>
                                </tr>
                                <tr>
                                    <th>Paid By : &nbsp;</th>
                                    <td>
                                       {{$transaction->transaction_method == 1 ? 'Cash' : 'Bank'}}
                                    </td>
                                </tr>
                                <tr>
                                    <th>Note : &nbsp;</th>
                                    <td>
                                       {{$transaction->note ?? ''}}
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <h6 class="m-b-20">Receipt Number
                                <span>#{{$transaction->receipt_no ?? ''}}</span></h6>
                            <h6 class="text-uppercase text-primary">Total Amount :
                                <span>৳{{number_format($transaction->amount,2)}}</span>
                            </h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    </div>
@endsection

