<?php

namespace Modules\Product\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Product\Entities\Category;
use Modules\Product\Entities\SubCategory;
use Yajra\DataTables\Facades\DataTables;

class SubCategoryController extends Controller
{
    public function index(){
        return view('product::sub_category.all');
    }
    public function datatable(){
        $query = SubCategory::with('category');
        return DataTables::eloquent($query)
            ->addIndexColumn()
            ->addColumn('action', function(SubCategory $subCategory) {
                return '<a href="'.route('product.sub_category_edit',['subCategory'=>$subCategory->id]).'" class="btn-edit"><i style="color:#01a9ac;font-size: 17px;" class="feather icon-edit"></i></a>';
            })
            ->editColumn('category', function(SubCategory $subCategory) {
                return $subCategory->category->name ?? '';
            })
            ->addColumn('status', function(SubCategory $subCategory) {
                if ($subCategory->status == 1)
                    return '<span class="badge badge-success">Active</span>';
                else
                    return '<span class="badge badge-danger">Inactive</span>';
            })
            ->rawColumns(['action','status'])
            ->toJson();
    }
    public function add(){
        $categories=Category::where('status',1)->get();
        return view('product::sub_category.add',compact('categories'));
    }

    public function addPost(Request $request){
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required',
            'status' => 'required',
        ]);
        $subCategory = new SubCategory();
        $subCategory->name = $request->name;
        $subCategory->category_id = $request->category;
        $subCategory->status = $request->status;
        $subCategory->created_by = Auth::user()->id;
        $subCategory->save();

        return redirect()->route('product.sub_category_all')->with('message','Information added');
    }

    public function edit(SubCategory $subCategory){
        $categories=Category::where('status',1)->get();
        return view('product::sub_category.edit', compact('subCategory','categories'));
    }

    public function editPost(Request $request, SUbCategory $subCategory){
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required',
            'status' => 'required',
        ]);
        $subCategory->name = $request->name;
        $subCategory->category_id = $request->category;
        $subCategory->status = $request->status;
        $subCategory->save();

        return redirect()->route('product.sub_category_all')->with('message','Information updated');
    }

    public function delete($id){
        //
    }
}
