@extends('layouts.app')
@section('title','Bank List')
@section('content')
  <div class="page-body">
    <div class="row">
      <div class="col-sm-12">
        <div class="card">
          <div class="card-header table-card-header">
            <div class="d-inline" style="float: left">
                <h4>@yield('title')</h4>
            </div>
            <h5 style="float: right"><a href="{{ route('bank.bank_add') }}" class="btn btn-success">Add Bank</a></h5>
          </div>
          <div class="card-block mt-4">
            <div class="dt-responsive table-responsive">
              <table id="table" class="table table-striped table-bordered nowrap">
                <thead>
                  <tr>
                    <th>SL</th>
                    <th>Bank Name</th>
                    <th>A/C Name</th>
                    <th>A/C Number</th>
                    <th>Branch</th>
                    <th>Balance</th>
                    <th>Signature Picture</th>
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
                // dom:'Bfrtip',
                processing: true,
                serverSide: true,
                "buttons":['copy','csv','excel','pdf','print'],
                ajax: '{{ route('bank.bank_datatable') }}',
                "pagingType": "full_numbers",
                "dom": 'T<"clear">lfrtip',
                "lengthMenu": [[10, 25, 50, -1],[10, 25, 50, "All"]],
                columns: [
                    {data: 'DT_RowIndex', 'orderable': false, 'searchable': false },
                    {data: 'bank_name', name: 'bank_name'},
                    {data: 'ac_name', name: 'ac_name'},
                    {data: 'ac_number', name: 'ac_number'},
                    {data: 'branch', name: 'branch'},
                    {data: 'balance', name: 'balance'},
                    {data: 'signature_pic', name: 'signature_pic'},
                    {data: 'action', name: 'action', orderable: false},
                ],
                "responsive": true, "autoWidth": false,
            });
        });
    </script>
@endsection
