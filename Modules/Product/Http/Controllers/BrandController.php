<?php

namespace Modules\Product\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Modules\Product\Entities\Brand;
use Yajra\DataTables\Facades\DataTables;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('product::brand.index');
    }

    public function datatable()
    {
        $query = Brand::with('creator');
        return DataTables::eloquent($query)
            ->addIndexColumn()
            ->addColumn('action', function (Brand $brand) {
                return '<a href="' . route('product.brand_edit', ['brand' => $brand->id]) . '" class="btn-edit"><i style="color:#01a9ac;font-size: 17px;" class="feather icon-edit"></i></a>';
            })
            ->addColumn('status', function (Brand $brand) {
                if ($brand->status == 1)
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

        return view('product::brand.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required',
        ]);
        $category = new Brand();
        $category->name = $request->name;
        $category->status = $request->status;
        $category->created_by = Auth::user()->id;
        $category->save();

        return redirect()->route('product.brand_all')->with('message', 'Information added');
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('product::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $brand = Brand::findOrFail($id);

        return view('product::brand.edit', compact('brand'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Brand $brand): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required',
        ]);
        $brand->name = $request->name;
        $brand->status = $request->status;
        $brand->update();

        return redirect()->route('product.brand_all')->with('message', 'Information updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
    }
}
