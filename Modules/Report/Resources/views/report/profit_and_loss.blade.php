@extends('layouts.app')

@section('style')
    <!-- bootstrap datepicker -->
    <link rel="stylesheet" href="{{ asset('themes/backend/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
@endsection

@section('title')
    Profit & Loss
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header with-border">
                    <h3 class="card-title">Filter</h3>
                </div>
                <!-- /.box-header -->

                <div class="card-body">
                    <form action="{{ route('report.profit_and_loss') }}">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group row">
                                    <label>Start Date</label>

                                    <div class="input-group date">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <input type="text" class="form-control pull-right"
                                               id="start" name="start" value="{{ request()->get('start')??date('Y-m-d')  }}" autocomplete="off" required>
                                    </div>
                                    <!-- /.input group -->
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group row">
                                    <label>End Date</label>

                                    <div class="input-group date">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <input type="text" class="form-control pull-right"
                                               id="end" name="end" value="{{ request()->get('end')??date('Y-m-d')  }}" autocomplete="off" required>
                                    </div>
                                    <!-- /.input group -->
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group row">
                                    <label>	&nbsp;</label>

                                    <input class="btn btn-primary form-control" type="submit" value="Submit">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12" style="min-height:300px">
            @if($incomes)
                <section class="card">

                    <div class="card-body">
                        <button class="pull-right btn btn-primary" onclick="getprint('prinarea')">Print</button><br><hr>

                        <div class="adv-table" id="prinarea">
{{--                            <div class="row">--}}
{{--                                <div class="col-md-12">--}}
{{--                                    @if (Auth::user()->company_branch_id == 2)--}}
{{--                                        <img src="{{ asset('img/your_choice_plus.png') }}"style="margin-top: 10px; float:inherit">--}}
{{--                                    @else--}}
{{--                                        <img src="{{ asset('img/your_choice.png') }}"style="margin-top: 10px; float:inherit">--}}
{{--                                    @endif--}}
{{--                                </div>--}}
{{--                            </div>--}}
                            <h4>Loss & Profit Report</h4>
                            <div style="clear: both; width: 100% !important" class="table-responsive">
                            <table class="table table-bordered " style="margin-bottom: 0px;">
                                <tr>
                                    <th class="text-center">{{ date("F d, Y", strtotime(request()->get('start'))).' - '.date("F d, Y", strtotime(request()->get('end'))) }}</th>
                                </tr>
                                <table id="table" class="table table-bordered table-striped" style="width:50%; float:left">
                                    <tr>
                                        <th colspan="5" class="text-center">Debit</th>
                                    </tr>
                                    <tr>
                                        <th class="text-center">Date</th>
                                        <th class="text-center">Particular</th>
{{--                                        <th class="text-center">Note</th>--}}
                                        <th class="text-center">Payment Type</th>
                                        <th class="text-center">Bank Details</th>
                                        <th class="text-center">Amount</th>
                                    </tr>

                                    @foreach($incomes as $income)
                                        <tr>
                                            <td class="text-center">{{ $income->date->format('j F, Y') }}</td>
                                            <td>{{ $income->particular }}</td>
{{--                                            <td class="text-center">{{ $income->note }}</td>--}}
                                            <td class="text-center">
                                                @if($income->transaction_method == 1)
                                                    Cash
                                                @elseif($income->transaction_method == 2)
                                                    Bank
                                                @elseif($income->transaction_method == 3)
                                                    Mobile Banking
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                {{--                                                @if ($income->transaction_method == 2)--}}
                                                {{--                                                    {{ $income->bank->name??''.' - '.$income->account->account_no??'' }}--}}
                                                {{--                                                @endif--}}
                                            </td>
                                            <td class="text-center">৳ {{ number_format($income->amount),2 }}</td>
                                        </tr>
                                    @endforeach

                                    <?php
                                    $incomesCount = count($incomes);
                                    $expensesCount = count($expenses);

                                    if ($incomesCount > $expensesCount)
                                        $maxCount = $incomesCount;
                                    else
                                        $maxCount = $expensesCount;

                                    $maxCount += 2;
                                    ?>

                                    @for($i=count($incomes); $i<$maxCount; $i++)
                                        <tr>
                                            <td><br><br></td>
                                            <td></td>
{{--                                            <td></td>--}}
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                    @endfor

                                    <tr>
                                        <th class="text-center" colspan="4">Total Revenue</th>
                                        <th class="text-center">৳ {{ number_format($incomes->sum('amount'),2)}}</th>
                                    </tr>
                                </table>
                                <table class="table table-bordered" style="width:50%; float:left">
                                    <tr>
                                        <th colspan="5" class="text-center">Credit</th>
                                    </tr>
                                    <tr>
                                        <th class="text-center">Date</th>
                                        <th class="text-center">Particular</th>
{{--                                        <th class="text-center">Note</th>--}}
                                        <th class="text-center">Payment Type</th>
                                        <th class="text-center">Bank Details</th>
                                        <th class="text-center">Amount</th>
                                    </tr>

                                    @foreach($expenses as $expense)
                                        <tr>
                                            <td class="text-center">{{ $expense->date->format('j F, Y') }}</td>
                                            <td>{{ $expense->particular }}</td>
{{--                                            <td class="text-center">{{ $expense->note }}</td>--}}
                                            <td class="text-center">
                                                @if($expense->transaction_method == 1)
                                                    Cash
                                                @elseif($expense->transaction_method == 2)
                                                    Bank
                                                @elseif($expense->transaction_method == 3)
                                                    Mobile Banking
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                @if ($expense->transaction_method == 2)
                                                    {{ $expense->bank->name.' - '.$expense->account->account_no }}
                                                @endif
                                            </td>
                                            <td class="text-center">৳ {{ number_format($expense->amount,2) }}</td>
                                        </tr>
                                    @endforeach

                                    @for($i=count($expenses); $i<$maxCount; $i++)
                                        <tr>
                                            <td><br><br></td>
                                            <td></td>
{{--                                            <td></td>--}}
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                    @endfor

                                    <tr>
                                        <th class="text-center" colspan="4">Total</th>
                                        <th class="text-center">৳ {{ number_format($expenses->sum('amount'),2) }}</th>
                                    </tr>
                                </table>
                            </table>
                            </div>
{{--                            <div class="row">--}}

{{--                            </div>--}}

                        </div>
                    </div>
                </section>
            @endif
        </div>
    </div>

    @if($incomes)
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header with-border">
                    <h3 class="card-title">Summary</h3>
                </div>
                <!-- /.box-header -->

                <div class="card-body">
                    @if(($incomes->sum('amount')) >= $expenses->sum('amount'))
                        <strong>Net Profit: </strong> {{ number_format(($incomes->sum('amount')) - $expenses->sum('amount'), 2) }}
                    @else
                        <strong>Loss: </strong> {{ number_format($expenses->sum('amount') - ($incomes->sum('amount')), 2) }}
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endif
@endsection

@section('script')
    <!-- bootstrap datepicker -->
    <script src="{{ asset('themes/backend/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>

    <script>
        $(function () {
            //Date picker
            $('#start, #end').datepicker({
                autoclose: true,
                format: 'yyyy-mm-dd'
            });
        });

        var APP_URL = '{!! url()->full()  !!}';
        function getprint(print) {

            $('body').html($('#'+print).html());
            window.print();
            window.location.replace(APP_URL)
        }
    </script>
@endsection
