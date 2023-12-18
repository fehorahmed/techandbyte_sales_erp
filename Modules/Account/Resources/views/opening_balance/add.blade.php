@extends('layouts.app')
@section('title','Opening Balance')
@section('style')
    <style>
        .input-group {
            margin-bottom: 0px;
        }
    </style>
@endsection
@section('content')
<div class="page-body">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header with-border">
                    <h3 class="card-title">@yield('title')</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form method="POST" action="{{ route('account.opening_balance_add') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="voucher_type" class="col-sm-2 col-form-label">Financial Year<span class="text-danger">*</span></label>
                            <div class="col-md-4">
                                <select class="form-control select2 financial_year" style="width: 100%;" name="financial_year" >
                                    <option value="">Select Option</option>
                                    @foreach($financial_years as $financial_year)
                                        <option value="{{ $financial_year->id }}">{{ $financial_year->yearName }}</option>
                                    @endforeach
                                </select>
                                @error('financial_year')
                                    <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="date" class="col-sm-2 col-form-label">Date</label>
                            <div class="col-md-4">
                                <div class="input-group date">
                                    <input type="text" class="form-control pull-right date-picker {{ $errors->has('date') ? 'is-invalid' :'is-valid-border' }}" id="date" name="date" value="{{ empty(old('date')) ? ($errors->has('date') ? '' : date('d-m-Y')) : old('date') }}" autocomplete="off">
                                    @error('date')
                                        <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div>
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th style="white-space: nowrap">Account Name<span class="text-danger">*</span></th>
                                        <th style="white-space: nowrap">Sub Type</th>
                                        <th style="white-space: nowrap;">Debit</th>
                                        <th style="white-space: nowrap;">Credit</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="voucher-container">
                                @if (old('account_code') != null && sizeof(old('account_code')) > 0)
                                    @foreach(old('account_code') as $item)
                                        <tr class="voucher-item">
                                            <td>
                                                <div class="form-group {{ $errors->has('account_code.'.$loop->index) ? 'has-error' :'' }}" style="min-width: 200px;">
                                                    <select class="form-control select2 account_code" style="width: 100%;" id="account_code" name="account_code[]" required>
                                                        <option value="">Select Option</option>
                                                        @if (old('account_code_name.'.$loop->index) != '')
                                                            <option value="{{ old('account_code_name.'.$loop->index) }}" selected>{{ old('account_code_name.'.$loop->index) }}</option>
                                                        @endif
                                                    </select>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group {{ $errors->has('subtype.'.$loop->index) ? 'has-error' :'' }}">
                                                    <select class="form-control select2 subtype" style="width: 100%;" name="subtype[]" required>
                                                        <option value="">Select Option</option>
                                                    </select>
                                                    <input type="hidden" name="isSubtype[]" class="isSubtype" value="1" />
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group {{ $errors->has('debit.'.$loop->index) ? 'has-error' :'' }}" style="min-width: 100px;">
                                                    <input type="number" step="any" class="form-control debit" name="debit[]" value="{{ old('debit.'.$loop->index) }}">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group {{ $errors->has('credit.'.$loop->index) ? 'has-error' :'' }}" style="min-width: 100px;">
                                                    <input type="number" step="any" class="form-control credit" name="credit[]" value="{{ old('credit.'.$loop->index) }}">
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <a role="button" class="btn-sm btn-remove" style="cursor: pointer;"><i style="font-size: 20px; color:red;" class="feather icon-trash-2"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr class="voucher-item">
                                        <td>
                                            <div class="form-group product_area" style="min-width: 200px;">
                                                <select class="form-control select2 account_code" style="width: 100%;" name="account_code[]" >
                                                    <option value="">Select Option</option>
{{--                                                    @foreach($transactionHeads as $transactionHead)--}}
{{--                                                        <option value="{{ $transactionHead->id }}">{{ $transactionHead->HeadName }}</option>--}}
{{--                                                    @endforeach--}}
                                                </select>
                                                <input type="hidden" name="account_code_name[]" class="account_code_name">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <select class="form-control select2 subtype" style="width: 100%;" name="subtype[]">
                                                    <option value="">Select Option</option>
                                                </select>
                                                <input type="hidden" name="isSubtype[]" class="isSubtype" value="1" />
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group" style="min-width: 100px;">
                                                <input type="number" step="any" class="form-control debit is-valid-border" name="debit[]" placeholder="0.00">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group" style="min-width: 100px;">
                                                <input type="number" step="any" class="form-control credit is-valid-border" name="credit[]" placeholder="0.00">
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <a role="button" class="btn-sm btn-remove" style="cursor: pointer;"><i style="font-size: 20px; color:red;" class="feather icon-trash-2"></i></a>
                                        </td>
                                    </tr>
                                @endif
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td>
                                            <a role="button" class="btn btn-info btn-sm" id="btn-add">Add More</a>
                                        </td>
                                        <th class="text-right">Total</th>
                                        <th>
                                            <input type="text" id="totalDebit" class="form-control is-valid-border" name="total_debit" value="0" readonly>
                                        </th>
                                        <th>
                                            <input type="text" id="totalCredit" class="form-control is-valid-border" name="total_credit" value="0" readonly>
                                        </th>
                                        <td></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer text-right" style="padding-top: 0;">
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <template id="template-debit-voucher">
        <tr class="voucher-item">
            <td>
                <div class="form-group product_area" style="min-width: 200px;">
                    <select class="form-control select2 account_code" style="width: 100%;" name="account_code[]" >
                        <option value="">Select Option</option>
{{--                        @foreach($transactionHeads as $transactionHead)--}}
{{--                            <option value="{{ $transactionHead->id }}">{{ $transactionHead->HeadName }}</option>--}}
{{--                        @endforeach--}}
                    </select>
                    <input type="hidden" name="account_code_name[]" class="account_code_name">
                </div>
            </td>
            <td>
                <div class="form-group">
                    <select class="form-control select2 subtype" style="width: 100%;" name="subtype[]">
                        <option value="">Select Option</option>
                    </select>
                    <input type="hidden" name="isSubtype[]" class="isSubtype" value="1" />
                </div>
            </td>
            <td>
                <div class="form-group">
                    <input type="number" step="any" class="form-control  is-valid-border debit" name="debit[]" placeholder="0.00">
                </div>
            </td>
            <td>
                <div class="form-group">
                    <input type="number" step="any" class="form-control  is-valid-border credit" name="credit[]" placeholder="0.00">
                </div>
            </td>
            <td class="text-center">
                <a role="button" class="btn-sm btn-remove" style="cursor: pointer;"><i style="font-size: 20px; color:red;" class="feather icon-trash-2"></i></a>
            </td>
        </tr>
    </template>
