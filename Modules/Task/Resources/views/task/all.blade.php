@extends('layouts.app')
@section('title', 'All Task')
@section('content')
    <div class="page-body">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header table-card-header">
                        <div class="d-inline" style="float: left">
                            <h4>@yield('title')</h4>
                        </div>
                        <h5 style="float: right"><a href="{{ route('task.task_add') }}" class="btn btn-success">Add
                                Task</a></h5>
                    </div>
                    <div class="card-block mt-4">
                        <div class="dt-responsive table-responsive">
                            <table id="table" class="table table-striped table-bordered nowrap">
                                <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th>Task Type</th>
                                        <th>Date</th>
                                        <th>User</th>
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
    <!-- Modal for Remarks-->
    <div class="modal fade" id="newRemarkModal" tabindex="-1" aria-labelledby="newRemarkModalLabel" aria-hidden="true">
        <div class="modal-dialog" style="min-width: 50% !important">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" style="margin-left: 41% !important" id="newRemarkModalLabel">Update Remark
                    </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form style="font-size: 12px;" enctype="multipart/form-data" id="newRemarkForm">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Remarks here</label>
                                        <div class="input-group name">
                                            <textarea name="remarks" class="form-contrl" id="remarks_text" cols="30" rows="10"></textarea>
                                            {{-- <input type="text"
                                                class="form-control {{ $errors->has('remarks') ? 'is-invalid' : 'is-valid-border' }}"
                                                name="remarks" value="{{ old('remarks') }}" placeholder="Name"> --}}
                                        </div>
                                        @error('remarks')
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
            $('#table').DataTable({
                dom: 'Bfrtip',
                processing: true,
                serverSide: true,
                buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
                ajax: '{{ route('task.task_datatable') }}',
                columns: [{
                        data: 'title',
                        name: 'title'
                    },
                    {
                        data: 'task_type',
                        name: 'task_type'
                    },
                    {
                        data: 'date',
                        name: 'date'
                    },
                    {
                        data: 'user.name',
                        name: 'user'
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


            $('#newRemarkForm').submit(function(e) {
                e.preventDefault();
                let formData = new FormData($('#newRemarkForm')[0]);

                Swal.fire({
                    title: 'Are you sure?',
                    text: "You want to add the supplier!",
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
                            url: "{{ route('supplier.add_ajax_supplier') }}",
                            data: formData,
                            processData: false,
                            contentType: false,
                        }).done(function(response) {
                            if (response.success) {
                                $('#newSupplierModal').modal('hide');
                                Swal.fire(
                                    'Successfully',
                                    response.message,
                                    'success'
                                ).then((result) => {
                                    $(".supplier").append('<option value="' +
                                        response.supplier.id + '" selected>' +
                                        response.supplier.name + '</option>');
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
