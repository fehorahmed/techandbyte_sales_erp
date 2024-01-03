@extends('layouts.app')
@section('title','Expense List')
@section('content')
    <div class="page-body">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header table-card-header">
                        <div class="d-inline" style="float: left">
                            <h4>@yield('title')</h4>
                        </div>
                        <h5 style="float: right"><a href="{{ route('account.expense_add') }}" class="btn btn-success">Add Expense</a></h5>
                    </div>
                    <div class="card-block mt-4">
                        <div class="dt-responsive table-responsive">
                            <table id="table" class="table table-striped table-bordered nowrap">
                                <thead>
                                <tr>
                                    <th>SL</th>
                                    <th>Date</th>
                                    <th>Expense Item</th>
                                    <th>Debit</th>
                                    <th>Credit</th>
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
                ajax: '{{ route('account.expense_datatable') }}',
                columns: [
                    {data: 'DT_RowIndex', 'orderable': false, 'searchable': false },
                    {data: 'VDate', name: 'VDate'},
                    {data: 'Narration', name: 'Narration'},
                    {data: 'Debit', name: 'Debit'},
                    {data: 'Credit', name: 'Credit'},
                ],
                "responsive": true, "autoWidth": false,
            });


        });
    </script>
@endsection
