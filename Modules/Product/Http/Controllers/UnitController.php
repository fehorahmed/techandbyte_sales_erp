<?php

namespace Modules\Product\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Product\Entities\Unit;
use Yajra\DataTables\Facades\DataTables;

class UnitController extends Controller{
    public function index(){
        return view('product::unit.all');
    }
    public function datatable(){
        $query = Unit::query();
        return DataTables::eloquent($query)
            ->addIndexColumn()
            ->addColumn('action', function(Unit $unit) {
                return '<a href="'.route('product.unit_edit',['unit'=>$unit->id]).'" class="btn-edit"><i style="color:#01a9ac;font-size: 17px;" class="feather icon-edit"></i></a>';
            })
            ->addColumn('status', function(Unit $unit) {
                if ($unit->status == 1)
                    return '<span class="badge badge-success">Active</span>';
                else
                    return '<span class="badge badge-danger">Inactive</span>';
            })
            ->rawColumns(['action','status'])
            ->toJson();
    }
    public function add(){
        return view('product::unit.add');
    }

    public function addPost(Request $request){
        $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required',
        ]);
        $unit = new Unit();
        $unit->name = $request->name;
        $unit->status = $request->status;
        $unit->created_by = Auth::user()->id;
        $unit->save();

        return redirect()->route('product.unit_all')->with('message','Information added');
    }

    public function edit(Unit $unit){
        return view('product::unit.edit', compact('unit'));
    }

    public function editPost(Request $request, Unit $unit){
        $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required',
        ]);
        $unit->name = $request->name;
        $unit->status = $request->status;
        $unit->save();

        return redirect()->route('product.unit_all')->with('message','Information updated');
    }

    public function delete($id){
        //
    }
}
