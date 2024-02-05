@extends('layouts.app')
@section('title','All Inventory Receipt')
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
                                    <th>Date</th>
                                    <th>Order No</th>
                                    <th>Batch No</th>
                                    <th>Supplier</th>
                                    <th>Total</th>
                                    <th>Paid</th>
                                    <th>Due</th>
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
                processing: true,
                serverSide: true,

                ajax: '{{ route('inventory.inventory_receipt_datatable') }}',
                columns: [
                    {data: 'purchase_date', name: 'purchase_date'},
                    {data: 'chalan_no', name: 'chalan_no'},
                    {data: 'batch_no', name: 'batch_no'},
                    {data: 'supplier', name: 'supplier'},
                    {data: 'grand_total_amount', name: 'grand_total_amount'},
                    {data: 'paid_amount', name: 'paid_amount'},
                    {data: 'due_amount', name: 'due_amount'},
                    {data: 'action', name: 'action', orderable: false},
                ],
                "responsive": true, "autoWidth": false,
            });
        });
    </script>
@endsection
