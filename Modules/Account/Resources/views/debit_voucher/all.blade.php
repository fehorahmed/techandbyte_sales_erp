@extends('layouts.app')
@section('title','Debit Voucher')
@section('content')
  <div class="page-body">
    <div class="row">
      <div class="col-sm-12">
        <div class="card">
          <div class="card-header table-card-header">
            <div class="d-inline" style="float: left">
                <h4>@yield('title')</h4>
            </div>
            <h5 style="float: right"><a href="{{ route('account.debit_voucher_add') }}" class="btn btn-success">Add Debit Voucher</a></h5>
          </div>
          <div class="card-block mt-4">
            <div class="dt-responsive table-responsive">
              <table id="table" class="table table-striped table-bordered nowrap">
                <thead>
                  <tr>
                    <th>SL</th>
                    <th>VNo</th>
                    <th>Date</th>
                    <th>Account Name</th>
                    <th>Ledger Comment</th>
                    <th>Sub Type</th>
                    <th>Debit</th>
                    <th>Credit</th>
                    <th>Reverse Account Name</th>
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

  <!-- Modal Debit Voucher Details-->
  <div class="modal fade" id="debitVoucherDetails" tabindex="-1" aria-labelledby="debitVoucherDetailsLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg" style="min-width: 76% !important">
          <div class="modal-content">
              <div class="modal-header">
                  <h4 class="modal-title" style="margin-left: 41% !important" id="debitVoucherDetailsLabel">Voucher Detail</h4>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <div class="modal-body">
                  <form style="font-size: 12px;" enctype="multipart/form-data"  id="stockEditForm">
                      <div class="container-fluid" id="debitVoucherContainer">

                      </div>
                      <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                      </div>
                  </form>
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
                ajax: '{{ route('account.debit_voucher_datatable') }}',
                columns: [
                    {data: 'DT_RowIndex', 'orderable': false, 'searchable': false },
                    {data: 'VNo', name: 'VNo'},
                    {data: 'VDate', name: 'VDate'},
                    {data: 'COAID', name: 'COAID'},
                    {data: 'ledgerComment', name: 'ledgerComment'},
                    {data: 'subType', name: 'subType'},
                    {data: 'Debit', name: 'Debit'},
                    {data: 'Credit', name: 'Credit'},
                    {data: 'RevCodde', name: 'RevCodde'},
                    {data: 'action', name: 'action', orderable: false},
                ],
                "responsive": true, "autoWidth": false,
            });

            $('body').on('click', '.btn-view', function () {
                $("#debitVoucherContainer").html(' ');
                var accVoucherId = $(this).data('id');
                if (accVoucherId != '') {
                    $.ajax({
                        method: "GET",
                        url: "{{ route('account.debit_voucher_view') }}",
                        data: {accVoucherId:accVoucherId}
                    }).done(function(response) {
                        $("#debitVoucherContainer").html(response.html);
                        $('#debitVoucherDetails').modal('show');

                    });
                }
            });

        });
    </script>
@endsection
