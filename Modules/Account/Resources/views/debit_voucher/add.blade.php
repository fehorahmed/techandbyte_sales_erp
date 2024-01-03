@extends('layouts.app')
@section('title','Debit Voucher')
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
                    <h3 class="card-title">Debit Voucher</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form method="POST" action="{{ route('account.debit_voucher_add') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="voucher_type" class="col-sm-2 col-form-label">Voucher Type</label>
                            <div class="col-md-4">
                                <input type="text" class="form-control" name="voucher_type" value="Debit" readonly/>
                                @error('voucher_type')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="credit_account_code" class="col-sm-2 col-form-label">Credit Account Head<span class="text-danger">*</span></label>
                            <div class="col-md-4">
                                <select class="form-control form-control-success select2 credit_account_code {{ $errors->has('credit_account_code') ? 'is-invalid' :'is-valid-border' }}" style="width: 100%;" id="credit_account_code" name="credit_account_code" data-placeholder="Select Option">
                                    <option value="">Select Option</option>
                                    @foreach($cashBankHeads as $cashBankHead)
                                        <option value="{{ $cashBankHead->HeadCode }}" data-isBank="{{ $cashBankHead->isBankNature }}">{{ $cashBankHead->HeadName }}</option>
                                    @endforeach
                                </select>
                                @error('credit_account_code')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div id="isBankNature">
                            <div class="form-group row">
                                <label for="check_no" class="col-sm-2 col-form-label">Check No</label>
                                <div class="col-md-4">
                                    <input type="text" class="form-control" name="check_no"/>
                                    @error('check_no')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="check_date" class="col-sm-2 col-form-label">Check Date</label>
                                <div class="col-md-4">
                                    <div class="input-group check_date">
                                        <input type="text" class="form-control pull-right date-picker {{ $errors->has('cheque_date') ? 'is-invalid' :'is-valid-border' }}" id="cheque_date" name="cheque_date" value="{{ empty(old('cheque_date')) ? ($errors->has('cheque_date') ? '' : date('d-m-Y')) : old('cheque_date') }}" autocomplete="off">
                                        @error('cheque_date')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="vo_no" class="col-sm-2 col-form-label">Is Honours</label>
                                <div class="col-md-4 text-left">
                                    <input type="checkbox" class="form-check form-check-inline" id="ishonours" name="ishonours" style="margin-top: 13px;">
                                </div>
                            </div>

                        </div>

                        <div class="form-group row">
                            <label for="date" class="col-sm-2 col-form-label">Date</label>
                            <div class="col-md-4">
                                <div class="input-group date">
                                    <input type="text" class="form-control pull-right date-picker {{ $errors->has('date') ? 'is-invalid' :'is-valid-border' }}" id="date" name="date" value="{{ empty(old('date')) ? ($errors->has('date') ? '' : date('d-m-Y')) : old('date') }}" autocomplete="off">
                                    @error('date')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="remark" class="col-sm-2 col-form-label">Remark</label>
                            <div class="col-md-4">
                                <textarea class="form-control" name="remark"></textarea>
                            </div>
                        </div>
                        <div>
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th style="white-space: nowrap">Account Name<span class="text-danger">*</span></th>
                                        <th style="white-space: nowrap">Sub Type<span class="text-danger">*</span></th>
                                        <th style="white-space: nowrap">Ledger Comment</th>
                                        <th style="white-space: nowrap">Amount<span class="text-danger">*</span></th>
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
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group {{ $errors->has('comment.'.$loop->index) ? 'has-error' :'' }}">
                                                    <input type="text" step="any" class="form-control comment" name="comment[]" value="{{ old('comment.'.$loop->index) }}">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group {{ $errors->has('amount.'.$loop->index) ? 'has-error' :'' }}">
                                                    <input type="number" step="any" class="form-control amount" name="amount[]" value="{{ old('amount.'.$loop->index) }}">
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
                                            <div class="form-group">
                                                <input type="text" step="any" class="form-control comment is-valid-border" name="comment[]">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group" style="min-width: 70px;">
                                                <input type="number" step="any" class="form-control amount is-valid-border" name="amount[]">
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
                                            <input type="hidden" name="grand_total" class="grandTotal">
                                        </td>
                                        <th colspan="2" class="text-right">Total Amount</th>
                                        <th id="grandTotal">৳0.00</th>
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
                    <input type="text" step="any" class="form-control comment is-valid-border" name="comment[]">
                </div>
            </td>
            <td>
                <div class="form-group">
                    <input type="number" step="any" class="form-control  is-valid-border amount" name="amount[]">
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
            $('body').on('keyup', '.amount, .product_rate', function () {
                calculate();
            });
            $('body').on('change', '.amount, .product_rate', function () {
                calculate();
            });

            $('#credit_account_code').change(function () {
                $isBank = $('option:selected', this).attr('data-isBank');
                if($isBank==1){
                    $('#isBankNature').show();
                }else{
                    $('#isBankNature').hide();
                }
            });
            $('#credit_account_code').trigger('change');

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
            let voucherSubTotal = 0;

            $('.voucher-item').each(function(i){
                let amount = $('.amount').eq(i).val();

                if (amount == '' || amount < 0 || !$.isNumeric(amount)){
                    amount = 0;
                }
                voucherSubTotal += parseFloat(amount);
            });
            $('#grandTotal').html('৳' + voucherSubTotal.toFixed(2));
            $('.grandTotal').val(voucherSubTotal.toFixed(2));
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
                    url: "{{ route('get_account_code_json') }}",
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
