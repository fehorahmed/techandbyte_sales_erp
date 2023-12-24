@extends('layouts.app')
@section('title', 'All Product')
@section('content')
    <div class="page-body">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header table-card-header">
                        <div class="d-inline" style="float: left">
                            <h4>@yield('title')</h4>
                        </div>
                        <h5 style="float: right"><a href="{{ route('product.product_add') }}" class="btn btn-success">Add
                                Product</a></h5>
                    </div>
                    <div class="card-block mt-4">
                        <div class="dt-responsive table-responsive">
                            <table id="table" class="table table-striped table-bordered nowrap">
                                <thead>
                                    <tr>
                                        <th>SL.</th>
                                        <th>Product Name</th>
                                        <th>Brand</th>
                                        <th>Category</th>
                                        <th>Sub Category</th>
                                        <th>Unit</th>
                                        <th>Image</th>
                                        <th>Status</th>
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
        $(function() {
            $('#table').DataTable({
                dom: 'Bfrtip',
                processing: true,
                serverSide: true,
                buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
                ajax: '{{ route('product.product_datatable') }}',
                columns: [{
                        data: 'DT_RowIndex',
                        'orderable': false,
                        'searchable': false
                    },
                    {
                        data: 'product_name',
                        name: 'product_name'
                    },
                    {
                        data: 'brand.name',
                        name: 'brand'
                    },
                    {
                        data: 'category.name',
                        name: 'category'
                    },
                    {
                        data: 'sub_category.name',
                        name: 'subCategory',
                        defaultContent: ''
                    },
                    {
                        data: 'unit.name',
                        name: 'unit'
                    },
                    {
                        data: 'image',
                        name: 'image'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false
                    },
                ],
                "responsive": true,
                "autoWidth": false,
            });
        });
    </script>
@endsection
