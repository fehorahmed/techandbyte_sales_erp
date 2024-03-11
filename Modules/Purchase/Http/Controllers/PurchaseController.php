<?php

namespace Modules\Purchase\Http\Controllers;


use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Account\Entities\AccCoa;
use Modules\Account\Entities\AccMonthlyBalance;
use Modules\Account\Entities\AccVoucher;
use Modules\Account\Entities\Cash;
use Modules\Account\Entities\TransactionLog;
use Modules\Bank\Entities\Bank;
use Modules\Inventory\Entities\Inventory;
use Modules\Inventory\Entities\InventoryOrder;
use Modules\Inventory\Entities\InventoryOrderDetail;
use Modules\Purchase\Entities\ProductPurchase;
use Modules\Purchase\Entities\ProductPurchaseDetail;
use Modules\Purchase\Entities\PurchasePayment;
use Modules\Supplier\Entities\Supplier;
use Modules\Product\Entities\Product;
use Illuminate\Support\Facades\Validator;
use Modules\Inventory\Entities\InventoryLog;
use Ramsey\Uuid\Uuid;
use SakibRahaman\DecimalToWords\DecimalToWords;
use Yajra\DataTables\Facades\DataTables;

class PurchaseController extends Controller
{
    public function addPurchase()
    {
        $suppliers = Supplier::orderBy('name', 'desc')->get();
        $banks = Bank::get();
        return view('purchase::purchase.add_purchase', compact('suppliers', 'banks'));
    }

    public function purchaseReceiptDatatable()
    {
        $query = ProductPurchase::with('supplier');

        return DataTables::eloquent($query)
            ->addColumn('supplier', function (ProductPurchase $productPurchase) {
                return $productPurchase->supplier->name ?? '';
            })
            ->addColumn('action', function (ProductPurchase $productPurchase) {

                //                $btn   = '<a href="' . route('purchase_journal_voucher.details', ['order' => $productPurchase->id]) . '" class="btn btn-dark btn-sm">JV</i></a> ';
                $btn  = '<a href="' . route('purchase.purchase_receipt_details', ['productPurchase' => $productPurchase->id]) . '" class="btn btn-primary btn-sm">Details</a> ';
                //                $btn  .= '<a class="btn btn-info btn-sm btn-pay" role="button" data-id="'.$productPurchase->id.'" data-order="'.$productPurchase->order_no.'" data-due="'.$productPurchase->due.'">Pay</a> ';
                if ($productPurchase->status == 1) {
                    $btn  .= '<a href="' . route('purchase.purchase_sent_inventory', ['productPurchase' => $productPurchase->id]) . '" class="btn btn-info" >Sent Inventory</a> ';
                } else {
                    $btn  .= '<a href="#" class="btn btn-success" >On Inventory</a> ';
                }
                return $btn;
            })
            ->editColumn('purchase_date', function (ProductPurchase $productPurchase) {
                return $productPurchase->purchase_date;
            })

            ->addColumn('quantity', function (ProductPurchase $productPurchase) {
                return $productPurchase->quantity ?? '';
            })
            ->editColumn('grand_total_amount', function (ProductPurchase $productPurchase) {
                return '৳' . number_format($productPurchase->grand_total_amount, 2);
            })
            ->editColumn('paid_amount', function (ProductPurchase $productPurchase) {
                return '৳' . number_format($productPurchase->paid_amount, 2);
            })
            ->editColumn('due_amount', function (ProductPurchase $productPurchase) {
                return '৳' . number_format($productPurchase->due_amount, 2);
            })
            ->orderColumn('purchase_date', function ($query, $productPurchase) {
                $query->orderBy('purchase_date', $productPurchase)->orderBy('created_at', 'desc');
            })
            ->rawColumns(['action'])
            ->toJson();
    }


