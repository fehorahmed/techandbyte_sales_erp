<div class="col-md-12" id="vaucherPrintArea">
    <div class="row p-b-20 voucher-center">
        <div class="col-md-3">
            {{--            <img src="http://localhost/sales-erp/" alt="Logo" height="40px"><br><br>--}}
        </div>
        <div class="col-md-6 text-center">
            <h2>{{config('app.name')}}</h2>

            <strong><u class="pt-4">Contra Voucher</u></strong>
        </div>
        <div class="col-md-3">
            <div class="pull-right" style="margin-right:20px;">
                <label class="mb-0"><b>Voucher No</b></label> : {{$accVoucher->VNo}}<br>
                <label class="mb-0"><b>Date</b></label> :{{ \Carbon\Carbon::parse($accVoucher->VDate)->format('d/m/Y')}}
            </div>
        </div>
    </div>

    <table class="table table-bordered table-sm mt-2">

        <thead>
        <tr>
            <th class="text-center">Particulars</th>
            <th class="text-center">Debit</th>
            <th class="text-center">Credit</th>

        </tr>


        </thead>
        <tbody>
        @php
            $Debit = 0;
            $Credit = 0;
        @endphp
        @if (!empty($accVoucher))
            @foreach ($accVoucher->details as $row)
                @php
                    $Debit += $row->Debit;
                    $Credit += $row->Credit;
                @endphp
                <tr>
                    <td><strong style="font-size: 15px;;"> {{ $row->account->HeadName ??''.($accVoucher->sub_account->subType != 1 ? '('.$accVoucher->sub_account->name??''.')' : '') }}</strong><br>
                        <span>{{ $row->ledgerComment }}</span>
                    </td>
                    <td class="text-right">{{number_format($row->Debit,2)}}</td>
                    <td class="text-right">{{number_format($row->Credit,2)}}</td>
                </tr>
            @endforeach
        @else
            <tr>
                <td><b>Data is not available</b></td>
            </tr>
        @endif
        <tr>
            <td class="text-left">
                <strong style="font-size: 15px;">
                    {{$accVoucher->rev_account->HeadName??''}}
                </strong>
            </td>
            <td class="text-right">{{number_format($row->Debit == '0.00'?$row->Credit:0,2)}}</td>
            <td class="text-right">{{number_format($row->Credit == '0.00'?$row->Debit:0,2)}}</td>

        </tr>
        </tbody>
        <tfoot>
        <tr>
            <th class="text-right">Total</th>
            <th class="text-right">{{number_format($Credit,2)}}</th>
            <th class="text-right">{{number_format($Credit,2)}}</th>
        </tr>
        <tr>


        </tr>
        <tr>


            <th class="" colspan="3">Remark : {{$accVoucher->Narration ??''}}</th>
        </tr>
        </tfoot>
    </table>
    <div class="form-group row mt-100-50">
        <label for="name" class="col-lg-3 col-md-3 col-sm-3  col-form-label text-center">
            <div class="border-top">Prepared By:{{$accVoucher->created_by ?? ''}}</div>
        </label>
        <label for="name" class="col-lg-3 col-md-3 col-sm-3 col-form-label text-center">
            <div class="border-top">Checked By</div>
        </label>
        <label for="name" class="col-lg-3 col-md-3 col-sm-3 col-form-label text-center">
            <div class="border-top">Authorised By</div>
        </label>
        <label for="name" class="col-lg-3 col-md-3 col-sm-3 col-form-label text-center">
            <div class="border-top">Pay By</div>
        </label>

           </div>
</div>
