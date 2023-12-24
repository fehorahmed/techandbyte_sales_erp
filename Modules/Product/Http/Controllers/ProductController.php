<?php

namespace Modules\Product\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Product\Entities\Brand;
use Modules\Product\Entities\Category;
use Modules\Product\Entities\Product;
use Modules\Product\Entities\SubCategory;
use Modules\Product\Entities\SupplierProduct;
use Modules\Product\Entities\Unit;
use Modules\Supplier\Entities\Supplier;
use Ramsey\Uuid\Uuid;
use Yajra\DataTables\Facades\DataTables;

class ProductController extends Controller
{

    public function index()
    {

        return view('product::product.all');
    }

    public function datatable()
    {
        $query = Product::with('supplierProduct', 'brand', 'category', 'unit', 'subCategory');
        return DataTables::eloquent($query)
            ->addIndexColumn()
            ->addColumn('action', function (Product $product) {
                return '<a href="' . route('product.product_edit', ['product' => $product->id]) . '" class="btn-edit"><i style="color:#01a9ac;font-size: 17px;" class="feather icon-edit"></i></a>';
            })
            // ->editColumn('supplierName', function (Product $product) {
            //     return $product->supplierProduct->supplier->name ?? '';
            // })
            ->editColumn('price', function (Product $product) {
                return number_format($product->price ?? '0', 2);
            })
            // ->editColumn('supplierPrice', function (Product $product) {
            //     return number_format($product->supplierProduct->supplier_price ?? '0', 2);
            // })
            ->addColumn('status', function (Product $category) {
                if ($category->status == 1)
                    return '<span class="badge badge-success">Active</span>';
                else
                    return '<span class="badge badge-danger">Inactive</span>';
            })

            ->addColumn('image', function (Product $product) {
                return '<img height="50px" src="' . asset($product->image) . '"   alt="">';
            })

            ->rawColumns(['action', 'status', 'image'])
            ->toJson();
    }

    public function add()
    {
        $brands = Brand::where('status', 1)->get();
        $categories = Category::where('status', 1)->get();
        $units = Unit::where('status', 1)->get();
        $suppliers = Supplier::where('status', 1)->get();
        return view('product::product.add', compact('categories', 'units', 'suppliers', 'brands'));
    }

    public function addPost(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'brand' => 'required|numeric',
            'category' => 'required|numeric',
            'sub_category' => 'required',
            // 'supplier' => 'required',
            'unit' => 'required|numeric',
            'sale_price' => 'nullable|numeric:20',
            'cost_price' => 'nullable|numeric:20',
            'product_details' => 'nullable|string:255',
            // 'product_vat' => 'nullable|numeric:11',
            'product_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'status' => 'required|boolean',
        ]);



        $product = new Product();
        $product->product_name = $request->name;
        $product->brand_id = $request->brand;
        $product->category_id = $request->category;
        $product->sub_category_id = $request->sub_category;
        $product->unit_id = $request->unit;
        $product->product_details = $request->product_details;
        $product->price = $request->sale_price;
        $product->status = $request->status;

        // Upload Image

        if ($request->product_image) {

            $file = $request->file('product_image');
            $filename = Uuid::uuid1()->toString() . '.' . $file->extension();
            $destinationPath = 'uploads/product_image';
            $file->move($destinationPath, $filename);
            $path = 'uploads/product_image/' . $filename;

            $product->image = $path;
        }

        $product->save();



        // $supplierProduct = new SupplierProduct();
        // $supplierProduct->supplier_id = $request->supplier;
        // $supplierProduct->product_id = $product->id;
        // $supplierProduct->supplier_price = $request->cost_price;
        // $supplierProduct->save();

        return redirect()->route('product.product_all')->with('message', 'Information added');
    }

    public function edit(Product $product)
    {
        $brands = Brand::where('status', 1)->get();
        $categories = Category::where('status', 1)->get();
        $units = Unit::where('status', 1)->get();
        $suppliers = Supplier::where('status', 1)->get();

        return view('product::product.edit', compact('product', 'categories', 'units', 'suppliers', 'brands'));
    }

    public function editPost(Product $product, Request $request)
    {

        $request->validate([
            'name' => 'required|string|max:255|unique:products,product_name,' . $product->id,
            'brand' => 'required|numeric',
            'category' => 'required|numeric',
            'sub_category' => 'required',
            // 'supplier' => 'required',
            'unit' => 'required|numeric',
            // 'sale_price' => 'nullable|numeric:20',
            // 'cost_price' => 'nullable|numeric:20',
            'product_details' => 'nullable|string:255',
            // 'product_vat' => 'nullable|numeric:11',
            'product_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'status' => 'required',
        ]);

        $product->product_name = $request->name;
        $product->category_id = $request->category;
        $product->sub_category_id = $request->sub_category;
        $product->unit_id = $request->unit;
        $product->product_details = $request->product_details;
        $product->price = $request->sale_price;
        $product->status = $request->status;

        // Upload Image

        if ($request->product_image) {
            if (file_exists($product->image)) {
                unlink($product->image);
            }

            $file = $request->file('product_image');
            $filename = Uuid::uuid1()->toString() . '.' . $file->extension();
            $destinationPath = 'uploads/product_image';
            $file->move($destinationPath, $filename);
            $path = 'uploads/product_image/' . $filename;

            $product->image = $path;
        }

        $product->save();



        // $supplierProduct = SupplierProduct::where('product_id', $product->id)->first();
        // $supplierProduct->supplier_id = $request->supplier;
        // $supplierProduct->product_id = $product->id;
        // $supplierProduct->supplier_price = $request->cost_price;
        // $supplierProduct->save();

        return redirect()->route('product.product_all')->with('message', 'Information updated');
    }

    public function destroy($id)
    {
        //
    }

    public function getSubCategory(Request $request)
    {
        $subCategories = SubCategory::where('category_id', $request->categoryId)
            ->orderBy('name')
            ->get()->toArray();
        return response()->json($subCategories);
    }
}
