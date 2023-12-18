@extends('layouts.app')
@section('title','Contra Voucher')
@section('style')
    <style>
        .input-group {
            margin-bottom: 0px;
        }
    </style>
@endsection
@section('content')
<div class="page-body">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header with-border">
                    <h3 class="card-title">@yield('title')</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form method="POST" action="{{ route('account.contra_voucher_add') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="voucher_type" class="col-sm-2 col-form-label">Voucher Type</label>
                            <div class="col-md-4">
                                <input type="text" class="form-control is-valid-border" name="voucher_type" value="Contra" readonly/>
                                @error('voucher_type')
                                    <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="credit_account_code" class="col-sm-2 col-form-label">Reverse Account Head<span class="text-danger">*</span></label>
                            <div class="col-md-4">
                                <select class="form-control form-control-success select2 rev_account_code {{ $errors->has('rev_account_code') ? 'is-invalid' :'is-valid-border' }}" style="width: 100%;" id="rev_account_code" name="rev_account_code" data-placeholder="Select Option">
                                    <option value="">Select Option</option>
                                    @foreach($cashBankHeads as $cashBankHead)
                                        <option value="{{ $cashBankHead->HeadCode }}" {{ $cashBankHead->HeadCode==old('rev_account_code')?'selected':'' }}>{{ $cashBankHead->HeadName }}</option>
                                    @endforeach
                                </select>
                                @error('rev_account_code')
                                    <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="date" class="col-sm-2 col-form-label">Date</label>
                            <div class="col-md-4">
                                <div class="input-group date">
                                    <input type="text" class="form-control pull-right date-picker {{ $errors->has('date') ? 'is-invalid' :'is-valid-border' }}" id="date" name="date" value="{{ empty(old('date')) ? ($errors->has('date') ? '' : date('d-m-Y')) : old('date') }}" autocomplete="off">
                                    @error('date')
                                        <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="remark" class="col-sm-2 col-form-label">Remark</label>
                            <div class="col-md-4">
                                <textarea class="form-control" name="remark">{{ old('remark') }}</textarea>
                            </div>
                        </div>
                        <div>
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th style="white-space: nowrap">Account Name<span class="text-danger">*</span></th>
                                        <th style="white-space: nowrap">Ledger Comment</th>
                                        <th style="white-space: nowrap">Debit</th>
                                        <th style="white-space: nowrap">Credit</th>
                                    </tr>
                                </thead>
                                <tbody id="voucher-container">
                                    <tr class="voucher-item">
                                        <td>
                                            <div class="form-group product_area" style="min-width: 200px;">
                                                <select class="form-control select2 account_code" style="width: 100%;" name="account_code" >
                                                    <option value="">Select Option</option>
{                                                   @foreach($cashBankHeads as $cashBankHead)
                                                        <option value="{{ $cashBankHead->HeadCode }}" {{ $cashBankHead->HeadCode==old('account_code')?'selected':'' }}>{{ $cashBankHead->HeadName }}</option>
                                                    @endforeach
                                                </select>
                                                @error('account_code')
                                                    <br/><span class="help-block">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <input type="text" step="any" class="form-control comment is-valid-border" name="comment" value="{{ old('comment') }}">
                                                @error('comment')
                                                    <br/><span class="help-block">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group" style="min-width: 70px;">
                                                <input type="number" step="any" class="form-control debit is-valid-border" name="debit" value="{{ old('debit') }}">
                                                @error('debit')
                                                    <span class="help-block">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <div class="form-group" style="min-width: 70px;">
                                                <input type="number" step="any" class="form-control credit is-valid-border" name="credit" value="{{ old('credit') }}">
                                                @error('credit')
                                                    <span class="help-block">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer text-right" style="padding-top: 0;">
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
    <script>
        $(function(){
            $('.select2').select2();

        });
    </script>
@endsection