</div>
@endsection
@section('script')
    <script>
        $(function(){
            calculate();
            $('.select2').select2();
            initSelect2();
            addProduct__delete();
            $('body').on('keyup', '.debit, .credit', function () {
                calculate();
            });
            $('body').on('change', '.debit, .credit', function () {
                calculate();
            });

            $(document).on('change','.account_code',function () {
                let acc_code = $(this).val();
                let itemList = $(this).closest('tr');
                itemList.find('.subtype').html('<option value="">Select Option</option>');
                console.log(acc_code);
                if (acc_code != '') {
                    $.ajax({
                        method: "GET",
                        url: "{{ route('get_subtype_list') }}",
                        data: { acc_code: acc_code }
                    }).done(function(response) {
                        if(response.status){
                            itemList.find('.subtype').removeAttr('disabled',1);
                            itemList.find('.isSubtype').val(response.subtype);
                            $.each(response.acc_sutypes, function( index, item ) {
                                itemList.find('.subtype').append('<option value="'+item.id+'">'+item.name+'</option>');
                            });
                        }else{
                            itemList.find('.subtype').attr('disabled',1);
                            itemList.find('.isSubtype').val(response.subtype);
                        }
                    });
                }
            })

        });
    </script>
    <script>
        function calculate(){
            let voucherDebitTotal = 0;
            let voucherCreditTotal = 0;

            $('.voucher-item').each(function(i){
                let debit = $('.debit').eq(i).val();
                let credit = $('.credit').eq(i).val();

                if (debit == '' || debit < 0 || !$.isNumeric(debit)){
                    debit = 0;
                }
                if (credit == '' || credit < 0 || !$.isNumeric(credit)){
                    credit = 0;
                }
                voucherDebitTotal += parseFloat(debit);
                voucherCreditTotal += parseFloat(credit);
            });
            $('#totalDebit').val(voucherDebitTotal.toFixed(2));
            $('#totalCredit').val(voucherCreditTotal.toFixed(2));
        }

        function addProduct__delete(){
            $('#btn-add').click(function () {
                let html = $('#template-debit-voucher').html();
                let item = $(html);
                $('#voucher-container').append(item);
                if ($('.voucher-item').length >= 1 ) {
                    $('.btn-remove').show();
                }
                initSelect2();
            });
            $('body').on('click', '.btn-remove', function () {
                $(this).closest('.voucher-item').remove();
                calculate();
                if ($('.voucher-item').length <= 1 ) {
                    $('.btn-remove').hide();
                }
            });
            if ($('.voucher-item').length <= 1 ) {
                $('.btn-remove').hide();
            } else {
                $('.btn-remove').show();
            }
        }

        function initSelect2() {
            $('.select2').select2();
            $('.account_code').select2({
                ajax: {
                    url: "{{ route('get_opening_account_code_json') }}",
                    type: "get",
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            searchTerm: params.term, // search term
                        };
                    },
                    processResults: function (response) {
                        return {
                            results: response
                        };
                    },
                    cache: true
                }
            });
            $('.account_code').on('select2:select', function (e) {
                let data = e.params.data;
                let index = $(".account_code").index(this);
                $('.account_code_name:eq('+index+')').val(data.text);
            });
        }
    </script>
@endsection
