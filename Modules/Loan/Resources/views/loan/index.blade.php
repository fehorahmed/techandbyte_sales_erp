@extends('layouts.app')
@section('title', 'All Loans')
@section('style')
    <style>

    </style>
@endsection
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
                                    <th>Loan Holder</th>
                                    <th>Loan Type</th>
                                    <th>Date</th>
                                    <th>Details</th>
                                    <th>Amount</th>
                                    <th>Paid</th>
                                    <th>Due</th>
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
    <div class="modal fade" id="modal-pay">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Loan Payment</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <form id="modal-form" enctype="multipart/form-data" name="modal-form">
                        <div class="form-group">
                            <label>Total Loan Due</label>
                            <input  class="form-control" id="modal-order-due" readonly>
                        </div>
                        <input type="hidden" id="loan_id" name="loan_id">

                        <div class="form-group">
                            <label>Payment Type</label>
                            <select class="form-control" id="payment_type" name="payment_type">
                                <option value="1">Bank</option>
                                <option value="2">Cash</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Amount</label>
                            <input class="form-control" name="amount" id="amount" placeholder="Enter Amount">
                        </div>

                        <div class="form-group">
                            <label>Date</label>
                            <div class="input-group date">
                                <input type="date" class="form-control {{ $errors->has('date') ? 'is-invalid' : 'is-valid' }}" id="date" name="date" value="{{ old('date') }}" placeholder="Enter date">
                            </div>
                            <!-- /.input group -->
                        </div>

                        <div class="form-group">
                            <label>Note</label>
                            <input class="form-control" name="note" placeholder="Enter Note">
                        </div>
                    </form>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="modal-btn-pay">Pay</button>
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
                columns: [
                    {
                        data: 'loanHolder',
                        name: 'loanHolder'
                    },
                    {
                        data: 'type',
                        name: 'type'
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
                    }, {
                        data: 'paid',
                        name: 'paid'
                    }, {
                        data: 'due',
                        name: 'due'
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

            $('body').on('click', '#modal-btn-pay', function () {
                var formData = new FormData($('#modal-form')[0]);

                $.ajax({
                    type: "POST",
                    url: "{{ route('loan.loan_payment') }}",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.success) {
                            $('#modal-pay').modal('hide');
                            Swal.fire(
                                'Paid!',
                                response.message,
                                'success'
                            ).then((result) => {
                                //location.reload();
                                window.location.href = response.redirect_url;
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: response.message,
                                customClass: {
                                    container: 'swal-container-high-zindex'
                                }
                            });
                        }
                    }
                });
            });
            $('body').on('click', '.btn-pay', function () {
                var loanId = $(this).data('id'); // Change to customer ID
                var totalLoanDue = $(this).data('due'); // Get the total due from the data attribute

                $('#modal-order-due').val(totalLoanDue);
                $('#loan_id').val(loanId);
                $('#modal-pay').modal('show');
            });

        });
    </script>
@endsection
