@extends('layouts.app')
@section('title','Add Financial Year')
@section('content')
<div class="page-body">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-inline" style="float: left">
                        <h4>@yield('title')</h4>
                    </div>
                    <h5 style="float: right"><a href="{{ route('account.financialyear_all') }}" class="btn btn-success">Financial Year List</a></h5>
                </div>
                <div class="card-block mt-4">
                    <form id="main" method="post" action="{{ route('account.financialyear_add') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label text-right">Financial Year <span class="help-block">*</span></label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control {{ $errors->has('yearName') ? 'is-invalid' :'is-valid-border' }}" id="yearName" name="yearName" value="{{ old('yearName') }}" placeholder="Financial Year">
                                @error('yearName')
                                   <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>

                            <label class="col-sm-2 col-form-label text-right">Status <span class="help-block">*</span></label>
                            <div class="col-sm-4">
                                <select name="status" id="status" class="form-control select2 form-control-success {{ $errors->has('status') ? 'is-invalid' :'' }}">
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                                @error('status')
                                    <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label text-right">Financial Year Start <span class="help-block">*</span></label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control date-picker {{ $errors->has('financial_year_start_date') ? 'is-invalid' :'is-valid-border' }}" id="financial_year_start_date" name="financial_year_start_date" value="{{ old('financial_year_start_date') }}" placeholder="Financial Year Start" autocomplete="off">
                                @error('financial_year_start_date')
                                   <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>

                            <label class="col-sm-2 col-form-label text-right">Financial Year End <span class="help-block">*</span></label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control date-picker {{ $errors->has('financial_year_end_date') ? 'is-invalid' :'is-valid-border' }}" id="financial_year_end_date" name="financial_year_end_date" value="{{ old('financial_year_end_date') }}" placeholder="Financial Year End" autocomplete="off">
                                @error('financial_year_end_date')
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
