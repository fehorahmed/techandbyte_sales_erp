<?php

namespace Modules\Warehouse\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Modules\Warehouse\Entities\Warehouse;
use Yajra\DataTables\Facades\DataTables;

class WarehouseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //dd('sdf');
        return view('warehouse::warehouse.index');
    }

    public function datatable()
    {
        $query = Warehouse::with('creator');
        return DataTables::eloquent($query)
            ->addIndexColumn()
            ->addColumn('action', function (Warehouse $warehouse) {
                return '<a href="' . route('warehouse.edit', ['warehouse' => $warehouse->id]) . '" class="btn-edit"><i style="color:#01a9ac;font-size: 17px;" class="feather icon-edit"></i></a>';
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
        $request->validate([
            'name' => 'required|string|max:255|unique:warehouses,name',
            'address' => 'required|string|max:255',
            'status' => 'required|boolean',
        ]);

        $data = new Warehouse();
        $data->name = $request->name;
        $data->address = $request->address;
        $data->status = $request->status;
        $data->created_by = Auth::id();
        if ($data->save()) {
            return redirect()->route('warehouse.index')->with('message', 'Information added');
        } else {
            return redirect()->back()->with('error', 'Something went wrong');
        }
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

        $warehouse = Warehouse::findOrFail($id);

        return view('warehouse::warehouse.edit', compact('warehouse'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $warehouse): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:warehouses,name,' . $warehouse,
            'address' => 'required|string|max:255',
            'status' => 'required|boolean',
        ]);

        $data =  Warehouse::findOrFail($warehouse);
        $data->name = $request->name;
        $data->address = $request->address;
        $data->status = $request->status;

        if ($data->update()) {
            return redirect()->route('warehouse.index')->with('message', 'Information updated');
        } else {
            return redirect()->back()->with('error', 'Something went wrong');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
    }
}
