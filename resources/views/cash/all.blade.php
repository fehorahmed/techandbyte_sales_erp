@extends('layouts.app')
@section('title','Cash')
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
                    <th>SL</th>
                    <th>Amount</th>
                  </tr>
                </thead>
                  <tbody>
                    <tr>
                        <td>1</td>
                        <td>{{number_format($cash->amount,2)}}</td>
                    </tr>
                  </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  @endsection