    public function addPurchasePost(Request $request)
    {

        $rules = [
            'supplier' => 'required',
            'lc_no' => 'nullable',
            'date' => 'required|date',
            'purchase_details' => 'nullable',
            'product.*' => 'required|numeric|min:0',
            'quantity.*' => 'required|numeric|min:0',
            'product_rate.*' => 'required|numeric|min:0',
            'paid' => 'required|numeric|min:0',
            "duty" => "required|numeric|min:0",
            "freight" => "required|numeric|min:0",
            "c_and_f" => "required|numeric|min:0",
            "ait" => "required|numeric|min:0",
            "at" => "required|numeric|min:0",
            "etc" => "required|numeric|min:0",
        ];

        if ($request->paid > 0) {
             $rules['payment_type'] = 'required';
        }

        if ($request->payment_type == '2') {
            $rules['bank'] = 'required';
            $rules['cheque_no'] = 'nullable|string|max:255';
            $rules['cheque_image'] = 'nullable|image';
        }

        $request->validate($rules);

        if ($request->paid > $request->grand_total_price) {
            return redirect()->back()->withInput()->with('error', 'Paid Amount Greater than Total Amount Paid');
        }

        if ($request->payment_type == 1) {
            $cash = Cash::first();

            if ($request->amount > $cash->amount)
                return redirect()->back()->withInput()->with('error', 'Insufficient balance.');
        }elseif($request->payment_type == 2){
            $bankAccount = Bank::find($request->bank);

            if ($request->amount > $bankAccount->amount)
                return redirect()->back()->withInput()->with('error', 'Insufficient balance.');
        }

        $totalCost = $request->duty+$request->freight+$request->ait+$request->at+$request->at+$request->etc;
        $baseAmount = $request->grand_total_price-$totalCost;

        try {

            DB::beginTransaction();

            $productPurchase = new ProductPurchase();
            $productPurchase->lc_no = $request->lc_no;
            $productPurchase->supplier_id = $request->supplier;
            $productPurchase->duty = $request->duty;
            $productPurchase->freight = $request->freight;
            $productPurchase->c_and_f = $request->c_and_f;
            $productPurchase->ait = $request->ait;
            $productPurchase->at = $request->at;
            $productPurchase->etc = $request->etc;
            $productPurchase->purchase_date = Carbon::parse($request->date)->format('Y-m-d');
            $productPurchase->grand_total_amount = $request->grand_total_price;
            $productPurchase->purchase_details = $request->purchase_details;
            $productPurchase->paid_amount = $request->paid;
            $productPurchase->due_amount = 0;
            $productPurchase->total_discount = $request->discount;
            $productPurchase->total_vat_amount = $request->total_vat ?? 0;
            $productPurchase->invoice_discount = 0;
            $productPurchase->status = 1;
            $productPurchase->payment_type = 1;
            $productPurchase->save();
            $productPurchase->chalan_no = 'PO' . str_pad($productPurchase->id, 8, 0, STR_PAD_LEFT);
            $productPurchase->save();

            $counter = 0;
            $subTotal = 0;

            foreach ($request->product as $reqProduct) {
                $product = Product::where('id', $reqProduct)->first();

                $productPurchaseDetail = new ProductPurchaseDetail();
                $productPurchaseDetail->product_purchase_id = $productPurchase->id;
                $productPurchaseDetail->product_id = $product->id;
                $productPurchaseDetail->rate = $request->product_rate[$counter];
                $productPurchaseDetail->per_pcs_cost = ($totalCost*$request->product_rate[$counter])/$baseAmount;
                $productPurchaseDetail->quantity = $request->quantity[$counter];
                $productPurchaseDetail->total_amount = ($request->quantity[$counter] * $request->product_rate[$counter]);
                $productPurchaseDetail->save();

                $subTotal += $productPurchaseDetail->total_amount;

                $counter++;
            }

            $due = ($subTotal + $productPurchase->duty + $productPurchase->freight + $productPurchase->c_and_f + $productPurchase->ait + $productPurchase->at + $productPurchase->etc) - $request->paid;
            $productPurchase->due_amount = $due;
            $productPurchase->save();

            // Purchase Payment
            if ($request->paid > 0) {
                if ($request->payment_type == 1) {
                    $payment = new PurchasePayment();
                    $payment->product_purchase_id  = $productPurchase->id;
                    $payment->supplier_id = $request->supplier;
                    $payment->transaction_method = $request->payment_type;
                    $payment->amount = $request->paid;
                    $payment->date = Carbon::parse($request->date)->format('Y-m-d');
                    $payment->save();

                    Cash::first()->decrement('amount', $request->paid);

                    $log = new TransactionLog();
                    $log->date = Carbon::parse($request->date)->format('Y-m-d');
                    $log->particular = 'Paid to LC-' . $request->lc_no;
                    $log->transaction_type = 2;
                    $log->transaction_method = $request->payment_type;
                    $log->amount = $request->paid;
                    $log->purchase_payment_id  = $payment->id;
                    $log->save();

                } else {
                    $image = 'img/no_image.png';

                    if ($request->cheque_image) {
                        $image = 'img/no_image.png';

                        $file = $request->file('cheque_image');
                        $filename = Uuid::uuid1()->toString() . '.' . $file->extension();
                        $destinationPath = 'uploads/transaction_cheque';
                        $file->move($destinationPath, $filename);
                        $image = 'uploads/transaction_cheque/' . $filename;
                    }

                    $payment = new PurchasePayment();
                    $payment->product_purchase_id  = $productPurchase->id;
                    $payment->supplier_id = $request->supplier;
                    $payment->transaction_method = $request->payment_type;
                    $payment->amount = $request->paid;
                    $payment->date = Carbon::parse($request->date)->format('Y-m-d');
                    $payment->bank_id = $request->bank;
                    $payment->cheque_no = $request->cheque_no;
                    $payment->cheque_image = $image;
                    $payment->amount = $request->paid;
                    $payment->date = Carbon::parse($request->date)->format('Y-m-d');
                    $payment->save();

                    Bank::find($request->bank)->decrement('amount', $request->paid);

                    $log = new TransactionLog();
                    $log->date = Carbon::parse($request->date)->format('Y-m-d');
                    $log->particular = 'Paid to LC-' . $request->lc_no;
                    $log->transaction_type = 2;
                    $log->transaction_method = $request->payment_type;
                    $log->bank_id = $request->bank;
                    $log->cheque_no = $request->cheque_no;
                    $log->cheque_image = $image;
                    $log->amount = $request->paid;
                    $log->purchase_payment_id = $payment->id;
                    $log->save();

                }
            }

            DB::commit();
            return redirect()->route('purchase.purchase_receipt_all');
        }catch (\Exception $exception) {
            DB::rollBack();
            dd($exception);
            return redirect()->back()->with('error', $exception)->withInput();
        }
    }

