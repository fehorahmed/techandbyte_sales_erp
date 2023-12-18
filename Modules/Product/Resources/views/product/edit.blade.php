@extends('layouts.app')
@section('title','Product Edit')
@section('content')
    <div class="page-body">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-inline" style="float: left">
                            <h4>@yield('title')</h4>
                        </div>
                        <h5 style="float: right"><a href="{{ route('product.product_all') }}" class="btn btn-success">All Product</a></h5>
                    </div>
                    <div class="card-block mt-4">
                        <form id="main"  method="post" action="{{ route('product.product_edit',['product'=>$product->id]) }}" enctype="multipart/form-data">
                            @csrf

                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label text-right">Product Name <span class="text-danger"><b>*</b></span></label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control {{ $errors->has('name') ? 'is-invalid' :'is-valid' }}" name="name" value="{{ old('name',$product->product_name) }}" id="name" placeholder="Enter Name">
                                    @error('name')
                                    <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                                <label class="col-sm-2 col-form-label text-right">Supplier <span class="text-danger"><b>*</b></span></label>
                                <div class="col-sm-4">
                                    <select name="supplier" id="supplier" class="form-control form-control-success select2 {{ $errors->has('supplier') ? 'is-invalid' :'' }}">
                                        <option value="">Select Category</option>
                                        @foreach($suppliers as $supplier)
                                            <option value="{{ $supplier->id }}" {{ old('supplier',$product->supplierProduct->supplier_id) ==$supplier->id  ? 'selected' : '' }}>{{ $supplier->name ?? '' }}</option>
                                        @endforeach
                                    </select>
                                    @error('supplier')
                                    <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">

                                <label class="col-sm-2 col-form-label text-right">Category <span class="text-danger"><b>*</b></span></label>
                                <div class="col-sm-4">
                                    <select name="category" id="category" class="form-control form-control-success select2 {{ $errors->has('category') ? 'is-invalid' :'' }}">
                                        <option value="">Select Category</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" {{ old('category',$product->category_id) ==$category->id  ? 'selected' : '' }}>{{ $category->name ?? '' }}</option>
                                        @endforeach
                                    </select>
                                    @error('category')
                                    <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                                <label class="col-sm-2 col-form-label text-right">Sale Price</label>
                                <div class="col-sm-4">
                                    <input type="text" name="sale_price" value="{{old('sale_price',number_format($product->price,2))}}" class="form-control {{ $errors->has('sale_price') ? 'is-invalid' :'is-valid' }}"  placeholder="0.00">
                                    @error('sale_price')
                                    <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label text-right">Sub Category <span class="text-danger"><b>*</b></span></label>
                                <div class="col-sm-4">
                                    <select name="sub_category" id="sub_category" class="form-control form-control-success {{ $errors->has('sub_category') ? 'is-invalid' :'' }}">
                                        <option value="">Select Sub Category</option>
                                    </select>
                                    @error('sub_category')
                                    <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                                <label class="col-sm-2 col-form-label text-right">Cost Price</label>
                                <div class="col-sm-4">
                                    <input type="text" name="cost_price" value="{{old('cost_price',number_format($product->supplierProduct->supplier_price,2))}}" class="form-control {{ $errors->has('cost_price') ? 'is-invalid' :'is-valid' }}"  placeholder="0.00">
                                    @error('cost_price')
                                    <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>

                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label text-right">Unit</label>
                                <div class="col-sm-4">
                                    <select name="unit" id="unit" class="form-control form-control-success select2 {{ $errors->has('unit') ? 'is-invalid' :'' }}">
                                        <option value="">Select Unit</option>
                                        @foreach($units as $unit)
                                            <option value="{{ $unit->id }}" {{ old('unit',$product->unit_id) ==$unit->id  ? 'selected' : '' }}>{{ $unit->name ?? '' }}</option>
                                        @endforeach
                                    </select>
                                    @error('unit')
                                    <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                                <label class="col-sm-2 col-form-label text-right">Product Details</label>
                                <div class="col-sm-4">
                                    <textarea class="form-control {{ $errors->has('product_details') ? 'is-invalid' :'is-valid' }}" id="product_details" name="product_details" value="{{ old('product_details',$product->product_details ?? '') }}" placeholder="Enter your Product Details"></textarea>
                                    @error('product_details')
                                    <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>

                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label text-right">Product VAT %</label>
                                <div class="col-sm-4">
                                    <input type="text" name="product_vat" value="{{old('product_vat',$product->product_vat ?? '')}}" class="form-control {{ $errors->has('product_vat') ? 'is-invalid' :'is-valid' }}"  placeholder="Product VAT %">
                                    @error('product_vat')
                                    <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                                <label class="col-sm-2 col-form-label text-right">Image</label>
                                <div class="col-sm-4">
                                    <input type="file" name="product_image" class="form-control form-control-success {{ $errors->has('product_image') ? 'is-invalid' :'is-valid' }}">
                                    @if($product->image)
                                        <img width="100px" class="mt-2" src="{{ asset($product->image) }}" alt="">
                                    @endif
                                </div>

                                @error('product_image')
                                <span class="help-block">{{ $message }}</span>
                                @enderror

                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-check text-right">Status</label>
                                <div class="col-sm-4">
                                    <div class="form-radio">
                                        <div class="radio radiofill radio-primary radio-inline">
                                            <label>
                                                <input type="radio" name="status" value="1" {{ old('status','1') == '1' ? 'checked' : '' }} data-bv-field="status">
                                                <i class="helper"></i>Active
                                            </label>
                                        </div>
                                        <div class="radio radiofill radio-primary radio-inline">
                                            <label>
                                                <input type="radio" name="status" value="0" {{ old('status') == '0' ? 'checked' : '' }} data-bv-field="status">
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

@section('script')
    <script>
        $(function () {

            var subCategorySelected = '{{ empty(old('sub_category')) ? ($errors->has('sub_category') ? '' : $product->sub_category_id) : old('sub_category') }}';

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

