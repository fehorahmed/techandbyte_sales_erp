@extends('layouts.app')
@section('title','Add Expense Item')
@section('content')
<div class="page-body">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-inline" style="float: left">
                        <h4>@yield('title')</h4>
                    </div>
                    <h5 style="float: right"><a href="{{ route('account.expense_all') }}" class="btn btn-success">Expense Item List</a></h5>
                </div>
                <div class="card-block mt-4">
                    <form id="main" method="post" action="{{ route('account.expense_add') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group row">
                            <label for="expense_item" class="col-sm-2 col-form-label">Expense Type<span class="text-danger">*</span></label>
                            <div class="col-md-4">
                                <select class="form-control form-control-success select2 expense_item {{ $errors->has('expense_item') ? 'is-invalid' :'is-valid-border' }}" style="width: 100%;" id="expense_item" name="expense_item" data-placeholder="Select Option">
                                    <option value="">Select Option</option>
                                    @foreach($expenseItems as $expenseItem)
                                        <option value="{{ $expenseItem->name }}" {{old('expense_item') ==$expenseItem->id ? 'selected' : ''}}>{{ $expenseItem->name }}</option>
                                    @endforeach
                                </select>
                                @error('expense_item')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="payment_type" class="col-sm-2 col-form-label">Payment Type<span class="text-danger">*</span></label>
                            <div class="col-md-4">
                                <select class="form-control form-control-success select2 expense_item {{ $errors->has('payment_type') ? 'is-invalid' :'is-valid-border' }}" style="width: 100%;" id="payment_type" name="payment_type" data-placeholder="Select Option">
                                    <option value="">Select Option</option>
                                    <option value="1" {{old('payment_type') == 1 ? 'selected' : ''}}>Cash Payment</option>
                                </select>
                                @error('payment_type')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="amount" class="col-sm-2 col-form-label">Amount<span class="text-danger">*</span></label>
                            <div class="col-md-4 ">
                                <input type="number" step="any" class="form-control amount {{ $errors->has('amount') ? 'is-invalid' :'is-valid-border' }}" name="amount" value="{{ old('amount') }}">
                                @error('amount')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="" class="col-sm-2 col-form-label">Date</label>
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
                            <label class="col-sm-2"></label>
                            <div class="col-sm-10">
                                <button type="submit" class="btn btn-primary m-b-0">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
