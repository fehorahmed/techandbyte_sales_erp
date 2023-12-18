@extends('layouts.app')
@section('title','Add Sub Account')
@section('content')
<div class="page-body">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-inline" style="float: left">
                        <h4>@yield('title')</h4>
                    </div>
                    <h5 style="float: right"><a href="{{ route('account.sub_account_all') }}" class="btn btn-success">All SubAccount</a></h5>
                </div>
                <div class="card-block mt-4">
                    <form id="main" method="post" action="{{ route('account.sub_account_add') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label text-right">Sub Type <span class="help-block">*</span></label>
                            <div class="col-sm-4">
                                <select name="subtype" id="subtype" class="form-control select2 form-control-success {{ $errors->has('subtype') ? 'is-invalid' :'' }}">
                                    <option value="">Select Option</option>
                                    @foreach($accSubTypes as $accSubType)
                                        <option value="{{ $accSubType->id }}">{{ $accSubType->subtypeName }}</option>
                                    @endforeach
                                </select>
                                @error('subtype')
                                    <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>

                            <label class="col-sm-2 col-form-label text-right">Account Name <span class="help-block">*</span></label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control {{ $errors->has('account_name') ? 'is-invalid' :'is-valid-border' }}" id="account_name" name="account_name" value="{{ old('account_name') }}" placeholder="Account Name">
                                @error('account_name')
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
