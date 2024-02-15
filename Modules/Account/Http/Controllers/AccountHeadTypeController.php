<?php

namespace Modules\Account\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Modules\Account\Entities\AccountHeadType;
use Yajra\DataTables\Facades\DataTables;

class AccountHeadTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('account::account_head_type.index');
    }

    public function datatable()
    {
        $query = AccountHeadType::query();
        return DataTables::eloquent($query)
            ->addIndexColumn()
            ->addColumn('action', function (AccountHeadType $accountHeadType) {
                return '<a href="' . route('account.account_head_type_edit', ['accountHeadType' => $accountHeadType->id]) . '" class="btn-edit"><i style="color:#01a9ac;font-size: 17px;" class="feather icon-edit"></i></a>';
            })
            ->addColumn('status', function (AccountHeadType $accountHeadType) {
                if ($accountHeadType->status == 1)
                    return '<span class="badge badge-success">Active</span>';
                else
                    return '<span class="badge badge-danger">Inactive</span>';
            })
            ->addColumn('type', function (AccountHeadType $accountHeadType) {
                if ($accountHeadType->transaction_type == 1)
                    return '<span class="badge badge-primary">Income</span>';
                else
                    return '<span class="badge badge-warning">Expense</span>';
            })
            ->rawColumns(['action', 'status','type'])
            ->toJson();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        return view('account::account_head_type.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {

        $request->validate([
            'type' => 'required',
            'name' => 'required|string|max:255',
            'status' => 'required',
        ]);
        $accountHeadType = new AccountHeadType();
        $accountHeadType->name = $request->name;
        $accountHeadType->transaction_type = $request->type;
        $accountHeadType->status = $request->status;
        $accountHeadType->save();

        return redirect()->route('account.account_head_type_all')->with('message', 'Information added successfully');
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('account::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $accountHeadType = AccountHeadType::findOrFail($id);

        return view('account::account_head_type.edit', compact('accountHeadType'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AccountHeadType $accountHeadType): RedirectResponse
    {
        $request->validate([
            'type' => 'required',
            'name' => 'required|string|max:255',
            'status' => 'required',
        ]);
        $accountHeadType->name = $request->name;
        $accountHeadType->transaction_type = $request->type;
        $accountHeadType->status = $request->status;
        $accountHeadType->update();

        return redirect()->route('account.account_head_type_all')->with('message', 'Information updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
    }
}
