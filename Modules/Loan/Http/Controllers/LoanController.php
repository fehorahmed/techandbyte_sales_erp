<?php

namespace Modules\Loan\Http\Controllers;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Modules\Loan\Entities\Loan;
use Modules\Loan\Entities\LoanDetail;
use Modules\Loan\Entities\LoanHolder;
use Illuminate\Support\Facades\DB;
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
        $query = Loan::with('creator','loanHolder','loan_holders');
        return DataTables::eloquent($query)
            ->addIndexColumn()
            ->addColumn('action', function (Loan $loan) {
                if($loan->paid == 0)
                $btn = '<a href="' . route('loan.edit', ['loan' => $loan->id]) . '" class="btn-edit"><i style="color:#01a9ac;font-size: 20px;" class="feather icon-edit mr-2"></i></a> ';
                else
                $btn='';
                if($loan->due != 0){
                    $btn.=  '<a role="button" data-id="'.$loan->id.'" data-due="'.$loan->due.'"  class="btn btn-success btn-pay">Payment</a> ';
                }
                $btn.=  '<a href="' . route('loan.details.index', ['loan' => $loan->id]) . '" class="btn btn-primary">Details</a> ';
                return $btn;
            })
            ->addColumn('loanHolder', function(Loan $loan) {
                return $loan->loanHolder->name ?? '';
            })
            ->filterColumn('loanHolder', function ($query, $keyword) {
                $query->whereHas('loan_holders', function ($q) use ($keyword) {
                    $q->where('name', 'like', '%' .$keyword. '%');
                });
            })

            ->rawColumns(['action'])
            ->toJson();
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $loanHolders = LoanHolder::get();
        return view('loan::loan.create',compact('loanHolders'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        //dd($request->all());
        $request->validate([
            "loan_holder" => 'required',
            "type" => 'required|string|max:255',
            "date" => 'required|date',
            "transaction_type" => 'required|string',
            "amount" => 'required|numeric|min:0',
            "details" => 'nullable|string|max:255',
        ]);

        $loan = new Loan();
        $loan->loan_holder_id = $request->loan_holder;
        $loan->type = $request->type;
        $loan->date = $request->date;
        $loan->amount = $request->amount;
        $loan->due = $request->amount;
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
        $loanHolders = LoanHolder::get();
        return view('loan::loan.edit', compact('loan','loanHolders'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): RedirectResponse
    {

        $request->validate([
            "loan_holder" => 'required',
            "type" => 'required|string|max:255',
            "date" => 'required|date',
            "transaction_type" => 'required|string',
            "amount" => 'required|numeric|min:0',
            "details" => 'nullable|string|max:255',
        ]);

        $loan = Loan::findOrFail($id);
        $loan->loan_holder_id = $request->loan_holder;
        $loan->type = $request->type;
        $loan->date = $request->date;
        $loan->amount = $request->amount;
        $loan->due = $request->amount;
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
    public function loanPayment(Request $request){
        $rules = [
            'payment_type' => 'required',
            'amount' => 'required|numeric|min:0',
            'date' => 'required|date',
            'note' => 'nullable|string|max:255',
        ];


        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
        }


        $loan = Loan::find($request->loan_id);

        $loanDue = $loan->due;

        $amountToPay = $request->amount;


        if($amountToPay>$loanDue){
            return response()->json(['message' => 'Given Amount is exceed due amount.']);
        }else {

            $loan->paid = $loan->paid+$amountToPay;
            $loan->due = $loanDue-$amountToPay;
            $loan->save();

            $loanDetail = new LoanDetail();
            $loanDetail->loan_id = $loan->id;
            $loanDetail->date = $request->date;
            $loanDetail->amount = $amountToPay;
            $loanDetail->transaction_type = $request->payment_type;
            $loanDetail->note = $request->note;
            $loanDetail->created_by =  auth()->id();
            $loanDetail->save();

        }

        return response()->json(['success' => true, 'message' => 'Payment has been completed.', 'redirect_url' => route('loan.index')]);
    }

}
