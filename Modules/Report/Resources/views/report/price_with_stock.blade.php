@extends('layouts.app')

@section('style')
    <!-- bootstrap datepicker -->
    <link rel="stylesheet" href="{{ asset('themes/backend/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">

@endsection

@section('title')
  Price With Stock Report
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header with-border">
                    <h3 class="card-title">Filter</h3>
                </div>
                <!-- /.box-header -->

                <div class="card-body">
                    <form action="{{ route('report.price.with.stock') }}">
                        <div class="row">

                            <div class="col-md-3">
                                <div class="form-group row">
                                    <label>Category Item</label>

                                    <select class="form-control select2" name="product_item" required>
                                        <option value="all">All Category Item </option>
                                        @foreach($productItems as $productItem)
                                            <option value="{{ $productItem->id }}" {{ request()->get('product_item') == $productItem->id ? 'selected' : '' }}>{{ $productItem->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group row">
                                    <label>Warehouse</label>

                                    <select class="form-control select2" name="warehouse" required>
                                        <option value="all">All Warehouse </option>
                                        @foreach($warehouses as $warehouse)
                                            <option value="{{ $warehouse->id }}" {{ request()->get('warehouse') == $warehouse->id ? 'selected' : '' }}>{{ $warehouse->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group row">
                                    <label>Start Date</label>

                                    <div class="input-group date">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <input type="text" class="form-control pull-right"
                                               id="start" name="start" value="{{ request()->get('start')??date('Y-m-d')  }}" autocomplete="off" >
                                    </div>
                                    <!-- /.input group -->
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group row">
                                    <label>End Date</label>

                                    <div class="input-group date">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <input type="text" class="form-control pull-right"
                                               id="end" name="end" value="{{ request()->get('end')??date('Y-m-d')  }}" autocomplete="off" >
                                    </div>
                                    <!-- /.input group -->
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group row">
                                    <label>	&nbsp;</label>

                                    <input class="btn btn-primary form-control" type="submit" value="Submit">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @isset($inventories)
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <button class="pull-right btn btn-primary" onclick="getprint('prinarea')">Print</button><br><br>
                    <div id="prinarea">
                        <div class="row">
                            <div class="col-md-12">
                                    <h4 style="text-align: center !important">Price With Stock Report</h4>
                                    <h5 style="text-align: center !important">Stock Report upto {{date('d-m-Y')}}</h5>
                            </div>
                        </div>
                        <div class="table-responsive">
                        <table id="table" class="table table-bordered">
                            <thead>
                            <tr>
                                <th class="text-center">SL</th>
                                <th>Product Item</th>
                                <th>Category Item</th>
                                <th>Warehouse</th>
                                <th class="text-center">Stock (PCS)</th>
                                <th class="text-center">Unit Price (TK.)</th>
                                <th class="text-center">Total Price (TK.)</th>
                            </tr>
                            </thead>
                            <tbody>

                            <?php
                                $totalPrice = 0;
                            ?>

                            @foreach($inventories as $inventory)
                                <tr>
                                    <td class="text-center">{{$loop->iteration}}</td>
                                    <td>{{$inventory->productItem->name??''}}</td>
                                    <td>{{$inventory->productCategory->name??''}}</td>
                                    <td>{{$inventory->warehouse->name??''}}</td>
                                    <td class="text-right">{{$inventory->quantity}}</td>
                                    <td class="text-right">৳ {{number_format($inventory->unit_price,2)}}</td>
                                    <td class="text-right">৳ {{number_format($inventory->quantity*$inventory->unit_price,2)}}</td>
                                </tr>

                                <?php
                                    $totalPrice += $inventory->quantity * $inventory->unit_price;
                                ?>
                            @endforeach
                            </tbody>
                            <tfoot>
                            <tr>
                                <th class="text-center" style="border-right: 1px solid #fff !important;">Total= </th>
                                <th class="text-right" colspan="4">{{number_format($inventories->sum('quantity',2))}}</th>
                                <th colspan="3" class="text-right">৳ {{number_format($totalPrice, 2)}}</th>
                            </tr>
                            </tfoot>
                        </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    @endisset
@endsection

@section('script')
    <script src="{{ asset('themes/backend/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
    <script>
        $(function () {
            $('#table').DataTable();
        });
        $('#start, #end').datepicker({
            autoclose: true,
            format: 'yyyy-mm-dd'
        });
        var APP_URL = '{!! url()->full()  !!}';
        function getprint(print) {
            $('#table').DataTable().destroy();
            $('body').html($('#'+print).html());
            window.print();
            window.location.replace(APP_URL)
        }
    </script>
@endsection
