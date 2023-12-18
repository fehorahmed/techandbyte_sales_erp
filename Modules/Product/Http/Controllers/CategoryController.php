<?php

namespace Modules\Product\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Product\Entities\Category;
use Yajra\DataTables\Facades\DataTables;

class CategoryController extends Controller
{
    public function index(){
        return view('product::category.all');
    }
    public function datatable(){
        $query = Category::query();
        return DataTables::eloquent($query)
            ->addIndexColumn()
            ->addColumn('action', function(Category $category) {
                return '<a href="'.route('product.category_edit',['category'=>$category->id]).'" class="btn-edit"><i style="color:#01a9ac;font-size: 17px;" class="feather icon-edit"></i></a>';
            })
            ->addColumn('status', function(Category $category) {
                if ($category->status == 1)
                    return '<span class="badge badge-success">Active</span>';
                else
                    return '<span class="badge badge-danger">Inactive</span>';
            })
            ->rawColumns(['action','status'])
            ->toJson();
    }
    public function add(){
        return view('product::category.add');
    }

    public function addPost(Request $request){
        $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required',
        ]);
        $category = new Category();
        $category->name = $request->name;
        $category->status = $request->status;
        $category->created_by = Auth::user()->id;
        $category->save();

        return redirect()->route('product.category_all')->with('message','Information added');
    }

    public function edit(Category $category){
        return view('product::category.edit', compact('category'));
    }

    public function editPost(Request $request, Category $category){
        $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required',
        ]);
        $category->name = $request->name;
        $category->status = $request->status;
        $category->save();

        return redirect()->route('product.category_all')->with('message','Information updated');
    }

    public function delete($id){
        //
    }
}
