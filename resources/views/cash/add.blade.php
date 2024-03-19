@extends('layouts.app')
@section('title', 'Add Bank')
@section('content')
    <div class="page-body">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-inline" style="float: left">
                            <h4>@yield('title')</h4>
                        </div>
                        <h5 style="float: right"><a href="{{ route('cash') }}" class="btn btn-success"> Cash</a></h5>
                    </div>
                    <div class="card-block mt-4">
                        <form id="main" method="post" action="{{ route('add.cash') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label text-right">Current Cash <span
                                        class="help-block">*</span></label>
                                <div class="col-sm-4">
                                    <input type="text"
                                        class="form-control {{ $errors->has('current_cash') ? 'is-invalid' : 'is-valid-border' }}"
                                        name="current_cash" readonly id="current_cash" value="{{ $cash->amount ?? 0 }}">

                                </div>

                                <label class="col-sm-6 col-form-label ">
                                </label>

                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label text-right">Amount <span
                                        class="help-block">*</span></label>
                                <div class="col-sm-4">
                                    <input type="text"
                                        class="form-control {{ $errors->has('amount') ? 'is-invalid' : 'is-valid-border' }}"
                                        name="amount" id="amount" value="{{ old('amount') }}"
                                        placeholder="Enter amount">
                                    @error('amount')
                                        <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>

                                <label class="col-sm-6 col-form-label "><span class="help-block">*</span>Please be sure,
                                    this amount will be added on your cash amount as asset or invest.
                                </label>

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
