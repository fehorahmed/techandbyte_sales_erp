@extends('layouts.app')
@section('title', 'Loan Edit')
@section('content')
    <div class="page-body">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-inline" style="float: left">
                            <h4>@yield('title')</h4>
                        </div>
                        <h5 style="float: right"><a href="{{ route('loan.index') }}" class="btn btn-success">All
                                Loan</a></h5>
                    </div>
                    <div class="card-block mt-4">
                        <form id="main" method="post" action="{{ route('loan.edit', $loan->id) }}">
                            @csrf
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label text-right">Loan Title</label>
                                <div class="col-sm-4">
                                    <select name="loan_holder" class="form-control select2" id="loan_holder">
                                        <option value="">Select One</option>
                                        @foreach ($loanHolders as $loanHolder)
                                            <option {{ old('loan_holder',$loan->loan_holder_id) == $loanHolder->id ? 'selected' : '' }} value="{{ $loanHolder->id }}">{{ $loanHolder->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('loan_holder')
                                    <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>


                                <label class="col-sm-2 col-form-label text-right">Loan Type</label>
                                <div class="col-sm-4">
                                    <select name="type" class="form-control" id="type">
                                        <option value="">Select One</option>
                                        <option {{ old('type', $loan->type) == 'take' ? 'selected' : '' }} value="take">
                                            Take
                                        </option>
                                        <option {{ old('type', $loan->type) == 'give' ? 'selected' : '' }} value="give">
                                            Give
                                        </option>

                                    </select>
                                    @error('type')
                                        <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label text-right">Date</label>
                                <div class="col-sm-4">
                                    <input type="date"
                                        class="form-control {{ $errors->has('date') ? 'is-invalid' : 'is-valid' }}"
                                        id="date" name="date" value="{{ old('date', $loan->date) }}"
                                        placeholder="Enter date">
                                    @error('date')
                                        <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>

                                <label class="col-sm-2 col-form-label text-right">Amount</label>
                                <div class="col-sm-4">
                                    <input type="number"
                                        class="form-control {{ $errors->has('amount') ? 'is-invalid' : 'is-valid' }}"
                                        id="amount" name="amount" value="{{ old('amount', $loan->amount) }}">
                                    @error('amount')
                                        <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">

                                <label class="col-sm-2 col-form-label text-right">Details</label>
                                <div class="col-sm-4">
                                    <textarea class="form-control {{ $errors->has('details') ? 'is-invalid' : 'is-valid' }}" id="details" name="details"
                                        rows="3" value="{{ old('details', $loan->details) }}" placeholder="Enter Details">{{ old('details', $loan->details) }}</textarea>
                                    @error('details')
                                        <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>

                                <label class="col-sm-2 col-form-label text-right">Transaction Type</label>
                                <div class="col-sm-4">
                                    <select name="transaction_type" class="form-control" id="transaction_type">
                                        <option value="">Select One</option>
                                        <option
                                            {{ old('transaction_type', $loan->transaction_type) == '1' ? 'selected' : '' }}
                                            value="1">
                                            Cash
                                        </option>
                                        <option
                                            {{ old('transaction_type', $loan->transaction_type) == '2' ? 'selected' : '' }}
                                            value="2">
                                            Bank
                                        </option>

                                    </select>
                                    @error('transaction_type')
                                        <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2"></label>
                                <div class="col-sm-10">
                                    <button type="submit" class="btn btn-primary m-b-0">Update</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
