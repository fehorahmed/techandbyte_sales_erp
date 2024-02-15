@extends('layouts.app')
@section('title', 'Transaction Add')
@section('content')
    <div class="page-body">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-inline" style="float: left">
                            <h4>@yield('title')</h4>
                        </div>
                        <h5 style="float: right"><a href="{{ route('account.transaction_all') }}" class="btn btn-success">All Transaction</a></h5>
                    </div>
                    <div class="card-block mt-4">
                        <form id="main" method="post" enctype="multipart/form-data" action="{{ route('account.transaction_add') }}">
                            @csrf
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label text-right">Type<span class="text-danger">*</span></label>
                                <div class="col-sm-8">
                                    <select name="type" id="type" class="form-control form-control-success select2 {{ $errors->has('type') ? 'is-invalid' :'is-valid-border' }}" style="width: 100%;"  data-placeholder="Select Option">
                                        <option value="">Select Option</option>
                                        <option value="1" {{old('type')==1 ? 'selected' : ''}}>Income</option>
                                        <option value="2" {{old('type')==2 ? 'selected' : ''}}>Expense</option>
                                    </select>
                                    @error('type')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label text-right">Account Head Type<span class="text-danger">*</span></label>
                                <div class="col-sm-8">
                                    <select name="account_head_type" id="account_head_type" class="form-control form-control-success select2 {{ $errors->has('account_head_type') ? 'is-invalid' :'is-valid-border' }}" style="width: 100%;"  data-placeholder="Select Option">
                                        <option value="">Select Option</option>
                                    </select>
                                    @error('account_head_type')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label text-right">Sub Account Head Type<span class="text-danger">*</span></label>
                                <div class="col-sm-8">
                                    <select name="account_head_sub_type" id="account_head_sub_type" class="form-control form-control-success select2 {{ $errors->has('account_head_sub_type') ? 'is-invalid' :'is-valid-border' }}" style="width: 100%;"  data-placeholder="Select Option">
                                        <option value="">Select Option</option>
                                    </select>
                                    @error('account_head_sub_type')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label text-right">Payment Type<span class="text-danger">*</span></label>
                                <div class="col-sm-8">
                                    <select name="payment_type" id="payment_type" class="form-control form-control-success select2 {{ $errors->has('payment_type') ? 'is-invalid' :'is-valid-border' }}" style="width: 100%;"  data-placeholder="Select Option">
                                        <option value="">Select Option</option>
                                        <option value="1" {{ old('payment_type') == '1' ? 'selected' : '' }}>Cash</option>
                                        <option value="2" {{ old('payment_type') == '2' ? 'selected' : '' }}>Bank</option>
                                    </select>
                                    @error('payment_type')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div id="bank-info">
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label text-right">Bnak<span class="text-danger">*</span></label>
                                    <div class="col-sm-8">
                                        <select name="bank" class="form-control form-control-success select2 {{ $errors->has('bank') ? 'is-invalid' :'is-valid-border' }}" style="width: 100%;"  data-placeholder="Select Option">
                                            <option value="">Select Bank</option>
                                            @foreach($banks as $bank)
                                                <option value="{{ $bank->id }}"{{ old('bank') == $bank->id ? ' selected' : '' }}>{{ $bank->bank_name }} (Ac : {{$bank->ac_number}})</option>
                                            @endforeach
                                        </select>
                                        @error('bank')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label text-right">Cheque No </label>
                                    <div class="col-sm-8">
                                        <input type="text" name="cheque_no" class="form-control {{ $errors->has('cheque_no') ? 'is-invalid' : 'is-valid' }}" value="{{ old('cheque_no') }}" id="cheque_no" placeholder="Cheque no">
                                        @error('cheque_no')
                                        <span class="help-block">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label text-right">Cheque Date</label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control pull-right date-picker {{ $errors->has('cheque_date') ? 'is-invalid' :'is-valid-border' }}" id="date" name="cheque_date" value="{{ empty(old('cheque_date')) ? ($errors->has('cheque_date') ? '' : date('d-m-Y')) : old('cheque_date') }}" autocomplete="off">
                                        @error('cheque_date')
                                        <span class="help-block">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label text-right">Cheque Image </label>
                                    <div class="col-sm-8">
                                        <input type="file" name="cheque_image" class="form-control value="{{ old('cheque_image') }}">
                                        @error('cheque_image')
                                        <span class="help-block">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label text-right">Amount<span class="text-danger">*</span></label>
                                <div class="col-sm-8">
                                    <input type="text" name="amount" class="form-control {{ $errors->has('amount') ? 'is-invalid' : 'is-valid' }}" value="{{ old('amount') }}" id="amount" placeholder="Enter amount">
                                    @error('amount')
                                    <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label text-right">Date<span class="text-danger">*</span></label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control pull-right date-picker {{ $errors->has('date') ? 'is-invalid' :'is-valid-border' }}" id="date" name="date" value="{{ empty(old('date')) ? ($errors->has('date') ? '' : date('d-m-Y')) : old('date') }}" autocomplete="off">
                                    @error('date')
                                    <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label text-right">Note</label>
                                <div class="col-sm-8">
                                    <input type="text" name="note" class="form-control {{ $errors->has('note') ? 'is-invalid' : 'is-valid' }}" value="{{ old('note') }}" id="name" placeholder="note">
                                    @error('note')
                                    <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label text-right">Next Payment Date<span class="text-danger">*</span></label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control pull-right date-picker {{ $errors->has('next_date') ? 'is-invalid' :'is-valid-border' }}" id="date" name="next_date" value="{{ empty(old('next_date')) ? ($errors->has('next_date') ? '' : date('d-m-Y')) : old('next_date') }}" autocomplete="off">
                                    @error('next_date')
                                    <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-2"></label>
                                <div class="col-sm-10">
                                    <button type="submit" class="btn btn-primary m-b-0">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(function () {
            var accountHeadTypeSelected = '{{ old('account_head_type') }}';
            var accountHeadSubTypeSelected = '{{ old('account_head_sub_type') }}';


            $('#type').change(function () {
                var type = $(this).val();

                $('#account_head_type').html('<option value="">Select Account Head Type</option>');
                $('#account_head_sub_type').html('<option value="">Select Account Head Sub Type</option>');

                if (type != '') {
                    $.ajax({
                        method: "GET",
                        url: "{{ route('account.get_account_head_type') }}",
                        data: { type: type }
                    }).done(function( data ) {
                        $.each(data, function( index, item ) {
                            if (accountHeadTypeSelected == item.id)
                                $('#account_head_type').append('<option value="'+item.id+'" selected>'+item.name+'</option>');
                            else
                                $('#account_head_type').append('<option value="'+item.id+'">'+item.name+'</option>');
                        });

                        $('#account_head_type').trigger('change');
                    });
                }
            });

            $('#type').trigger('change');

            $('#account_head_type').change(function () {
                var typeId = $(this).val();

                $('#account_head_sub_type').html('<option value="">Select Account Head Sub Type</option>');

                if (typeId != '') {
                    $.ajax({
                        method: "GET",
                        url: "{{ route('account.get_account_head_sub_type') }}",
                        data: { typeId: typeId }
                    }).done(function( data ) {
                        $.each(data, function( index, item ) {
                            if (accountHeadSubTypeSelected == item.id)
                                $('#account_head_sub_type').append('<option value="'+item.id+'" selected>'+item.name+'</option>');
                            else
                                $('#account_head_sub_type').append('<option value="'+item.id+'">'+item.name+'</option>');
                        });
                    });
                }
            });

            $('#payment_type').change(function () {
                if ($(this).val() == '2') {
                    $('#bank-info').show();
                } else {
                    $('#bank-info').hide();
                }
            });

            $('#payment_type').trigger('change');
        });
    </script>
@endsection
