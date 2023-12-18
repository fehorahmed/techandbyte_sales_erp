@extends('layouts.app')
@section('title','All Product')
@section('content')
  <div class="page-body">
    <div class="row">
      <div class="col-sm-12">
        <div class="card">
          <div class="card-header table-card-header">
            <div class="d-inline" style="float: left">
                <h4>@yield('title')</h4>
            </div>
            <h5 style="float: right"><a href="{{ route('customer.customer_add') }}" class="btn btn-success">Add Product</a></h5>
          </div>
          <div class="card-block mt-4">
            <div class="dt-responsive table-responsive">
              <table id="table" class="table table-striped table-bordered nowrap">
                <thead>
                  <tr>
                    <th>SL.</th>
                    <th>Product Name</th>
                    <th>Supplier Name</th>
                    <th>Price</th>
                    <th>Supplier price</th>
                    <th>Image</th>
                    <th>Action</th>
                  </tr>
                </thead>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  @endsection

  @section('script')
    <script>
        $(function () {
            $('#table').DataTable({
                dom:'Bfrtip',
                processing: true,
                serverSide: true,
                buttons:['copy','csv','excel','pdf','print'],
                ajax: '{{ route('product.product_datatable') }}',
                columns: [
                    {data: 'DT_RowIndex', 'orderable': false, 'searchable': false },
                    {data: 'product_name', name: 'product_name'},
                    {data: 'supplierName', name: 'supplierName'},
                    {data: 'price', name: 'price'},
                    {data: 'supplierPrice', name: 'supplierPrice'},
                    {data: 'image', name: 'image'},
                    {data: 'action', name: 'action', orderable: false},
                ],
                "responsive": true, "autoWidth": false,
            });
        });
    </script>
@endsection
