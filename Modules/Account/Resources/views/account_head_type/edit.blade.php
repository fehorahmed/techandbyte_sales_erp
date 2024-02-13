@extends('layouts.app')
@section('title', 'Account Head Type Edit')
@section('content')
    <div class="page-body">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-inline" style="float: left">
                            <h4>@yield('title')</h4>
                        </div>
                        <h5 style="float: right"><a href="{{ route('account.account_head_type_all') }}" class="btn btn-success">All Head Type</a></h5>
                    </div>
                    <div class="card-block mt-4">
                        <form id="main" method="post" action="{{ route('account.account_head_type_edit',['accountHeadType'=>$accountHeadType->id]) }}">
                            @csrf
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label text-right">Type<span class="text-danger">*</span></label>
                                <div class="col-sm-4">
                                    <select name="type" class="form-control form-control-success select2 {{ $errors->has('type') ? 'is-invalid' :'is-valid-border' }}" style="width: 100%;"  data-placeholder="Select Option">
                                        <option value="">Select Option</option>
                                        <option value="1" {{old('type',$accountHeadType->transaction_type)==1 ? 'selected' : ''}}>Income</option>
                                        <option value="2" {{old('type',$accountHeadType->transaction_type)==2 ? 'selected' : ''}}>Expense</option>
                                    </select>
                                    @error('type')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label text-right">Name<span class="text-danger">*</span></label>
                                <div class="col-sm-4">
                                    <input type="text"
                                           class="form-control {{ $errors->has('name') ? 'is-invalid' : 'is-valid' }}"
                                           name="name" value="{{ old('name',$accountHeadType->name) }}" id="name" placeholder="Enter Name">
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
                                                       {{ old('status', $accountHeadType->status) == '1' ? 'checked' : '' }}
                                                       data-bv-field="status">
                                                <i class="helper"></i>Active
                                            </label>
                                        </div>
                                        <div class="radio radiofill radio-primary radio-inline">
                                            <label>
                                                <input type="radio" name="status" value="0"
                                                       {{ old('status', $accountHeadType->status) == '0' ? 'checked' : '' }}
                                                       data-bv-field="status">
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
