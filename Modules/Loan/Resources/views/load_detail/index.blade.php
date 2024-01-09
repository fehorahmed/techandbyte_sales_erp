@extends('layouts.app')
@section('title', 'Loan Details')
@section('content')
    <div class="page-body">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header table-card-header">
                        <div class="d-inline" style="float: left">
                            <h4>{{ $loan->title }}</h4>
                        </div>
                        <h5 style="float: right">
                            <button type="button" id="add_payment_form" class="btn btn-primary">Add Payment</button>

                            {{-- <a href="{{ route('loan.create') }}" class="btn btn-success">Details
                                Details</a> --}}
                        </h5>
                    </div>
                    <div class="card-block mt-4">
                        <div class="dt-responsive table-responsive">
                            <table id="table" class="table table-striped table-bordered nowrap">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Amount</th>
                                        <th>Transaction Type</th>
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
    <!-- Modal for new Payment-->
    <div class="modal fade" id="newPaymentModal" tabindex="-1" aria-labelledby="newPaymentModalLabel" aria-hidden="true">
        <div class="modal-dialog" style="min-width: 50% !important">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" style="margin-left: 41% !important" id="newPaymentModalLabel">Payment Info
                    </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form style="font-size: 12px;" enctype="multipart/form-data" id="newPaymentForm">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-4">
                                    <input type="hidden" name="loan_id" value="{{ $loan->id }}">
                                    <div class="form-group">
                                        <label for="date">Date</label>
                                        <div class="input-group date">
                                            <input type="date"
                                                class="form-control {{ $errors->has('date') ? 'is-invalid' : 'is-valid-border' }}"
                                                name="date" value="{{ old('date') }}" placeholder="date">
                                        </div>
                                        @error('date')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">

                                    <div class="form-group">
                                        <label for="transaction_type">Transaction Type</label>
                                        <select name="transaction_type" class="form-control" id="transaction_type">
                                            <option value="">Select One</option>
                                            <option value="1">Cash</option>
                                            <option value="2">Bank</option>
                                        </select>
                                        @error('transaction_type')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="amount">Amount</label>
                                        <div class="input-group lc_no">
                                            <input type="number"
                                                class="form-control {{ $errors->has('amount') ? 'is-invalid' : 'is-valid-border' }}"
                                                name="amount" value="{{ old('amount') }}" placeholder="amount">
                                        </div>
                                        @error('amount')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-dark">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(function() {

            $('#add_payment_form').click(function() {
                $('#newPaymentModal').modal('show');
            });
            $('#table').DataTable({
                dom: 'Bfrtip',
                processing: true,
                serverSide: true,
                buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
                ajax: '{{ route('loan.details.details_datatable', ['loan' => $loan->id]) }}',
                columns: [{
                        data: 'date',
                        name: 'date'
                    },
                    {
                        data: 'amount',
                        name: 'amount'
                    },
                    {
                        data: 'transaction_type',
                        name: 'transaction_type'
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

            $('#newPaymentForm').submit(function(e) {
                e.preventDefault();
                let formData = new FormData($('#newPaymentForm')[0]);

                Swal.fire({
                    title: 'Are you sure?',
                    text: "You want to add this payment!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#28a745',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes',
                    cancelButtonText: 'No',
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            method: "Post",
                            url: "{{ route('loan.details.payment.store') }}",
                            data: formData,
                            processData: false,
                            contentType: false,
                        }).done(function(response) {
                            if (response.status) {
                                $('#newPaymentModal').modal('hide');
                                Swal.fire(
                                    'Successfully',
                                    response.message,
                                    'success'
                                ).then((result) => {
                                    location.reload();
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: response.message,
                                });
                            }
                        });

                    }
                });
            });

        });
    </script>
@endsection
