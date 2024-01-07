<?php

namespace Modules\Loan\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Loan\Entities\Loan;
use Yajra\DataTables\Facades\DataTables;

class LoanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        return view('loan::loan.index');
    }


    public function loanDatatable()
    {
        $query = Loan::with('creator');
        return DataTables::eloquent($query)
            ->addIndexColumn()
            ->addColumn('action', function (Loan $loan) {
                return '<a href="' . route('loan.edit', ['loan' => $loan->id]) . '" class="btn-edit"><i style="color:#01a9ac;font-size: 17px;" class="feather icon-edit mr-2"></i></a><a href="' . route('loan.details.index', ['loan' => $loan->id]) . '" class="btn btn-primary">Details</a>';
            })

            ->rawColumns(['action'])
            ->toJson();
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('loan::loan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        //dd($request->all());
        $request->validate([
            "title" => 'required|string|max:255|unique:loans,title',
            "type" => 'required|string|max:255',
            "date" => 'required|date',
            "transaction_type" => 'required|string',
            "amount" => 'required|numeric|min:0',
            "details" => 'nullable|string|max:255',
        ]);

        $loan = new Loan();
        $loan->title = $request->title;
        $loan->type = $request->type;
        $loan->date = $request->date;
        $loan->amount = $request->amount;
        $loan->transaction_type = $request->transaction_type;
        $loan->details = $request->details;
        $loan->created_by = auth()->id();
        if ($loan->save()) {
            return redirect()->route('loan.index')->with('message', 'Loan created successfully.');
        } else {
            return redirect()->back()->withInput()->with('error', 'Something went wrong.');
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
    public function edit($id)
    {
        $loan = Loan::findOrFail($id);
        return view('loan::loan.edit', compact('loan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): RedirectResponse
    {
        $request->validate([
            "title" => 'required|string|max:255|unique:loans,title,' . $id,
            "type" => 'required|string|max:255',
            "date" => 'required|date',
            "transaction_type" => 'required|string',
            "amount" => 'required|numeric|min:0',
            "details" => 'nullable|string|max:255',
        ]);

        $loan = Loan::findOrFail($id);
        $loan->title = $request->title;
        $loan->type = $request->type;
        $loan->date = $request->date;
        $loan->amount = $request->amount;
        $loan->transaction_type = $request->transaction_type;
        $loan->details = $request->details;
        $loan->created_by = auth()->id();
        if ($loan->save()) {
            return redirect()->route('loan.index')->with('message', 'Loan updated successfully.');
        } else {
            return redirect()->back()->withInput()->with('error', 'Something went wrong.');
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