    public function purchaseReceipt()
    {
        return view('purchase::purchase.receipt.all');
    }

    public function purchaseReceiptDetails(ProductPurchase $productPurchase)
    {

        return view('purchase::purchase.receipt.details', compact('productPurchase'));
    }

    public function edit($id)
    {
        return view('purchase::edit');
    }

    //Insert Purchase Debit Voucher
    public function insertPurchaseDebitVoucher($is_credit = null, $purchase_id = null, $dbtid = null, $amountType = null, $amount = null, $Narration = null, $Comment = null, $reVID = null, $subCodeId = null)
    {

        $VDate = date('Y-m-d');

        $Vtype = 'DV';
        $voucherNo = voucherNo($Vtype);

        $accVoucher = new AccVoucher();
        $accVoucher->fyear = 1;
        $accVoucher->VNo = $voucherNo;
        $accVoucher->Debit = $amount;
        $accVoucher->Credit = 0.00;
        $accVoucher->Vtype = 'DV';
        $accVoucher->referenceNo = $purchase_id;
        $accVoucher->VDate = $VDate;
        $accVoucher->COAID = $dbtid;
        $accVoucher->Narration = $Narration;
        $accVoucher->ledgerComment = $Comment;
        $accVoucher->RevCodde = $reVID;
        $accVoucher->isApproved = 0;
        $accVoucher->CreateBy = auth()->user()->id;
        $accVoucher->status = 0;
        $accVoucher->save();
        return true;
    }


    public function storeTransactionSummery($coaid, $date)
    {
        $currentMonth = Carbon::parse($date)->month;
        $fyear = financial_year();
        //        $summary = $this->getClosingBalance($coaid, $date);
        $summary = 500;
        $existingRecord = AccMonthlyBalance::where('COAID', $coaid)->where('fyear', $fyear)->first();

        if (!$existingRecord) {
            $accMonthlyBalance = new AccMonthlyBalance();
            $accMonthlyBalance->fyear = $fyear;
            $accMonthlyBalance->COAID = $coaid;
            $accMonthlyBalance['balance' . $currentMonth] = $summary;
            $accMonthlyBalance->save();
        } else {
            $existingRecord->fyear = $fyear;
            $existingRecord->COAID = $coaid;
            $existingRecord['balance' . $currentMonth] = $summary;
            $existingRecord->save();
        }

        return true;
    }

