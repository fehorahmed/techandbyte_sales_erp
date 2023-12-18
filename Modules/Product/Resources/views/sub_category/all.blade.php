@extends('layouts.app')
@section('title','All Sub Category')
@section('content')
  <div class="page-body">
    <div class="row">
      <div class="col-sm-12">
        <div class="card">
          <div class="card-header table-card-header">
            <div class="d-inline" style="float: left">
                <h4>@yield('title')</h4>
            </div>
            <h5 style="float: right"><a href="{{ route('product.sub_category_add') }}" class="btn btn-success">Add Sub Category</a></h5>
          </div>
          <div class="card-block mt-4">
            <div class="dt-responsive table-responsive">
              <table id="table" class="table table-striped table-bordered nowrap">
                <thead>
                  <tr>
                    <th>Name</th>
                    <th>Category Name</th>
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
        $(function () {
            $('#table').DataTable({
                dom:'Bfrtip',
                processing: true,
                serverSide: true,
                buttons:['copy','csv','excel','pdf','print'],
                ajax: '{{ route('product.sub_category_datatable') }}',
                columns: [
                    {data: 'name', name: 'name'},
                    {data: 'category', name: 'category.name'},
                    {data: 'status', name: 'status'},
                    {data: 'action', name: 'action', orderable: false},
                ],
                "responsive": true, "autoWidth": false,
            });
        });
    </script>
@endsection
