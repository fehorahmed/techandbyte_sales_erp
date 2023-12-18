@extends('layouts.app')
@section('title','Predefine Accounts')
@section('content')
    <div class="page-body">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-inline" style="float: left">
                            <h4>@yield('title')</h4>
                        </div>

                    </div>
                    <div class="card-block mt-4">
                        <form id="main" method="post" action="{{ route('account.predefined_accounts_add') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label text-right">cashCode <span class="text-danger"><b>*</b></span></label>
                                <div class="col-sm-4">
                                    <select name="cashCode" id="cashCode" class="form-control form-control-success select2">
                                        <option value="">Select Category</option>
                                        @foreach($transactionHeads as $transactionHead)
                                            <option value="{{ $transactionHead->HeadCode }}" {{ $transactionHead->HeadCode==10201 ? 'selected' : '' }}>{{ $transactionHead->HeadName }}</option>
                                        @endforeach
                                    </select>
                                    @error('cashCode')
                                    <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label text-right">bankCode <span class="text-danger"><b>*</b></span></label>
                                <div class="col-sm-4">
                                    <select name="bankCode" id="bankCode" class="form-control form-control-success select2">
                                        <option value="">Select Category</option>
                                        @foreach($transactionHeads as $transactionHead)
                                            <option value="{{ $transactionHead->HeadCode }}" {{ $transactionHead->HeadCode==10205 ? 'selected' : '' }}>{{ $transactionHead->HeadName }}</option>
                                        @endforeach
                                    </select>
                                    @error('bankCode')
                                        <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label text-right">advance <span class="text-danger"><b>*</b></span></label>
                                <div class="col-sm-4">
                                    <select name="advance" id="advance" class="form-control form-control-success select2">
                                        <option value="">Select Category</option>
                                        @foreach($transactionHeads as $transactionHead)
                                            <option value="{{ $transactionHead->HeadCode }}" {{ $transactionHead->HeadCode==10206 ? 'selected' : '' }}>{{ $transactionHead->HeadName }}</option>
                                        @endforeach
                                    </select>
                                    @error('advance')
                                    <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label text-right">fixedAsset <span class="text-danger"><b>*</b></span></label>
                                <div class="col-sm-4">
                                    <select name="fixedAsset" id="fixedAsset" class="form-control form-control-success select2">
                                        <option value="">Select Category</option>
                                        @foreach($transactionHeads as $transactionHead)
                                            <option value="{{ $transactionHead->HeadCode }}" {{ $transactionHead->HeadCode==101 ? 'selected' : '' }}>{{ $transactionHead->HeadName }}</option>
                                        @endforeach
                                    </select>
                                    @error('fixedAsset')
                                    <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label text-right">purchaseCode <span class="text-danger"><b>*</b></span></label>
                                <div class="col-sm-4">
                                    <select name="purchaseCode" id="purchaseCode" class="form-control form-control-success select2">
                                        <option value="">Select Category</option>
                                        @foreach($transactionHeads as $transactionHead)
                                            <option value="{{ $transactionHead->HeadCode }}" {{ $transactionHead->HeadCode==1020401 ? 'selected' : '' }}>{{ $transactionHead->HeadName }}</option>
                                        @endforeach
                                    </select>
                                    @error('purchaseCode')
                                        <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label text-right">salesCode <span class="text-danger"><b>*</b></span></label>
                                <div class="col-sm-4">
                                    <select name="salesCode" id="salesCode" class="form-control form-control-success select2">
                                        <option value="">Select Category</option>
                                        @foreach($transactionHeads as $transactionHead)
                                            <option value="{{ $transactionHead->HeadCode }}" {{ $transactionHead->HeadCode==3010301 ? 'selected' : '' }}>{{ $transactionHead->HeadName }}</option>
                                        @endforeach
                                    </select>
                                    @error('salesCode')
                                        <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label text-right">serviceCode <span class="text-danger"><b>*</b></span></label>
                                <div class="col-sm-4">
                                    <select name="serviceCode" id="serviceCode" class="form-control form-control-success select2">
                                        <option value="">Select Category</option>
                                        @foreach($transactionHeads as $transactionHead)
                                            <option value="{{ $transactionHead->HeadCode }}" {{ $transactionHead->HeadCode==3010401 ? 'selected' : '' }}>{{ $transactionHead->HeadName }}</option>
                                        @endforeach
                                    </select>
                                    @error('serviceCode')
                                        <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label text-right">customerCode <span class="text-danger"><b>*</b></span></label>
                                <div class="col-sm-4">
                                    <select name="customerCode" id="customerCode" class="form-control form-control-success select2">
                                        <option value="">Select Category</option>
                                        @foreach($transactionHeads as $transactionHead)
                                            <option value="{{ $transactionHead->HeadCode }}" {{ $transactionHead->HeadCode==1020801 ? 'selected' : '' }}>{{ $transactionHead->HeadName }}</option>
                                        @endforeach
                                    </select>
                                    @error('customerCode')
                                        <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label text-right">supplierCode <span class="text-danger"><b>*</b></span></label>
                                <div class="col-sm-4">
                                    <select name="supplierCode" id="supplierCode" class="form-control form-control-success select2">
                                        <option value="">Select Category</option>
                                        @foreach($transactionHeads as $transactionHead)
                                            <option value="{{ $transactionHead->HeadCode }}" {{ $transactionHead->HeadCode==5020201 ? 'selected' : '' }}>{{ $transactionHead->HeadName }}</option>
                                        @endforeach
                                    </select>
                                    @error('supplierCode')
                                        <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label text-right">costs_of_good_solds <span class="text-danger"><b>*</b></span></label>
                                <div class="col-sm-4">
                                    <select name="costs_of_good_solds" id="costs_of_good_solds" class="form-control form-control-success select2">
                                        <option value="">Select Category</option>
                                        @foreach($transactionHeads as $transactionHead)
                                            <option value="{{ $transactionHead->HeadCode }}" {{ $transactionHead->HeadCode==4010101 ? 'selected' : '' }}>{{ $transactionHead->HeadName }}</option>
                                        @endforeach
                                    </select>
                                    @error('costs_of_good_solds')
                                        <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label text-right">vat <span class="text-danger"><b>*</b></span></label>
                                <div class="col-sm-4">
                                    <select name="vat" id="vat" class="form-control form-control-success select2">
                                        <option value="">Select Category</option>
                                        @foreach($transactionHeads as $transactionHead)
                                            <option value="{{ $transactionHead->HeadCode }}" {{ $transactionHead->HeadCode==0 ? 'selected' : '' }}>{{ $transactionHead->HeadName }}</option>
                                        @endforeach
                                    </select>
                                    @error('vat')
                                        <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label text-right">tax <span class="text-danger"><b>*</b></span></label>
                                <div class="col-sm-4">
                                    <select name="tax" id="tax" class="form-control form-control-success select2">
                                        <option value="">Select Category</option>
                                        @foreach($transactionHeads as $transactionHead)
                                            <option value="{{ $transactionHead->HeadCode }}" {{ $transactionHead->HeadCode==4021101 ? 'selected' : '' }}>{{ $transactionHead->HeadName }}</option>
                                        @endforeach
                                    </select>
                                    @error('tax')
                                        <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label text-right">inventoryCode <span class="text-danger"><b>*</b></span></label>
                                <div class="col-sm-4">
                                    <select name="inventoryCode" id="inventoryCode" class="form-control form-control-success select2">
                                        <option value="">Select Category</option>
                                        @foreach($transactionHeads as $transactionHead)
                                            <option value="{{ $transactionHead->HeadCode }}" {{ $transactionHead->HeadCode==1020401 ? 'selected' : '' }}>{{ $transactionHead->HeadName }}</option>
                                        @endforeach
                                    </select>
                                    @error('inventoryCode')
                                        <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label text-right">CPLCode <span class="text-danger"><b>*</b></span></label>
                                <div class="col-sm-4">
                                    <select name="CPLCode" id="CPLCode" class="form-control form-control-success select2">
                                        <option value="">Select Category</option>
                                        @foreach($transactionHeads as $transactionHead)
                                            <option value="{{ $transactionHead->HeadCode }}" {{ $transactionHead->HeadCode==2010201 ? 'selected' : '' }}>{{ $transactionHead->HeadName }}</option>
                                        @endforeach
                                    </select>
                                    @error('CPLCode')
                                        <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label text-right">LPLCode <span class="text-danger"><b>*</b></span></label>
                                <div class="col-sm-4">
                                    <select name="LPLCode" id="LPLCode" class="form-control form-control-success select2">
                                        <option value="">Select Category</option>
                                        @foreach($transactionHeads as $transactionHead)
                                            <option value="{{ $transactionHead->HeadCode }}" {{ $transactionHead->HeadCode==2010202 ? 'selected' : '' }}>{{ $transactionHead->HeadName }}</option>
                                        @endforeach
                                    </select>
                                    @error('LPLCode')
                                        <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label text-right">salary_code <span class="text-danger"><b>*</b></span></label>
                                <div class="col-sm-4">
                                    <select name="salary_code" id="salary_code" class="form-control form-control-success select2">
                                        <option value="">Select Category</option>
                                        @foreach($transactionHeads as $transactionHead)
                                            <option value="{{ $transactionHead->HeadCode }}" {{ $transactionHead->HeadCode==4020501 ? 'selected' : '' }}>{{ $transactionHead->HeadName }}</option>
                                        @endforeach
                                    </select>
                                    @error('salary_code')
                                        <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label text-right">emp_npf_contribution <span class="text-danger"><b>*</b></span></label>
                                <div class="col-sm-4">
                                    <select name="emp_npf_contribution" id="emp_npf_contribution" class="form-control form-control-success select2">
                                        <option value="">Select Category</option>
                                        @foreach($transactionHeads as $transactionHead)
                                            <option value="{{ $transactionHead->HeadCode }}" {{ $transactionHead->HeadCode==4020502 ? 'selected' : '' }}>{{ $transactionHead->HeadName }}</option>
                                        @endforeach
                                    </select>
                                    @error('emp_npf_contribution')
                                        <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label text-right">empr_npf_contribution <span class="text-danger"><b>*</b></span></label>
                                <div class="col-sm-4">
                                    <select name="empr_npf_contribution" id="empr_npf_contribution" class="form-control form-control-success select2">
                                        <option value="">Select Category</option>
                                        @foreach($transactionHeads as $transactionHead)
                                            <option value="{{ $transactionHead->HeadCode }}" {{ $transactionHead->HeadCode==4020503 ? 'selected' : '' }}>{{ $transactionHead->HeadName }}</option>
                                        @endforeach
                                    </select>
                                    @error('empr_npf_contribution')
                                        <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label text-right">emp_icf_contribution <span class="text-danger"><b>*</b></span></label>
                                <div class="col-sm-4">
                                    <select name="emp_icf_contribution" id="emp_icf_contribution" class="form-control form-control-success select2">
                                        <option value="">Select Category</option>
                                        @foreach($transactionHeads as $transactionHead)
                                            <option value="{{ $transactionHead->HeadCode }}" {{ $transactionHead->HeadCode==4021201 ? 'selected' : '' }}>{{ $transactionHead->HeadName }}</option>
                                        @endforeach
                                    </select>
                                    @error('emp_icf_contribution')
                                        <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label text-right">empr_icf_contribution <span class="text-danger"><b>*</b></span></label>
                                <div class="col-sm-4">
                                    <select name="empr_icf_contribution" id="empr_icf_contribution" class="form-control form-control-success select2">
                                        <option value="">Select Category</option>
                                        @foreach($transactionHeads as $transactionHead)
                                            <option value="{{ $transactionHead->HeadCode }}" {{ $transactionHead->HeadCode==0 ? 'selected' : '' }}>{{ $transactionHead->HeadName }}</option>
                                        @endforeach
                                    </select>
                                    @error('empr_icf_contribution')
                                        <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label text-right">prov_state_tax <span class="text-danger"><b>*</b></span></label>
                                <div class="col-sm-4">
                                    <select name="prov_state_tax" id="prov_state_tax" class="form-control form-control-success select2">
                                        <option value="">Select Category</option>
                                        @foreach($transactionHeads as $transactionHead)
                                            <option value="{{ $transactionHead->HeadCode }}" {{ $transactionHead->HeadCode==5020101 ? 'selected' : '' }}>{{ $transactionHead->HeadName }}</option>
                                        @endforeach
                                    </select>
                                    @error('prov_state_tax')
                                        <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label text-right">state_tax <span class="text-danger"><b>*</b></span></label>
                                <div class="col-sm-4">
                                    <select name="state_tax" id="state_tax" class="form-control form-control-success select2">
                                        <option value="">Select Category</option>
                                        @foreach($transactionHeads as $transactionHead)
                                            <option value="{{ $transactionHead->HeadCode }}" {{ $transactionHead->HeadCode==4021101 ? 'selected' : '' }}>{{ $transactionHead->HeadName }}</option>
                                        @endforeach
                                    </select>
                                    @error('state_tax')
                                        <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label text-right">prov_npfcode <span class="text-danger"><b>*</b></span></label>
                                <div class="col-sm-4">
                                    <select name="prov_npfcode" id="prov_npfcode" class="form-control form-control-success select2">
                                        <option value="">Select Category</option>
                                        @foreach($transactionHeads as $transactionHead)
                                            <option value="{{ $transactionHead->HeadCode }}" {{ $transactionHead->HeadCode==5020102 ? 'selected' : '' }}>{{ $transactionHead->HeadName }}</option>
                                        @endforeach
                                    </select>
                                    @error('prov_npfcode')
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

@section('script')
    <script>
        $(function () {

            var subCategorySelected = '{{ old('sub_category') }}';

            $('#category').change(function () {
                var categoryId = $(this).val();

                $('#sub_category').html('<option value="">Select Sub Category</option>');

                if (categoryId != '') {
                    $.ajax({
                        method: "GET",
                        url: "{{ route('product.get_sub_category') }}",
                        data: { categoryId: categoryId }
                    }).done(function( data ) {
                        $.each(data, function( index, item ) {
                            if (subCategorySelected == item.id)
                                $('#sub_category').append('<option value="'+item.id+'" selected>'+item.name+'</option>');
                            else
                                $('#sub_category').append('<option value="'+item.id+'">'+item.name+'</option>');
                        });
                    });
                }
            });

            $('#category').trigger('change');
        });
    </script>
@endsection