    public function sentInInventory(ProductPurchase $productPurchase)
    {

        $suppliers = Supplier::orderBy('name', 'desc')->get();
        $banks = Bank::get();
        return view('purchase::purchase.edit_purchase', compact('suppliers', 'banks', 'productPurchase'));
    }

    public function sentInInventoryPost(ProductPurchase $productPurchase, Request $request)
    {

        $rules = [
            'supplier' => 'required',
            'lc_no' => 'nullable',
            'date' => 'required|date',
            'batch_no' => 'required|string|max:255',
            'purchase_details' => 'nullable',
            'product.*' => 'required|numeric|min:0',
            'quantity.*' => 'required|numeric|min:0',
            'selling_rate.*' => 'required|numeric|min:0',
            'product_rate.*' => 'required|numeric|min:0',
            'paid' => 'required|numeric|min:0',
            "duty" => "required|numeric|min:0",
            "freight" => "required|numeric|min:0",
            "c_and_f" => "required|numeric|min:0",
            "ait" => "required|numeric|min:0",
            "at" => "required|numeric|min:0",
            "etc" => "required|numeric|min:0",
        ];

        if ($request->paid > 0) {
            $rules['payment_type'] = 'required';
        }

        if ($request->payment_type == '2') {
            $rules['bank'] = 'required';
            $rules['cheque_no'] = 'nullable|string|max:255';
            $rules['cheque_image'] = 'nullable|image';
        }

        $request->validate($rules);

        if ($request->paid > $request->grand_total_price) {
            return redirect()->back()->withInput()->with('error', 'Paid Amount Greater than Total Amount Paid');
        }

        if ($request->payment_type == 1) {
            $cash = Cash::first();

            if ($request->amount > $cash->amount)
                return redirect()->back()->withInput()->with('error', 'Insufficient balance.');
        }elseif($request->payment_type == 2){
            $bankAccount = Bank::find($request->bank);

            if ($request->amount > $bankAccount->amount)
                return redirect()->back()->withInput()->with('error', 'Insufficient balance.');
        }
        $totalCost = $request->duty+$request->freight+$request->ait+$request->at+$request->at+$request->etc;
        $baseAmount = $request->grand_total_price-$totalCost;
        try {

            DB::beginTransaction();

        $inventoryOrder = new InventoryOrder();
        $inventoryOrder->product_purchase_id  = $productPurchase->id;
        $inventoryOrder->lc_no = $request->lc_no;
        $inventoryOrder->batch_no = $request->batch_no;
        $inventoryOrder->supplier_id = $request->supplier;
        $inventoryOrder->duty = $request->duty;
        $inventoryOrder->freight = $request->freight;
        $inventoryOrder->c_and_f = $request->c_and_f;
        $inventoryOrder->ait = $request->ait;
        $inventoryOrder->at = $request->at;
        $inventoryOrder->etc = $request->etc;
        $inventoryOrder->purchase_date = Carbon::parse($request->date)->format('Y-m-d');
        $inventoryOrder->grand_total_amount = $request->grand_total_price;
        $inventoryOrder->purchase_details = $request->purchase_details;
        $inventoryOrder->previous_paid = $request->previous_paid;
        $inventoryOrder->paid_amount = $request->paid;
        $inventoryOrder->due_amount = 0;
        $inventoryOrder->total_discount = $request->discount;
        $inventoryOrder->total_vat_amount = $request->total_vat ?? 0;
        $inventoryOrder->invoice_discount = 0;
        $inventoryOrder->status = 1;
        $inventoryOrder->payment_type = 1;
        $inventoryOrder->save();
        $inventoryOrder->chalan_no = 'IO' . str_pad($inventoryOrder->id, 8, 0, STR_PAD_LEFT);
        $inventoryOrder->save();

        $counter = 0;
        $subTotal = 0;

        foreach ($request->product as $reqProduct) {
            $product = Product::where('id', $reqProduct)->first();

            $inventoryOrderDetail = new InventoryOrderDetail();
            $inventoryOrderDetail->inventory_order_id = $inventoryOrder->id;
            $inventoryOrderDetail->product_id = $product->id;
            $inventoryOrderDetail->rate = $request->product_rate[$counter];
            $inventoryOrderDetail->per_pcs_cost = ($totalCost*$request->product_rate[$counter])/$baseAmount;
            $inventoryOrderDetail->batch_id = $inventoryOrder->batch_no;
            $inventoryOrderDetail->selling_rate = $request->selling_rate[$counter];
            $inventoryOrderDetail->quantity = $request->quantity[$counter];
            $inventoryOrderDetail->total_amount = ($request->quantity[$counter] * $request->product_rate[$counter]);
            $inventoryOrderDetail->save();

            $subTotal += $inventoryOrderDetail->total_amount;

            $inventory = new Inventory();
            $inventory->batch_no  = $inventoryOrder->batch_no;
            $inventory->product_id = $product->id;
            $inventory->purchase_rate = $request->product_rate[$counter];
            $inventory->selling_rate = $request->selling_rate[$counter];
            $inventory->quantity = $request->quantity[$counter];
            if ($inventory->save()) {
                $inv_log = new InventoryLog();
                $inv_log->inventory_id =  $inventory->id;
                $inv_log->order_id =  $inventoryOrder->id;
                $inv_log->quantity =  $request->quantity[$counter];
                $inv_log->type =  'stock_in';
                $inv_log->remark =  'Inventory Order';
                $inv_log->save();
            }

            $counter++;
        }

        $due = ($subTotal + $inventoryOrder->duty + $inventoryOrder->freight + $inventoryOrder->c_and_f + $inventoryOrder->ait + $inventoryOrder->at + $inventoryOrder->etc) - $request->paid-$request->previous_paid;
        $inventoryOrder->due_amount = $due;

        $inventoryOrder->save();

        $productPurchase->status = 0;
        $productPurchase->save();


        // Purchase Payment
        if ($request->paid > 0) {
            if ($request->payment_type == 1) {
                $payment = new PurchasePayment();
                $payment->product_purchase_id  = $productPurchase->id;
                $payment->inventory_order_id   = $inventoryOrder->id;
                $payment->supplier_id = $request->supplier;
                $payment->transaction_method = $request->payment_type;
                $payment->amount = $request->paid;
                $payment->date = Carbon::parse($request->date)->format('Y-m-d');
                $payment->save();


                Cash::first()->decrement('amount', $request->paid);

                $log = new TransactionLog();
                $log->date = Carbon::parse($request->date)->format('Y-m-d');
                $log->particular = 'Purchase Paid-' . $inventoryOrder->chalan_no;
                $log->transaction_type = 2;
                $log->transaction_method = $request->payment_type;
                $log->amount = $request->paid;
                $log->purchase_payment_id  = $payment->id;
                $log->save();

            } else {
                $image = 'img/no_image.png';

                if ($request->cheque_image) {
                    $image = 'img/no_image.png';

                    $file = $request->file('cheque_image');
                    $filename = Uuid::uuid1()->toString() . '.' . $file->extension();
                    $destinationPath = 'uploads/transaction_cheque';
                    $file->move($destinationPath, $filename);
                    $image = 'uploads/transaction_cheque/' . $filename;
                }

                $payment = new PurchasePayment();
                $payment->product_purchase_id  = $productPurchase->id;
                $payment->supplier_id = $request->supplier;
                $payment->transaction_method = $request->payment_type;
                $payment->amount = $request->paid;
                $payment->date = Carbon::parse($request->date)->format('Y-m-d');
                $payment->bank_id = $request->bank;
                $payment->cheque_no = $request->cheque_no;
                $payment->cheque_image = $image;
                $payment->amount = $request->paid;
                $payment->date = Carbon::parse($request->date)->format('Y-m-d');
                $payment->save();

                Bank::find($request->bank)->decrement('amount', $request->paid);

                $log = new TransactionLog();
                $log->date = Carbon::parse($request->date)->format('Y-m-d');
                $log->particular = 'Purchase Paid' . $inventoryOrder->chalan_no;
                $log->transaction_type = 2;
                $log->transaction_method = $request->payment_type;
                $log->bank_id = $request->bank;
                $log->cheque_no = $request->cheque_no;
                $log->cheque_image = $image;
                $log->amount = $request->paid;
                $log->purchase_payment_id = $payment->id;
                $log->save();

            }
        }

            DB::commit();
            return redirect()->route('inventory.inventory_receipt_details', ['inventoryOrder' => $inventoryOrder->id]);
        }catch (\Exception $exception) {
            DB::rollBack();
            dd($exception);
            return redirect()->back()->with('error', $exception)->withInput();
        }

    }
}
