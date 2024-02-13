<?php

namespace Modules\Account\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Account\Entities\AccountHeadSubType;
use Modules\Account\Entities\AccountHeadType;
use Yajra\DataTables\Facades\DataTables;

class AccountHeadSubTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('account::account_sub_head.index');
    }

    public function datatable()
    {
        $query = AccountHeadSubType::with('accountHead');
        return DataTables::eloquent($query)
            ->addIndexColumn()
            ->addColumn('action', function (AccountHeadSubType $accountHeadSubType) {
                return '<a href="' . route('account.account_sub_head_edit', ['accountHeadSubType' => $accountHeadSubType->id]) . '" class="btn-edit"><i style="color:#01a9ac;font-size: 17px;" class="feather icon-edit"></i></a>';
            })
            ->addColumn('headName', function (AccountHeadSubType $accountHeadSubType) {
                    return $accountHeadSubType->accountHead->name ?? '';

            })
            ->addColumn('status', function (AccountHeadSubType $accountHeadSubType) {
                if ($accountHeadSubType->status == 1)
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
        $accountHeads = AccountHeadType::get();
        return view('account::account_sub_head.create',compact('accountHeads'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {

        $request->validate([
            'account_head_type_id' => 'required',
            'name' => 'required|string|max:255',
            'status' => 'required',
        ]);
        $accountHeadSubType = new AccountHeadSubType();
        $accountHeadSubType->name = $request->name;
        $accountHeadSubType->account_head_type_id = $request->account_head_type_id;
        $accountHeadSubType->status = $request->status;
        $accountHeadSubType->save();

        return redirect()->route('account.account_sub_head_all')->with('message', 'Information added successfully');
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
        $accountHeadSubType = AccountHeadSubType::findOrFail($id);
        $accountHeads = AccountHeadType::get();
        return view('account::account_sub_head.edit', compact('accountHeadSubType','accountHeads'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AccountHeadSubType $accountHeadSubType): RedirectResponse
    {
        $request->validate([
            'account_head_type_id' => 'required',
            'name' => 'required|string|max:255',
            'status' => 'required',
        ]);
        $accountHeadSubType->name = $request->name;
        $accountHeadSubType->account_head_type_id = $request->account_head_type_id;
        $accountHeadSubType->status = $request->status;
        $accountHeadSubType->update();

        return redirect()->route('account.account_sub_head_all')->with('message', 'Information updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
    }
}
