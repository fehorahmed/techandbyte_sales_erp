<?php

namespace Modules\Client\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Client\Entities\ClientCategory;
use Yajra\DataTables\Facades\DataTables;

class ClientCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('client::client_category.index');
    }
    public function datatable()
    {
        $query = ClientCategory::query();
        return DataTables::eloquent($query)
            ->addIndexColumn()
            ->addColumn('action', function (ClientCategory $category) {
                return '<a href="' . route('client.category.edit', ['client_category' => $category->id]) . '" class="btn-edit"><i style="color:#01a9ac;font-size: 17px;" class="feather icon-edit"></i></a>';
            })
            ->addColumn('status', function (ClientCategory $category) {
                if ($category->status == 1)
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
        return view('client::client_category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:client_categories,name',
            'status' => 'required|boolean',
        ]);

        $data = new ClientCategory();
        $data->name = $request->name;
        $data->status = $request->status;
        if ($data->save()) {
            return redirect()->route('client.category.index')->with('message', 'Client category added successfully.');
        } else {
            return redirect()->back()->with('error', 'Something went wrong.');
        }
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('client::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ClientCategory $client_category)
    {
        return view('client::client_category.edit', compact('client_category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $client_category): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:client_categories,name,' . $client_category,
            'status' => 'required|boolean',
        ]);

        $data =  ClientCategory::findOrFail($client_category);
        $data->name = $request->name;
        $data->status = $request->status;
        if ($data->save()) {
            return redirect()->route('client.category.index')->with('message', 'Client category updated successfully.');
        } else {
            return redirect()->back()->with('error', 'Something went wrong.');
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
