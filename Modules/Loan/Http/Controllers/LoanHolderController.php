<?php

namespace Modules\Loan\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Modules\Loan\Entities\LoanHolder;
use Yajra\DataTables\Facades\DataTables;


class LoanHolderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('loan::loan_holder.index');
    }

    public function datatable()
    {
        $query = LoanHolder::query();
        return DataTables::eloquent($query)
            ->addIndexColumn()
            ->addColumn('action', function (LoanHolder $loanHolder) {
                return '<a href="' . route('loan.loan_holder_edit', ['loanHolder' => $loanHolder->id]) . '" class="btn-edit"><i style="color:#01a9ac;font-size: 17px;" class="feather icon-edit"></i></a>';
            })
            ->addColumn('status', function (LoanHolder $loanHolder) {
                if ($loanHolder->status == 1)
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
        return view('loan::loan_holder.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|digits:11',
            'address' => 'nullable|string|max:255',
            'status' => 'required',
        ]);

        try {
            DB::beginTransaction();
            $loanHolder = new LoanHolder();
            $loanHolder->name = $request->name;
            $loanHolder->phone = $request->phone;
            $loanHolder->address = $request->address;
            $loanHolder->status = $request->status;
            $loanHolder->created_by = Auth::user()->id;
            $loanHolder->save();


            DB::commit();
            return redirect()->route('loan.loan_holder_index')->with('message', 'Information added');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', $e)->withInput();
        }
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('loan::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(LoanHolder $loanHolder)
    {

        return view('loan::loan_holder.edit', compact('loanHolder'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(LoanHolder $loanHolder,Request $request): RedirectResponse
    {

        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|digits:11',
            'address' => 'nullable|string|max:255',
            'status' => 'required',
        ]);

        try {
            //dd($request->all());
            DB::beginTransaction();

            $loanHolder->name = $request->name;
            $loanHolder->phone = $request->phone;
            $loanHolder->address = $request->address;
            $loanHolder->status = $request->status;
            $loanHolder->updated_by = Auth::user()->id;
            $loanHolder->update();

            DB::commit();
            return redirect()->route('loan.loan_holder_index')->with('message', 'Information updated');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage())->withInput();
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


