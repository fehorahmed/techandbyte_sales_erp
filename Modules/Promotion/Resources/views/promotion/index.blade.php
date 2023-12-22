@extends('layouts.app')
@section('title', 'All Promotion')
@section('content')
    <div class="page-body">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header table-card-header">
                        <div class="d-inline" style="float: left">
                            <h4>@yield('title')</h4>
                        </div>
                        <h5 style="float: right"><a href="{{ route('promotion.create') }}" class="btn btn-success">Add
                                Promotion</a></h5>
                    </div>
                    <div class="card-block mt-4">
                        <div class="dt-responsive table-responsive">
                            <table id="table" class="table table-striped table-bordered nowrap">
                                <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th>Type</th>
                                        <th>Platform</th>
                                        <th>Cost</th>
                                        <th>Details</th>
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
                ajax: '{{ route('promotion.promotion_datatable') }}',
                columns: [{
                        data: 'title',
                        name: 'title'
                    },
                    {
                        data: 'promotion_type',
                        name: 'promotion_type'
                    },
                    {
                        data: 'platform',
                        name: 'platform'
                    },
                    {
                        data: 'cost',
                        name: 'cost'
                    },
                    {
                        data: 'details',
                        name: 'details'
                    },
                    {
                        data: 'created_by',
                        name: 'creator.name'

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
