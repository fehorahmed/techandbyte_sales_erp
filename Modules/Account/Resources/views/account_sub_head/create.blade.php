@extends('layouts.app')
@section('title', 'Account Sub Head Add')
@section('content')
    <div class="page-body">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-inline" style="float: left">
                            <h4>@yield('title')</h4>
                        </div>
                        <h5 style="float: right"><a href="{{ route('account.account_sub_head_all') }}" class="btn btn-success">All Sub Head</a></h5>
                    </div>
                    <div class="card-block mt-4">
                        <form id="main" method="post" action="{{ route('account.account_sub_head_add') }}">
                            @csrf
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label text-right">Account Head Type<span class="text-danger">*</span></label>
                                <div class="col-sm-4">
                                    <select name="account_head_type_id" class="form-control form-control-success select2 {{ $errors->has('account_head_type_id') ? 'is-invalid' :'is-valid-border' }}" style="width: 100%;"  data-placeholder="Select Option">
                                        <option value="">Select Option</option>
                                        @foreach($accountHeads as $accountHead)
                                            <option value="{{ $accountHead->id }}"{{ old('account_head_type_id') == $accountHead->id ? ' selected' : '' }}>{{ $accountHead->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('account_head_type_id')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label text-right">Name<span class="text-danger">*</span></label>
                                <div class="col-sm-4">
                                    <input type="text"
                                        class="form-control {{ $errors->has('name') ? 'is-invalid' : 'is-valid' }}"
                                        name="name" value="{{ old('name') }}" id="name" placeholder="Enter Name">
                                    @error('name')
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
                                                    {{ old('status', '1') == '1' ? 'checked' : '' }} data-bv-field="status">
                                                <i class="helper"></i>Active
                                            </label>
                                        </div>
                                        <div class="radio radiofill radio-primary radio-inline">
                                            <label>
                                                <input type="radio" name="status" value="0"
                                                    {{ old('status') == '0' ? 'checked' : '' }} data-bv-field="status">
                                                <i class="helper"></i>Inactive
                                            </label>
                                        </div>
                                    </div>
                                    @error('status')
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
