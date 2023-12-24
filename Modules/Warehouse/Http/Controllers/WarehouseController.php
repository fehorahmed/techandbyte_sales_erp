<?php

namespace Modules\Warehouse\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Warehouse\Entities\Warehouse;
use Yajra\DataTables\Facades\DataTables;

class WarehouseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('warehouse::warehouse.index');
    }

    public function datatable()
    {
        $query = Warehouse::with('creator');
        return DataTables::eloquent($query)
            ->addIndexColumn()
            ->addColumn('action', function (Warehouse $warehouse) {
                return '<a href="' . route('warehouse.warehouse_edit', ['brand' => $warehouse->id]) . '" class="btn-edit"><i style="color:#01a9ac;font-size: 17px;" class="feather icon-edit"></i></a>';
            })
            ->addColumn('status', function (Warehouse $warehouse) {
                if ($warehouse->status == 1)
                    return '<span class="badge badge-success">Active</span>';
                else
                    return '<span class="badge badge-danger">Inactive</span>';
            })
            ->rawColumns(['action', 'status'])
            ->toJson();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('warehouse::warehouse.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        //
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('warehouse::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('warehouse::warehouse.edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): RedirectResponse
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
    }
}
