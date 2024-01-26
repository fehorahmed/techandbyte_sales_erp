@extends('layouts.app')
@section('title', 'Loan Holder Edit')
@section('content')
    <div class="page-body">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-inline" style="float: left">
                            <h4>@yield('title')</h4>
                        </div>
                        <h5 style="float: right"><a href="{{ route('loan.loan_holder_index') }}" class="btn btn-success">All Loan Holder</a></h5>
                    </div>
                    <div class="card-block mt-4">
                        <form id="main" method="post" action="{{ route('loan.loan_holder_edit', $loanHolder->id) }}">
                            @csrf
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label text-right">Name</label>
                                <div class="col-sm-4">
                                    <input type="text"
                                        class="form-control {{ $errors->has('name') ? 'is-invalid' : 'is-valid' }}"
                                        name="name" value="{{ old('name', $loanHolder->name) }}" id="name"
                                        placeholder="Enter Client Name">
                                    @error('name')
                                        <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                                <label class="col-sm-2 col-form-label text-right">Phone</label>
                                <div class="col-sm-4">
                                    <input type="text"
                                           class="form-control {{ $errors->has('phone') ? 'is-invalid' : 'is-valid' }}"
                                           id="phone" name="phone" value="{{ old('phone', $loanHolder->phone) }}"
                                           placeholder="Enter Phone">
                                    @error('phone')
                                    <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>

                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-check text-right">Status</label>
                                <div class="col-sm-4">
                                    <div class="form-radio">
                                        <div class="radio radiofill radio-primary radio-inline">
                                            <label>
                                                <input type="radio" name="status" value="1"
                                                       {{ old('status', $loanHolder->status) == '1' ? 'checked' : '' }}
                                                       data-bv-field="status">
                                                <i class="helper"></i>Active
                                            </label>
                                        </div>
                                        <div class="radio radiofill radio-primary radio-inline">
                                            <label>
                                                <input type="radio" name="status" value="0"
                                                       {{ old('status', $loanHolder->status) == '0' ? 'checked' : '' }}
                                                       data-bv-field="status">
                                                <i class="helper"></i>Inactive
                                            </label>
                                        </div>
                                    </div>
                                    @error('status')
                                    <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                                <label class="col-sm-2 col-form-label text-right">Address</label>
                                <div class="col-sm-4">
                                    <textarea class="form-control {{ $errors->has('address') ? 'is-invalid' : 'is-valid' }}" id="address" name="address"
                                        value="{{ old('address', $loanHolder->address) }}" placeholder="Enter your address">{{ old('address', $loanHolder->address) }}</textarea>
                                    @error('address')
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
