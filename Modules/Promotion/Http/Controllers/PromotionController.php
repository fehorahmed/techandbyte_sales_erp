<?php

namespace Modules\Promotion\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
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
            "bank_id" => 'nullable|numeric',
            "branch_id" => 'nullable|numeric',
            "bank_account_id" => 'nullable|numeric',
            "cheque_no" => 'nullable|string',
            "cheque_image" => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            "cost" => 'required|numeric',
            "date" => 'required|date|max:255',
            "details" => 'nullable|string|max:255',
        ]);

        $data = new Promotion();
        $data->title = $request->title;
        if ($request->transaction_method == 1) {
            $data->transaction_method = $request->transaction_method;
        } elseif ($request->transaction_method == 2) {
            $data->transaction_method = $request->transaction_method;
            $data->bank_id = $request->bank_id;
            $data->branch_id = $request->branch_id;
            $data->bank_account_id = $request->bank_id;
            $data->cheque_no = $request->cheque_no;
            if ($request->cheque_image) {
                $image = 'img/no_image.png';

                $file = $request->file('cheque_image');
                $filename = Uuid::uuid1()->toString() . '.' . $file->extension();
                $destinationPath = 'uploads/transaction_cheque';
                $file->move($destinationPath, $filename);
                $image = 'uploads/transaction_cheque/' . $filename;
            }
            $data->cheque_image = $image;
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
                $transaction_log->bank_id = $request->bank_id;
                $transaction_log->branch_id = $request->branch_id;
                $transaction_log->bank_account_id = $request->bank_id;
                $transaction_log->cheque_no = $request->cheque_no;
                $transaction_log->cheque_image = $image;
            }
            $transaction_log->amount = $request->cost;
            $transaction_log->promotion_id = $data->id;
            $transaction_log->save();

            return redirect()->route('promotion.index')->with('message', 'Information added');
        } else {
            return redirect()->back()->with('error', 'Something went wrong.');
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
        return view('promotion::promotion.edit', compact('data'));
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
            "cost" => 'required|numeric',
            "date" => 'required|date|max:255',
            "details" => 'nullable|string|max:255',
        ]);

        $data =  Promotion::findOrFail($promotion);
        $data->title = $request->title;
        $data->promotion_type = $request->promotion_type;
        $data->platform = $request->platform;
        $data->cost = $request->cost;
        $data->date = $request->date;
        $data->details = $request->details;
        $data->updated_by = Auth::id();
        if ($data->update()) {
            return redirect()->route('promotion.index')->with('message', 'Information updated');
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
