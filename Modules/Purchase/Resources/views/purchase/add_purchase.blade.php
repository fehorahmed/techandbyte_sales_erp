@extends('layouts.app')
@section('title', 'Purchase Order')
@section('content')
    <div class="page-body">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header with-border">
                        <h3 class="card-title">Order Information</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form method="POST" action="{{ route('purchase.purchase_add') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="row pb-3">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Supplier<span class="text-danger">*</span></label>
                                        <select
                                            class="form-control form-control-success select2 supplier {{ $errors->has('supplier') ? 'is-invalid' : 'is-valid' }}"
                                            style="width: 100%;" id="supplier" name="supplier"
                                            data-placeholder="Select Supplier">
                                            <option value="">Select Supplier</option>
                                            @foreach ($suppliers as $supplier)
                                                <option value="{{ $supplier->id }}"
                                                    {{ old('supplier') == $supplier->id ? 'selected' : '' }}>
                                                    {{ $supplier->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('supplier')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <button type="button" id="add_new_supplier_form"
                                        style="margin-top: 32px;padding: 0px 8px;font-size: 15px;margin-left: -15px;"><span
                                            style="font-weight: bold;">+</span></button>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="lc_no">LC No.</label>
                                        <div class="input-group lc_no">
                                            <input type="text"
                                                class="form-control {{ $errors->has('lc_no') ? 'is-invalid' : 'is-valid' }}"
                                                name="lc_no" value="{{ old('lc_no') }}" placeholder="LC No.">
                                        </div>
                                        @error('lc_no')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Date</label>
                                        <div class="input-group date">
                                            <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>
                                            <input type="text"
                                                class="form-control pull-right date-picker {{ $errors->has('date') ? 'is-invalid' : 'is-valid' }}"
                                                id="date" name="date"
                                                value="{{ empty(old('date')) ? ($errors->has('date') ? '' : date('d-m-Y')) : old('date') }}"
                                                autocomplete="off">
                                        </div>
                                        @error('date')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="notes">Payment Details (Narration)</label>
                                        <div class="input-group purchase_details">
                                            <input type="text"
                                                class="form-control {{ $errors->has('purchase_details') ? 'is-invalid' : 'is-valid' }}"
                                                name="purchase_details" value="{{ old('purchase_details') }}"
                                                autocomplete="off">
                                        </div>
                                        @error('purchase_details')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th style="white-space: nowrap" width="30%">Product<span class="text-danger">*</span></th>
                                            <th style="white-space: nowrap" width="15%">Stock/Qty</th>
                                            <th style="white-space: nowrap" width="15%">Unit</th>
                                             <th style="white-space: nowrap" width="20%">Rate<span class="text-danger">*</span></th>
                                            <th style="white-space: nowrap" width="20%">Quantity<span class="text-danger">*</span></th>
                                            <th style="white-space: nowrap" width="15%">Total Cost</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody id="product-container">
                                        @if (old('product') != null && sizeof(old('product')) > 0)
                                            @foreach (old('product') as $item)
                                                <tr class="product-item">
                                                    <td>
                                                        <div class="form-group {{ $errors->has('product.' . $loop->index) ? 'has-error' : '' }}"
                                                            style="min-width: 200px;">
                                                            <select class="form-control product" style="width: 100%;"
                                                                id="product" name="product[]" required>
                                                                <option value="">Select Product</option>
                                                                @if (old('product.' . $loop->index) != '')
                                                                    <option value="{{ old('product.' . $loop->index) }}"
                                                                        selected>{{ old('product_name.' . $loop->index) }}
                                                                    </option>
                                                                @endif
                                                            </select>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div
                                                            class="form-group {{ $errors->has('stock.' . $loop->index) ? 'has-error' : '' }}">
                                                            <input type="text" step="any" class="form-control stock"
                                                                name="stock[]" value="{{ old('stock.' . $loop->index) }}"
                                                                readonly>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div
                                                            class="form-group {{ $errors->has('unit.' . $loop->index) ? 'has-error' : '' }}">
                                                            <input type="text" step="any" class="form-control unit"
                                                                name="unit[]" value="{{ old('unit.' . $loop->index) }}"
                                                                readonly>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div
                                                            class="form-group {{ $errors->has('product_rate.' . $loop->index) ? 'has-error' : '' }}">
                                                            <input type="text" class="form-control product_rate"
                                                                name="product_rate[]"
                                                                value="{{ old('product_rate.' . $loop->index) }}">
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div
                                                            class="form-group {{ $errors->has('quantity.' . $loop->index) ? 'has-error' : '' }}">
                                                            <input type="number" step="any"
                                                                class="form-control quantity" name="quantity[]"
                                                                value="{{ old('quantity.' . $loop->index) }}">
                                                        </div>
                                                    </td>
                                                    <td class="total-cost" style="vertical-align: middle">৳0.00</td>
                                                    <td class="text-center">
                                                        <a role="button" class="btn-sm btn-remove"
                                                            style="cursor: pointer;"><i
                                                                style="font-size: 20px; color:red;"
                                                                class="feather icon-trash-2"></i></a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr class="product-item">
                                                <td>
                                                    <div class="form-group product_area" style="min-width: 200px;">
                                                        <select class="form-control select2 product" style="width: 100%;"
                                                            name="product[]">
                                                            <option value="">Select Product</option>
                                                        </select>
                                                        <input type="hidden" name="product_name[]" class="product_name">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group">
                                                        <input type="text" step="any"
                                                            class="form-control stock is-valid-border" name="stock[]"
                                                            readonly>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group" style="min-width: 70px;">
                                                        <input type="text" step="any"
                                                            class="form-control unit is-valid-border" name="unit[]"
                                                            readonly>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group" style="min-width: 80px;">
                                                        <input type="text"
                                                            class="form-control product_rate is-valid-border"
                                                            name="product_rate[]">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group">
                                                        <input type="number" step="any"
                                                            class="form-control quantity is-valid-border"
                                                            name="quantity[]">
                                                    </div>
                                                </td>
                                                <td class="total-cost" style="vertical-align: middle">৳0.00</td>
                                                <td class="text-center">
                                                    <a role="button" class="btn-sm btn-remove"
                                                        style="cursor: pointer;"><i style="font-size: 20px; color:red;"
                                                            class="feather icon-trash-2"></i></a>
                                                </td>
                                            </tr>
                                        @endif
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td>
                                                <a role="button" class="btn btn-info btn-sm" id="btn-add-product">Add
                                                    Product</a>
                                            </td>
                                            <th colspan="4" class="text-right">Total Amount</th>
                                            <th id="total_amount">৳0.00</th>
                                            <td></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header with-border">
                                        <h3 class="card-title">Payment</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Payment Type</label>
                                                    <select class="form-control is-valid-border select2" name="payment_type" id="payment_type">
                                                        <option value="">Select Option</option>
                                                        <option value="1" {{ old('payment_type') == '1' ? 'selected' : '' }}>Cash</option>
                                                        <option value="2" {{ old('payment_type') == '2' ? 'selected' : '' }}>Bank</option>
                                                    </select>
                                                </div>
                                                <div id="isBankNature">
                                                    <div class="form-group">
                                                        <label>Bank</label>
                                                        <select class="form-control is-valid-border select2" name="bank">
                                                            <option value="">Select Bank</option>
                                                            @foreach($banks as $bank)
                                                                <option value="{{ $bank->id }}"{{ old('bank') == $bank->id ? ' selected' : '' }}>{{ $bank->bank_name }} (Ac : {{$bank->ac_number}})</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Cheque No.</label>
                                                        <input class="form-control is-valid-border" type="text" name="cheque_no" placeholder="Enter Cheque No." value="{{ old('cheque_no') }}">
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Cheque Image.</label>
                                                        <input type="file" name="cheque_image" class="form-control value="{{ old('cheque_image') }}">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <table class="table table-bordered">
                                                    <tr>
                                                        <th colspan="4" class="text-right">Duty</th>
                                                        <th>
                                                            <input type="number" step="any" id="duty"
                                                                class="form-control duty is-valid-border" value="{{old('duty')}}" name="duty">
                                                        </th>
                                                    </tr>
                                                    <tr>
                                                        <th colspan="4" class="text-right">Freight</th>
                                                        <th>
                                                            <input type="number" step="any" id="freight" value="{{old('freight')}}"
                                                                class="form-control freight is-valid-border"
                                                                name="freight">
                                                        </th>
                                                    </tr>
                                                    <tr>
                                                        <th colspan="4" class="text-right">C&F</th>
                                                        <th>
                                                            <input type="number" step="any" id="c_and_f" value="{{old('c_and_f')}}"
                                                                class="form-control c_and_f is-valid-border"
                                                                name="c_and_f">
                                                        </th>
                                                    </tr>
                                                    <tr>
                                                        <th colspan="4" class="text-right">AIT</th>
                                                        <th>
                                                            <input type="number" step="any" id="ait" value="{{old('ait')}}"
                                                                class="form-control ait is-valid-border" name="ait">
                                                        </th>
                                                    </tr>
                                                    <tr>
                                                        <th colspan="4" class="text-right">AT</th>
                                                        <th>
                                                            <input type="number" step="any" id="at" value="{{old('at')}}"
                                                                class="form-control at is-valid-border" name="at">
                                                        </th>
                                                    </tr>
                                                    <tr>
                                                        <th colspan="4" class="text-right">ETC</th>
                                                        <th>
                                                            <input type="number" step="any" id="etc" value="{{old('etc')}}"
                                                                class="form-control etc is-valid-border" name="etc">
                                                        </th>
                                                    </tr>
                                                    <tr>
                                                        <th colspan="4" class="text-right">Grand Total</th>
                                                        <th>
                                                            <input type="text" step="any"
                                                                class="form-control grand_total_price is-valid-border"
                                                                name="grand_total_price" readonly>
                                                        </th>
                                                    </tr>
                                                    <tr>
                                                        <th colspan="4" class="text-right"> Paid *</th>
                                                        <td>
                                                            <div
                                                                class="form-group {{ $errors->has('paid') ? 'has-error' : '' }}">
                                                                <input type="text" style="border: 2px solid #2a28a7"
                                                                    class="form-control is-valid-border" name="paid"
                                                                    id="paid" value="{{ old('paid', 0) }}" required>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th colspan="4" class="text-right">Due</th>
                                                        <th id="due">৳0.00</th>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <template id="template-product">
            <tr class="product-item">
                <td>
                    <div class="form-group product_area" style="min-width: 200px;">
                        <select class="form-control select2 product" style="width: 100%;" name="product[]">
                            <option value="">Select Product</option>
                        </select>
                        <input type="hidden" name="product_name[]" class="product_name">
                    </div>
                </td>
                <td>
                    <div class="form-group">
                        <input type="text" step="any" class="form-control stock is-valid-border" name="stock[]"
                            readonly>
                    </div>
                </td>
                <td>
                    <div class="form-group">
                        <input type="text" step="any" class="form-control  is-valid-border unit" name="unit[]"
                            readonly>
                    </div>
                </td>
                <td>
                    <div class="form-group">
                        <input type="text" class="form-control  is-valid-border product_rate" name="product_rate[]">
                    </div>
                </td>
                <td>
                    <div class="form-group">
                        <input type="number" step="any" class="form-control  is-valid-border quantity"
                            name="quantity[]">
                    </div>
                </td>

                <td class="total-cost" style="vertical-align: middle">৳0.00</td>
                <td class="text-center">
                    <a role="button" class="btn-sm btn-remove" style="cursor: pointer;"><i
                            style="font-size: 20px; color:red;" class="feather icon-trash-2"></i></a>
                </td>
            </tr>
        </template>
    </div>

    <!-- Modal for new Supplier-->
    <div class="modal fade" id="newSupplierModal" tabindex="-1" aria-labelledby="newSupplierModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" style="min-width: 50% !important">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" style="margin-left: 41% !important" id="newSupplierModalLabel">Supplier Info
                    </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form style="font-size: 12px;" enctype="multipart/form-data" id="newSupplierForm">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="lc_no">Supplier Name</label>
                                        <div class="input-group name">
                                            <input type="text"
                                                class="form-control {{ $errors->has('name') ? 'is-invalid' : 'is-valid-border' }}"
                                                name="name" value="{{ old('name') }}" placeholder="Name">
                                        </div>
                                        @error('name')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <div class="input-group lc_no">
                                            <input type="text"
                                                class="form-control {{ $errors->has('email') ? 'is-invalid' : 'is-valid-border' }}"
                                                name="email" value="{{ old('email') }}" placeholder="Email">
                                        </div>
                                        @error('email')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email">Phone</label>
                                        <div class="input-group phone">
                                            <input type="text"
                                                class="form-control {{ $errors->has('phone') ? 'is-invalid' : 'is-valid-border' }}"
                                                name="phone" value="{{ old('phone') }}" placeholder="Phone">
                                        </div>
                                        @error('phone')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="address">Address</label>
                                        <div class="input-group address">
                                            <textarea class="form-control is-valid-border" rows="1" name="address"></textarea>
                                        </div>
                                        @error('address')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-dark">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(function() {
            calculate();
            initSelect2();
            addProduct__delete();
            $('body').on('keyup',
                '.quantity, .product_rate,.discount_percent,.vat_percent,.product,#discount,#duty, #freight, #c_and_f,#ait,#at,#etc',
                function() {
                    calculate();
                });
            $('body').on('change',
                '.quantity, .product_rate,.discount_percent,.vat_percent,.product,#discount ,#duty, #freight, #c_and_f,#ait,#at,#etc',
                function() {
                    calculate();
                });

            $('#payment_type').change(function() {

                if ($(this).val() == '2') {
                    $('#isBankNature').show();
                } else {
                    $('#isBankNature').hide();
                }
            });
            $('#payment_type').trigger('change');

            $('#add_new_supplier_form').click(function() {
                $('#newSupplierModal').modal('show');
            });
            $('#newSupplierForm').submit(function(e) {
                e.preventDefault();
                let formData = new FormData($('#newSupplierForm')[0]);

                Swal.fire({
                    title: 'Are you sure?',
                    text: "You want to add the supplier!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#28a745',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes',
                    cancelButtonText: 'No',
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            method: "Post",
                            url: "{{ route('supplier.add_ajax_supplier') }}",
                            data: formData,
                            processData: false,
                            contentType: false,
                        }).done(function(response) {
                            if (response.success) {
                                $('#newSupplierModal').modal('hide');
                                Swal.fire(
                                    'Successfully',
                                    response.message,
                                    'success'
                                ).then((result) => {
                                    $(".supplier").append('<option value="' +
                                        response.supplier.id + '" selected>' +
                                        response.supplier.name + '</option>');
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: response.message,
                                });
                            }
                        });

                    }
                });
            });

            $(document).on('input', '#paid', function() {
                let total = $('.grand_total_price').val();
                let paid = $(this).val();
                let due = total - paid;
                $('#due').html('৳' + due.toFixed(2));
            });

        });
    </script>
    <script>
        function calculate() {
            let productSubTotal = 0;
            let productDiscountTotal = 0;
            let productVatTotal = 0;
            let discount = $("#discount").val() || "0";

            let duty = parseFloat($("#duty").val()) || 0;
            let freight = parseFloat($("#freight").val()) || 0;
            let c_and_f = parseFloat($("#c_and_f").val()) || 0;
            let ait = parseFloat($("#ait").val()) || 0;
            let at = parseFloat($("#at").val()) || 0;
            let etc = parseFloat($("#etc").val()) || 0;

            let total_others = (duty + freight + c_and_f + ait + at + etc);
          //  alert(total_others);

            $('.product-item').each(function(i) {
                let product_rate = $('.product_rate').eq(i).val();
                let quantity = $('.quantity').eq(i).val();
                let discount_percent = $('.discount_percent').eq(i).val();
                let vat_percent = $('.vat_percent').eq(i).val();

                if (product_rate == '' || product_rate < 0 || !$.isNumeric(product_rate)) {
                    product_rate = 0;
                }
                if (quantity == '' || quantity < 0 || !$.isNumeric(quantity)) {
                    quantity = 0;
                }
                if (discount_percent == '' || discount_percent < 0 || !$.isNumeric(discount_percent)) {
                    discount_percent = 0;
                }
                if (vat_percent == '' || vat_percent < 0 || !$.isNumeric(vat_percent)) {
                    vat_percent = 0;
                }
                let row_total_cost = quantity * product_rate;
                let row_discount_amount = row_total_cost * (discount_percent / 100);
                let row_without_discount_total_cost = row_total_cost - row_discount_amount;
                let row_vat_amount = row_without_discount_total_cost * (vat_percent / 100);

                productDiscountTotal += row_discount_amount;
                productVatTotal += row_vat_amount;

                $('.discount_value').eq(i).val(row_discount_amount);
                $('.vat_value').eq(i).val(row_vat_amount);
                $('.total-cost').eq(i).html('৳' + (row_total_cost - row_discount_amount).toFixed(2));
                productSubTotal += row_total_cost - row_discount_amount;
            });

            $('#total_amount').html('৳' + productSubTotal.toFixed(2));
            $('#product_sub_total').html('৳' + productSubTotal.toFixed(2));

            //discount formula
            // if (discount.includes('%')) {
            //    let discount_percent = discount.split('%')[0];
            //    purchase_discount_amount = (productSubTotal * discount_percent) / 100;
            //    $('.discount_percentage').val(discount_percent);
            // } else {
            //     purchase_discount_amount = discount;
            //     $('.discount_percentage').val(0);
            // }
            // $('.total_discount').val(productDiscountTotal + parseInt(purchase_discount_amount));
            // $('.total_vat').val(productVatTotal);

            let grandTotal = parseFloat(productSubTotal + total_others);
            // $('#purchase_discount').html(parseFloat(purchase_discount_amount).toFixed(2));

            $('#paid').val(grandTotal);
            let paid = $('#paid').val() || 0;

            let due = parseFloat(grandTotal) - parseFloat(paid);
            if (due < 0) {
                confirm('Due amount is not negative');
            }
            $('.grand_total_price').val(grandTotal.toFixed(2));
            // $('.purchase_discount').val(purchase_discount_amount);
            $('#due').html('৳' + due.toFixed(2));
        }

        function addProduct__delete() {
            $('#btn-add-product').click(function() {
                let html = $('#template-product').html();
                let item = $(html);
                $('#product-container').append(item);
                if ($('.product-item').length >= 1) {
                    $('.btn-remove').show();
                }
                initSelect2();
            });
            $('body').on('click', '.btn-remove', function() {
                $(this).closest('.product-item').remove();
                calculate();
                if ($('.product-item').length <= 1) {
                    $('.btn-remove').hide();
                }
            });
            if ($('.product-item').length <= 1) {
                $('.btn-remove').hide();
            } else {
                $('.btn-remove').show();
            }
        }

        function initSelect2() {
            $('.select2').select2();
            $('.product').select2({

                ajax: {
                    url: "{{ route('get_products_json') }}",
                    type: "get",
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            searchTerm: params.term, // search term
                        };
                    },
                    processResults: function(response) {
                        return {
                            results: response
                        };
                    },
                    cache: true
                }
            });
            $('.product').on('select2:select', function(e) {
                let data = e.params.data;
                let index = $(".product").index(this);
                $('.product_name:eq(' + index + ')').val(data.text);

                $(this).closest('tr').find('.unit').val(data.unit);
                $(this).closest('tr').find('.vat_percent').val(data.vat);
                // $(this).closest('tr').find('.product_rate').val(data.rate);
            });
        }
    </script>
@endsection
