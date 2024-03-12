<?php

namespace Modules\Promotion\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Modules\Account\Entities\Cash;
use Modules\Account\Entities\TransactionLog;
use Modules\Bank\Entities\Bank;
use Modules\Promotion\Entities\Promotion;
use Ramsey\Uuid\Uuid;
use Yajra\DataTables\Facades\DataTables;

class PromotionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('promotion::promotion.index');
    }

    public function datatable()
    {
        $query = Promotion::with('creator');
        return DataTables::eloquent($query)
            ->addIndexColumn()
            ->addColumn('action', function (Promotion $promotion) {
                return '<a href="' . route('promotion.edit', ['promotion' => $promotion->id]) . '" class="btn-edit"><i style="color:#01a9ac;font-size: 17px;" class="feather icon-edit"></i></a>';
            })
            ->rawColumns(['action'])
            ->toJson();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $banks = Bank::where('status', 1)->get();
        return view('promotion::promotion.create', compact('banks'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {

        $request->validate([
            "title" => 'required|string|max:255|unique:promotions,title',
            "promotion_type" => 'required|string|max:255',
            "platform" => 'required|string|max:255',
            "transaction_method" => 'required|numeric',
            "bank" => 'nullable|numeric|required_if:transaction_method,2',
            "branch_id" => 'nullable|numeric',
            "bank_account_id" => 'nullable|numeric',
            "cheque_no" => 'nullable|string|required_if:transaction_method,2',
            "cheque_image" => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            "cost" => 'required|numeric',
            "date" => 'required|date|max:255',
            "details" => 'nullable|string|max:255',
        ]);

        if ($request->transaction_method == 1) {
            $cash = Cash::first();
            if (!$cash) {
                return redirect()->back()->withInput()->with('error', 'Cash amount not found.');
            }
            if ($cash->amount < $request->cost) {
                return redirect()->back()->withInput()->with('error', 'Cash not have enough balance.');
            }
        }

        if ($request->transaction_method == 2) {
            $bank = Bank::findOrFail($request->bank);
            if (!$bank) {
                return redirect()->back()->withInput()->with('error', 'Bank not found.');
            }
            if ($bank->amount < $request->cost) {
                return redirect()->back()->withInput()->with('error', 'Bank account not have enough balance.');
            }
        }

        $transactionFail = false;
        DB::beginTransaction();
        try {
            $data = new Promotion();
            $data->title = $request->title;
            $data->promotion_type = $request->promotion_type;
            if ($request->transaction_method == 1) {
                $data->transaction_method = $request->transaction_method;
            } elseif ($request->transaction_method == 2) {
                $data->transaction_method = $request->transaction_method;
                $data->bank_id = $request->bank;
                $data->branch_id = $request->branch_id;
                $data->bank_account_id = $request->bank_account_id;
                $data->cheque_no = $request->cheque_no;
                if ($request->cheque_image) {
                    $image = 'img/no_image.png';

                    $file = $request->file('cheque_image');
                    $filename = Uuid::uuid1()->toString() . '.' . $file->extension();
                    $destinationPath = 'uploads/transaction_cheque';
                    $file->move($destinationPath, $filename);
                    $image = 'uploads/transaction_cheque/' . $filename;
                    $data->cheque_image = $image;
                }
            }
            $data->platform = $request->platform;
            $data->cost = $request->cost;
            $data->date = $request->date;
            $data->details = $request->details;
            $data->created_by = Auth::id();
            if ($data->save()) {

                $transaction_log = new TransactionLog();
                $transaction_log->date = now();
                $transaction_log->particular = "promotion head";
                $transaction_log->transaction_type = 2;
                if ($request->transaction_method == 1) {
                    $transaction_log->transaction_method = $request->transaction_method;
                } elseif ($request->transaction_method == 2) {
                    $transaction_log->transaction_method = $request->transaction_method;
                    $transaction_log->bank_id = $request->bank;
                    $transaction_log->branch_id = $request->branch_id;
                    $transaction_log->bank_account_id = $request->bank_account_id;
                    $transaction_log->cheque_no = $request->cheque_no;
                    if ($request->cheque_image) {
                        $transaction_log->cheque_image = $image;
                    }
                }
                $transaction_log->amount = $request->cost;
                $transaction_log->promotion_id = $data->id;
                if ($transaction_log->save()) {
                    if ($request->transaction_method == 1) {
                        $cash->amount = $cash->amount - $request->cost;
                        if (!$cash->save()) {
                            $transactionFail = true;
                        }
                    } elseif ($request->transaction_method == 2) {
                        $bank->amount = $bank->amount - $request->cost;
                        if (!$bank->save()) {
                            $transactionFail = true;
                        }
                    }
                } else {
                    $transactionFail = true;
                }
            } else {

                $transactionFail = true;
            }

            if ($transactionFail == false) {

                DB::commit();

                return redirect()->route('promotion.index')->with('message', 'Information added');
            } else {
                DB::rollBack();
                return redirect()->back()->withInput()->with('error', 'Something went wrong.');
            }
        } catch (\Throwable $th) {
            //throw $th;

            DB::rollBack();
            return redirect()->back()->withInput()->with('error', $th->getMessage());
        }
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('promotion::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $data = Promotion::findOrFail($id);
        $banks = Bank::all();
        return view('promotion::promotion.edit', compact('data', 'banks'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $promotion): RedirectResponse
    {
        $request->validate([
            "title" => 'required|string|max:255|unique:promotions,title,' . $promotion,
            "promotion_type" => 'required|string|max:255',
            "platform" => 'required|string|max:255',
            "transaction_method" => 'required|numeric',
            "bank" => 'nullable|numeric|required_if:transaction_method,2',
            "branch_id" => 'nullable|numeric',
            "bank_account_id" => 'nullable|numeric',
            "cheque_no" => 'nullable|string|required_if:transaction_method,2',
            "cheque_image" => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            "cost" => 'required|numeric',
            "date" => 'required|date|max:255',
            "details" => 'nullable|string|max:255',
        ]);
        $ck_data =  Promotion::findOrFail($promotion);
        if ($request->transaction_method == 1) {
            $ck_cash = Cash::first();
            if (!$ck_cash) {
                return redirect()->back()->withInput()->with('error', 'Cash amount not found.');
            }
            if (($ck_cash->amount + $ck_data->cost) < $request->cost) {
                return redirect()->back()->withInput()->with('error', 'Cash not have enough balance.');
            }
        }
        if ($request->transaction_method == 2) {
            $ck_bank = Bank::findOrFail($request->bank);
            if (!$ck_bank) {
                return redirect()->back()->with('error', 'Bank not found.');
            }
            if (($ck_bank->amount + $ck_data->cost) < $request->cost) {
                return redirect()->back()->with('error', 'Bank account not have enough balance.');
            }
        }

        $transactionFail = false;
        try {
            $data =  Promotion::findOrFail($promotion);
            $data->title = $request->title;
            $data->promotion_type = $request->promotion_type;

            // Revert Log

            if ($data->transaction_method == 1) {
                // $data->transaction_method = $request->transaction_method;
                $c_cash = Cash::first();
                $c_cash->amount = $c_cash->amount + $data->cost;
                $c_cash->save();
            } elseif ($data->transaction_method == 2) {
                $b_bank = Bank::find($data->bank_id);
                $b_bank->amount = $b_bank->amount + $data->cost;
                $b_bank->save();
            }

            if ($request->transaction_method == 1) {
                $data->transaction_method = $request->transaction_method;
            } elseif ($request->transaction_method == 2) {
                $data->transaction_method = $request->transaction_method;
                $data->bank_id = $request->bank;
                $data->branch_id = $request->branch_id;
                $data->bank_account_id = $request->bank_account_id;
                $data->cheque_no = $request->cheque_no;
                if ($request->cheque_image) {
                    $image = 'img/no_image.png';
                    if (Storage::exists($data->cheque_image)) {
                        Storage::delete($data->cheque_image);
                    }
                    $file = $request->file('cheque_image');
                    $filename = Uuid::uuid1()->toString() . '.' . $file->extension();
                    $destinationPath = 'uploads/transaction_cheque';
                    $file->move($destinationPath, $filename);
                    $image = 'uploads/transaction_cheque/' . $filename;
                    $data->cheque_image = $image;
                }
            }
            $data->platform = $request->platform;
            $data->cost = $request->cost;
            $data->date = $request->date;
            $data->details = $request->details;
            $data->updated_by = Auth::id();
            if ($data->update()) {

                $transaction_log = TransactionLog::where('promotion_id', $data->id)->first();
                if ($transaction_log) {

                    //$transaction_log->date = now();
                    $transaction_log->particular = "promotion head";
                    $transaction_log->transaction_type = 2;
                    // Revert Log
                    if ($request->transaction_method == 1) {
                        $transaction_log->transaction_method = $request->transaction_method;
                    } elseif ($request->transaction_method == 2) {
                        $transaction_log->transaction_method = $request->transaction_method;
                        $transaction_log->bank_id = $request->bank;
                        $transaction_log->branch_id = $request->branch_id;
                        $transaction_log->bank_account_id = $request->bank_account_id;
                        $transaction_log->cheque_no = $request->cheque_no;
                        if ($request->cheque_image) {
                            $transaction_log->cheque_image = $image;
                        }
                    }
                    $transaction_log->amount = $request->cost;
                    if ($transaction_log->save()) {
                        if ($request->transaction_method == 1) {
                            $cash = Cash::first();
                            $cash->amount = $cash->amount - $request->cost;
                            if (!$cash->save()) {
                                $transactionFail = true;
                            }
                        } elseif ($request->transaction_method == 2) {
                            $bank = Bank::find($request->bank);
                            $bank->amount = $bank->amount - $request->cost;
                            if (!$bank->save()) {
                                $transactionFail = true;
                            }
                        }
                    } else {
                        $transactionFail = true;
                    }
                } else {
                    $transaction_log = new TransactionLog();
                    $transaction_log->date = now();
                    $transaction_log->particular = "promotion head";
                    $transaction_log->transaction_type = 2;
                    if ($request->transaction_method == 1) {
                        $transaction_log->transaction_method = $request->transaction_method;
                    } elseif ($request->transaction_method == 2) {
                        $transaction_log->transaction_method = $request->transaction_method;
                        $transaction_log->bank_id = $request->bank;
                        $transaction_log->branch_id = $request->branch_id;
                        $transaction_log->bank_account_id = $request->bank_account_id;
                        $transaction_log->cheque_no = $request->cheque_no;
                        if ($request->cheque_image) {
                            $transaction_log->cheque_image = $image;
                        }
                    }
                    $transaction_log->amount = $request->cost;
                    $transaction_log->promotion_id = $data->id;
                    if ($transaction_log->save()) {
                        if ($request->transaction_method == 1) {
                            $cash = Cash::first();
                            $cash->amount = $cash->amount - $request->cost;
                            if (!$cash->save()) {
                                $transactionFail = true;
                            }
                        } elseif ($request->transaction_method == 2) {
                            $bank = Bank::find($request->bank);
                            $bank->amount = $bank->amount - $request->cost;
                            if (!$bank->save()) {
                                $transactionFail = true;
                            }
                        }
                    } else {
                        $transactionFail = true;
                    }
                }
            } else {
                $transactionFail = true;
            }

            if ($transactionFail == false) {
                DB::commit();
                return redirect()->route('promotion.index')->with('message', 'Information updated');
            } else {
                DB::rollBack();
                return redirect()->back()->with('error', 'Something went wrong.');
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', $th->getMessage());
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
