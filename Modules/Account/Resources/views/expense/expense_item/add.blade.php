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
                    <h5 style="float: right"><a href="{{ route('account.expense_item_all') }}" class="btn btn-success">Expense Item List</a></h5>
                </div>
                <div class="card-block mt-4">
                    <form id="main" method="post" action="{{ route('account.expense_item_add') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label text-right">Expense Item Name<span class="help-block">*</span></label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control {{ $errors->has('name') ? 'is-invalid' :'is-valid-border' }}" id="name" name="name" value="{{ old('name') }}" placeholder="Expense Item Name ">
                                @error('name')
                                   <span class="help-block">{{ $message }}</span>
                                @enderror
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
