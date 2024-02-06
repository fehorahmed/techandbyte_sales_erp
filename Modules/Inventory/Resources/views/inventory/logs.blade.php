@extends('layouts.app')
@section('title', ' Inventory Log')
@section('content')
    <div class="page-body">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header table-card-header">
                        <div class="d-inline" style="float: left">
                            <h4>@yield('title')</h4>
                        </div>
                    </div>
                    <div class="card-block mt-4">
                        <div class="dt-responsive table-responsive">
                            <table id="table" class="table table-striped table-bordered nowrap">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Batch No</th>
                                        <th>Stock Type</th>
                                        <th>Quantity</th>
                                        <th>Remark</th>
                                        <th>Date</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($inv_logs as $log)
                                        <tr>
                                            <td>{{ $log->inventory->product->product_name }}</td>
                                            <td>{{ $log->inventory->batch_no }}</td>
                                            <td>{{ $log->type }}</td>
                                            <td>{{ $log->quantity }}</td>
                                            <td>{{ $log->remark }}</td>
                                            <td>{{ $log->created_at }}</td>
                                        </tr>
                                    @endforeach

                                </tbody>
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
                processing: true,
                serverSide: true,

                ajax: '{{ route('inventory.inventory_product_datatable') }}',
                columns: [{
                        data: 'product',
                        name: 'product'
                    },
                    {
                        data: 'batch_no',
                        name: 'batch_no'
                    },
                    {
                        data: 'quantity',
                        name: 'quantity'
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
