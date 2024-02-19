<?php

namespace Modules\Account\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Modules\Account\Entities\AccountHeadSubType;
use Modules\Account\Entities\AccountHeadType;
use Modules\Account\Entities\Cash;
use Modules\Account\Entities\Transaction;
use Modules\Account\Entities\TransactionLog;
use Modules\Bank\Entities\Bank;
use Ramsey\Uuid\Uuid;
use Yajra\DataTables\Facades\DataTables;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('account::transaction.index');
    }

    public function datatable()
    {
        $query = Transaction::with('headType', 'subHeadType');
        return DataTables::eloquent($query)
            ->addIndexColumn()
            ->addColumn('action', function (Transaction $transaction) {
                return '<a href="' . route('account.transaction_details', ['transaction' => $transaction->id]) . '" class="btn btn-sm btn-warning">Details</a>';
            })
            ->addColumn('headType', function (Transaction $transaction) {
                return $transaction->headType->name ?? '';
            })
            ->addColumn('subHeadType', function (Transaction $transaction) {
                return $transaction->subHeadType->name ?? '';
            })
            ->addColumn('transaction_type', function (Transaction $transaction) {
                if ($transaction->transaction_type == 1)
                    return '<span class="badge badge-success">Income</span>';
                else
                    return '<span class="badge badge-warning">Expense</span>';
            })
            ->editColumn('date', function (Transaction $transaction) {
                return date('d-m-Y', strtotime($transaction->date));
            })
            ->orderColumn('date', function ($query, $transaction) {
                $query->orderBy('date', $transaction)->orderBy('created_at', 'desc');
            })
            ->rawColumns(['action', 'transaction_type'])
            ->toJson();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $banks = Bank::get();
        return view('account::transaction.create', compact('banks'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {

        $validator = Validator::make($request->all(), [
            'type' => 'required|integer|min:1|max:2',
            'account_head_type' => 'required',
            'account_head_sub_type' => 'required',
            'payment_type' => 'required|integer|min:1|max:3',
            'amount' => 'required|numeric',
            'date' => 'required|date',
            'note' => 'nullable|string|max:255',
        ]);


        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }


        $validator->after(function ($validator) use ($request) {
            if ($request->type == 2) {
                if ($request->payment_type == 1) {
                    $cash = Cash::first();

                    if ($request->amount > $cash->amount)
                        $validator->errors()->add('amount', 'Insufficient balance.');
                } elseif ($request->payment_type == 2) {
                    $bankAccount = Bank::find($request->bank);

                    if ($request->amount > $bankAccount->amount)
                        $validator->errors()->add('amount', 'Insufficient balance2.');
                }
            }
        });

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {

            DB::beginTransaction();

            $image = null;
            if ($request->payment_type == 2) {
                if ($request->cheque_image) {
                    $image = 'img/no_image.png';

                    $file = $request->file('cheque_image');
                    $filename = Uuid::uuid1()->toString() . '.' . $file->extension();
                    $destinationPath = 'uploads/transaction_cheque';
                    $file->move($destinationPath, $filename);
                    $image = 'uploads/transaction_cheque/' . $filename;
                }
            }

            $transaction = new Transaction();
            $transaction->transaction_type = $request->type;
            $transaction->account_head_type_id = $request->account_head_type;
            $transaction->account_head_sub_type_id = $request->account_head_sub_type;
            $transaction->transaction_method = $request->payment_type;
            $transaction->bank_id = $request->payment_type == 2 ? $request->bank : null;
            $transaction->cheque_no = $request->payment_type == 2 ? $request->cheque_no : null;
            $transaction->cheque_date = date('Y-m-d', strtotime($request->cheque_date));
            $transaction->cheque_image = $image;
            $transaction->amount = $request->amount;
            $transaction->date = date('Y-m-d', strtotime($request->date));
            $transaction->note = $request->note;
            $transaction->save();
            $transaction->receipt_no = 1000 + $transaction->id;
            $transaction->save();


            if ($request->type == 1) {
                // Income
                if ($request->payment_type == 1) {
                    // Cash
                    Cash::first()->increment('amount', $request->amount);
                } elseif ($request->payment_type == 2) {
                    // Bank
                    Bank::find($request->bank)->increment('amount', $request->amount);
                }
            } else {
                // Expense
                if ($request->payment_type == 1) {
                    // Cash
                    Cash::first()->decrement('amount', $request->amount);
                } elseif ($request->payment_type == 2) {
                    // Bank
                    Bank::find($request->bank)->decrement('amount', $request->amount);
                }
            }

            $accountHeadSubType = AccountHeadSubType::find($request->account_head_sub_type);

            $log = new TransactionLog();
            $log->date = date('Y-m-d', strtotime($request->date));
            $log->particular = $accountHeadSubType->name;
            $log->transaction_type = $request->type;
            $log->transaction_method = $request->payment_type;
            $transaction->bank_id = $request->payment_type == 2 ? $request->bank : null;
            $transaction->cheque_no = $request->payment_type == 2 ? $request->cheque_no : null;
            $transaction->cheque_date = date('Y-m-d', strtotime($request->cheque_date));
            $transaction->cheque_image = $image;
            $log->amount = $request->amount;
            $log->note = $request->note;
            $log->transaction_id = $transaction->id;
            $log->save();


            DB::commit();
            return redirect()->route('account.transaction_all')->with('message', 'Transaction added');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }

        //        return redirect()->route('transaction.details', ['transaction' => $transaction->id]);

        //        return redirect()->route('account.transaction_all')->with('message', 'Information added successfully');
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
        return view('account::transaction.edit', compact('accountHeadSubType', 'accountHeads'));
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

        return redirect()->route('account.transaction_all')->with('message', 'Information updated successfully');
    }

    public function transactionDetails(Transaction $transaction)
    {
        return view('account::transaction.details', compact('transaction'));
    }
}
