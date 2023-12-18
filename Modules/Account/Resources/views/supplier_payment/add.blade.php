@extends('layouts.app')
@section('title','Supplier Payment')
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
                        <h3 class="card-title">Supplier Payment</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form method="POST" action="{{ route('account.supplier_payment') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="form-group row">
                                <label for="date" class="col-sm-2 col-form-label">Date<span class="text-danger">*</span></label>
                                <div class="col-md-4">
                                    <div class="input-group date">
                                        <input type="text" class="form-control pull-right date-picker {{ $errors->has('date') ? 'is-invalid' :'is-valid-border' }}" id="date" name="date" value="{{ empty(old('date')) ? ($errors->has('date') ? '' : date('d-m-Y')) : old('date') }}" autocomplete="off">
                                        @error('date')
                                            <span class="help-block">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="remark" class="col-sm-2 col-form-label">Remark</label>
                                <div class="col-md-4">
                                    <textarea class="form-control" name="remark">{{ old('remark') }}</textarea>
                                </div>
                            </div>
                            <div>
                                <table class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th style="white-space: nowrap">Supplier Name<span class="text-danger">*</span></th>
                                        <th style="white-space: nowrap">Voucher No</th>
                                        <th style="white-space: nowrap">Due Amount</th>
                                        <th style="white-space: nowrap">Amount<span class="text-danger">*</span></th>
                                    </tr>
                                    </thead>
                                    <tbody id="voucher-container">
                                        <tr class="voucher-item">
                                            <td>
                                                <div class="form-group product_area" style="min-width: 200px;">
                                                    <select class="form-control select2 supplier" style="width: 100%;" name="supplier" >
                                                        <option value="">Select Option</option>
                                                        @if (old('supplier_name') != '')
                                                            <option value="{{ old('supplier') }}" selected>{{ old('supplier_name') }}</option>
                                                        @endif
                                                    </select>
                                                    <input type="hidden" name="supplier_name" class="supplier_name">
                                                    @error('supplier')
                                                        <br/><span class="help-block">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group">
                                                    <select class="form-control select2 voucher_no" style="width: 100%;" name="voucher_no">
                                                        <option value="">Select Option</option>
                                                    </select>
                                                    @error('voucher_no')
                                                        <br/><span class="help-block">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group">
                                                    <input type="text" step="any" class="form-control due is-valid-border" name="due" readonly>
                                                    @error('due')
                                                        <br/><span class="help-block">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group" style="min-width: 70px;">
                                                    <input type="number" step="any" class="form-control amount is-valid-border" name="amount" value="{{ old('amount') }}">
                                                    @error('amount')
                                                        <span class="help-block">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <td>
                                            <input type="hidden" name="grand_total" class="grandTotal">
                                        </td>
                                        <th colspan="2" class="text-right">Total Amount</th>
                                        <th id="grandTotal">৳0.00</th>
                                    </tr>
                                    </tfoot>
                                </table>
                                <div class="row" style="margin-left: 0px !important;">
                                    <div class="col-md-6 table-bordered">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label for="account_code" class="col-form-label">Payment Type <span class="text-danger">*</span></label>
                                                <div class="form-group">
                                                    <select class="form-control select2 account_code" style="" name="account_code">
                                                        <option value="">Select Option</option>
                                                        @foreach($cashBankHeads as $cashBankHead)
                                                            <option value="{{ $cashBankHead->HeadCode }}">{{ $cashBankHead->HeadName }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('account_code')
                                                        <span class="help-block">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="paid_amount" class="col-form-label">Paid Amount <span class="text-danger">*</span></label>
                                                <div class="form-group" style="">
                                                    <input type="number" step="any" class="form-control paid_amount is-valid-border" name="paid_amount" placeholder="0.00">
                                                    @error('paid_amount')
                                                        <span class="help-block">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-right" style="padding-top: 0;">
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(function(){
            calculate();
            $('.select2').select2();
            initSelect2();
            addProduct__delete();
            $('body').on('keyup', '.amount', function () {
                calculate();
            });
            $('body').on('change', '.amount', function () {
                calculate();
            });

            let oldVoucher = '{{ old('voucher_no') }}';
            $(document).on('change','.supplier',function () {
                let supplierId = $(this).val();
                $('.voucher_no').html('<option value="">Select Option</option>');
                if (supplierId != '') {
                    $.ajax({
                        method: "GET",
                        url: "{{ route('account.get_supplier_voucher_due_list') }}",
                        data: { supplierId: supplierId }
                    }).done(function(response) {
                        if(response.status){
                            $.each(response.invoices, function( index, item ) {
                                if(oldVoucher == item.id){
                                    $('.voucher_no').append('<option value="'+item.id+'" selected>'+item.chalan_no+'</option>');
                                    $('.voucher_no').trigger('change');
                                }else{
                                    $('.voucher_no').append('<option value="'+item.id+'">'+item.chalan_no+'</option>');
                                }
                            });
                        }
                    });
                }
            })
            $('.supplier').trigger('change');
            $(document).on('change','.voucher_no',function () {
                let voucherId = $(this).val();
                $('.due').val('');
                if (voucherId != '') {
                    $.ajax({
                        method: "GET",
                        url: "{{ route('account.get_supplier_voucher_details') }}",
                        data: { voucherId: voucherId }
                    }).done(function(response) {
                        if(response.status){
                            $('.due').val(response.invoice.due_amount);
                        }
                    });
                }
            })

        });
    </script>
    <script>
        function calculate(){
            let voucherSubTotal = 0;
            let amount = $('.amount').val();

            if (amount == '' || amount < 0 || !$.isNumeric(amount)){
                amount = 0;
            }
            voucherSubTotal = parseFloat(amount);
            $('#grandTotal').html('৳' + voucherSubTotal.toFixed(2));
            $('.grandTotal').val(voucherSubTotal.toFixed(2));
            $('.paid_amount').val(voucherSubTotal.toFixed(2));
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
            $('.supplier').select2({
                ajax: {
                    url: "{{ route('get_suppliers_json') }}",
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
            $('.supplier').on('select2:select', function (e) {
                let data = e.params.data;
                let index = $(".supplier").index(this);
                $('.supplier_name:eq('+index+')').val(data.text);
            });
        }
    </script>
@endsection
