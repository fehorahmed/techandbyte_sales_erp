@extends('layouts.app')
@section('title', 'All Loans')
@section('content')
    <div class="page-body">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header table-card-header">
                        <div class="d-inline" style="float: left">
                            <h4>@yield('title')</h4>
                        </div>
                        <h5 style="float: right"><a href="{{ route('loan.create') }}" class="btn btn-success">Add
                                Loan</a></h5>
                    </div>
                    <div class="card-block mt-4">
                        <div class="dt-responsive table-responsive">
                            <table id="table" class="table table-striped table-bordered nowrap">
                                <thead>
                                    <tr>
                                        <th>Loan Type</th>
                                        <th>Title</th>
                                        <th>Date</th>
                                        <th>Details</th>
                                        <th>Amount</th>
                                        <th>Created By</th>
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
                ajax: '{{ route('loan.loan_datatable') }}',
                columns: [{
                        data: 'type',
                        name: 'type'
                    }, {
                        data: 'title',
                        name: 'title'
                    },
                    {
                        data: 'date',
                        name: 'date'
                    },
                    {
                        data: 'details',
                        name: 'details'
                    },
                    {
                        data: 'amount',
                        name: 'amount'
                    },
                    {
                        data: 'creator.name',
                        name: 'created_by',
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
