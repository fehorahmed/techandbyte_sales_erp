@extends('layouts.app')
@section('title','Chart of Account')
@section('content')
    <div class="page-body">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header table-card-header">
                        <div class="d-inline" style="float: left">
                            <h4>@yield('title')</h4>
                        </div>
{{--                        <h5 style="float: right"><a href="{{ route('account.financialyear_add') }}" class="btn btn-success">Add Financial Year</a></h5>--}}
                    </div>
                    <div class="card-block mt-4">
                        <div class="row">
                            <div class="col-md-6">
                                <div id="jstree">
                                    <ul>
                                        <li class="jstree-open">COA
                                            <ul>
                                                @foreach($chartOfAccounts as $chartOfAccount)
                                                    <li class="jstree-open">
                                                        {{ $chartOfAccount->HeadName }}
                                                         <ul>
                                                             @if($chartOfAccount->coaSubAccounts)
                                                                 @foreach($chartOfAccount->coaSubAccounts as $account)
                                                                     <li>
                                                                         {{ $account->HeadName }}
                                                                         <ul>
                                                                             @if($account->coaSubAccounts)
                                                                                 @foreach($account->coaSubAccounts as $acc)
                                                                                     <li>
                                                                                         {{ $acc->HeadName }}
                                                                                         <ul>
                                                                                             @if($acc->coaSubAccounts)
                                                                                                 @foreach($acc->coaSubAccounts as $a)
                                                                                                     <li>{{ $a->HeadName }}</li>
                                                                                                 @endforeach
                                                                                             @endif
                                                                                         </ul>
                                                                                     </li>
                                                                                 @endforeach
                                                                             @endif
                                                                         </ul>
                                                                     </li>
                                                                 @endforeach
                                                             @endif
                                                         </ul>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label text-right">Head Code</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control is-valid-border" id="head_code" placeholder="Head Code">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label text-right">Head Name</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control is-valid-border" id="head_name" placeholder="Head Name">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label text-right">Parent Head</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control is-valid-border" id="parent_head" placeholder="Parent Head">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label text-right">Note No</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control is-valid-border" id="note_no">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label text-right"></label>
                                    <div class="col-sm-8">
                                        <input type="checkbox" class="form-control is-valid-border" id="note_no">
                                    </div>
                                </div>
                            </div>
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
            $('#jstree').jstree({
                "plugins" : [ "wholerow" ]
            });
            $('#table').DataTable({
                // dom:'Bfrtip',
                processing: true,
                serverSide: true,
                ajax: '{{ route('account.financialyear_datatable') }}',
                columns: [
                    {data: 'DT_RowIndex', 'orderable': false, 'searchable': false },
                    {data: 'yearName', name: 'yearName'},
                    {data: 'startDate', name: 'startDate'},
                    {data: 'endDate', name: 'endDate'},
                    {data: 'status', name: 'status'},
                    {data: 'action', name: 'action', orderable: false},
                ],
                "responsive": true, "autoWidth": false,
            });
        });
    </script>
@endsection
