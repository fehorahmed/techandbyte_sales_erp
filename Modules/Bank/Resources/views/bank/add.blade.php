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
                        <h5 style="float: right"><a href="{{ route('bank.bank_all') }}" class="btn btn-success">All Bank</a>
                        </h5>
                    </div>
                    <div class="card-block mt-4">
                        <form id="main" method="post" action="{{ route('bank.bank_add') }}"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label text-right">Bank Name <span
                                        class="help-block">*</span></label>
                                <div class="col-sm-4">
                                    <input type="text"
                                        class="form-control {{ $errors->has('bank_name') ? 'is-invalid' : 'is-valid-border' }}"
                                        name="bank_name" id="bank_name" value="{{ old('bank_name') }}"
                                        placeholder="Bank Name">
                                    @error('bank_name')
                                        <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>

                                <label class="col-sm-2 col-form-label text-right">A/C Name <span
                                        class="help-block">*</span></label>
                                <div class="col-sm-4">
                                    <input type="text"
                                        class="form-control {{ $errors->has('email') ? 'is-invalid' : 'is-valid-border' }}"
                                        id="ac_name" name="ac_name" value="{{ old('ac_name') }}" placeholder="A/C Name">
                                    @error('ac_name')
                                        <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label text-right">A/C Number <span
                                        class="help-block">*</span></label>
                                <div class="col-sm-4">
                                    <input type="text"
                                        class="form-control {{ $errors->has('ac_number') ? 'is-invalid' : 'is-valid-border' }}"
                                        id="ac_number" name="ac_number" value="{{ old('ac_number') }}"
                                        placeholder="A/C Number ">
                                    @error('ac_number')
                                        <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>

                                <label class="col-sm-2 col-form-label text-right">Branch <span
                                        class="help-block">*</span></label>
                                <div class="col-sm-4">
                                    <input type="text"
                                        class="form-control {{ $errors->has('branch') ? 'is-invalid' : 'is-valid-border' }}"
                                        id="branch" name="branch" value="{{ old('branch') }}" placeholder="Branch">
                                    @error('branch')
                                        <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>

                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label text-right">Amount <span
                                        class="help-block">*</span></label>
                                <div class="col-sm-4">
                                    <input type="number"
                                        class="form-control {{ $errors->has('amount') ? 'is-invalid' : 'is-valid-border' }}"
                                        id="amount" name="amount" value="{{ old('amount') }}" placeholder="Amount">
                                    @error('amount')
                                        <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>

                                <label class="col-sm-2 col-form-label text-right">Signature Picture</label>
                                <div class="col-sm-4">
                                    <input type="file" name="signature_pic" class="form-control is-valid-border">
                                    @error('signature_pic')
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
