<?php

namespace Modules\Purchase\Http\Controllers;


use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Account\Entities\AccCoa;
use Modules\Account\Entities\AccMonthlyBalance;
use Modules\Account\Entities\AccPredefineAccount;
use Modules\Account\Entities\AccSubcode;
use Modules\Account\Entities\AccTransaction;
use Modules\Account\Entities\AccVoucher;
use Modules\Inventory\Entities\Inventory;
use Modules\Inventory\Entities\InventoryOrder;
use Modules\Inventory\Entities\InventoryOrderDetail;
use Modules\Purchase\Entities\ProductPurchase;
use Modules\Purchase\Entities\ProductPurchaseDetail;
use Modules\Supplier\Entities\Supplier;
use Modules\Product\Entities\Product;
use Illuminate\Support\Facades\Validator;
use SakibRahaman\DecimalToWords\DecimalToWords;
use Yajra\DataTables\Facades\DataTables;

class PurchaseController extends Controller
{
    public function addPurchase()
    {
        $suppliers = Supplier::orderBy('name', 'desc')->get();
        $paymentCodes = AccCoa::where('isBankNature', 1)->orWhere('isCashNature', 1)->where('HeadLevel', 4)->where('IsActive', 1)->orderBy('HeadName')->get();
        return view('purchase::purchase.add_purchase', compact('suppliers', 'paymentCodes'));
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
                $btn  .= '<a href="' . route('purchase.purchase_sent_inventory', ['productPurchase' => $productPurchase->id]) . '" class="btn btn-info" >Sent Inventory</a> ';
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
            // 'batch_no.*' => 'required|string|max:255',
            'paid' => 'required|numeric|min:0',
            "duty" => "required|numeric|min:0",
            "freight" => "required|numeric|min:0",
            "c_and_f" => "required|numeric|min:0",
            "ait" => "required|numeric|min:0",
            "at" => "required|numeric|min:0",
            "etc" => "required|numeric|min:0",
        ];
        // dd($request->all());


        $request->validate($rules);

        if ($request->paid > $request->grand_total_price) {
            return redirect()->back()->withInput()->with('error', 'Paid Amount Greater than Total Amount Paid');
        }

        if ($request->paid == 0) {
            $is_credit = 1;
        } else {
            $is_credit = '';
        }


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
        $productDiscount = 0;

        foreach ($request->product as $reqProduct) {
            $product = Product::where('id', $reqProduct)->first();

            $productPurchaseDetail = new ProductPurchaseDetail();
            $productPurchaseDetail->product_purchase_id = $productPurchase->id;
            $productPurchaseDetail->product_id = $product->id;
            $productPurchaseDetail->rate = $request->product_rate[$counter];
            $productPurchaseDetail->quantity = $request->quantity[$counter];
            //$productPurchaseDetail->batch_id = $request->batch_no[$counter];
            // $productPurchaseDetail->discount_percent = $request->discount_percent[$counter]??'0';
            // $productPurchaseDetail->discount_amount = $request->discount_value[$counter];
            // $productPurchaseDetail->vat_amount_percent = $request->vat_percent[$counter] ?? '0';
            // $productPurchaseDetail->vat_amount = $request->vat_value[$counter];
            // $productPurchaseDetail->total_amount = ($request->quantity[$counter] * $request->product_rate[$counter])- $request->discount_value[$counter];
            $productPurchaseDetail->total_amount = ($request->quantity[$counter] * $request->product_rate[$counter]);
            $productPurchaseDetail->save();

            $subTotal += $productPurchaseDetail->total_amount;
            //  $productDiscount += $request->discount_value[$counter];

            $counter++;
        }

        $due = ($subTotal + $productPurchase->duty + $productPurchase->freight + $productPurchase->c_and_f + $productPurchase->ait + $productPurchase->at + $productPurchase->etc) - $request->paid;
        $productPurchase->due_amount = $due;
        //$productPurchase->invoice_discount = $productDiscount+$request->discount;
        $productPurchase->save();

        $predefineAccount  = AccPredefineAccount::first();
        $Narration          = "Purchase Voucher";
        $Comment            = "Purchase Voucher for supplier";
        $COAID              = $predefineAccount->purchaseCode;

        $purchase_id = $productPurchase->id;

        if ($request->paid == 0) {
            $amountPay = $productPurchase->grand_total_amount;
            $amountType = 'Credit';
            $reVID     = $predefineAccount->supplierCode;
            $subCode   = AccSubcode::where('referenceNo', $request->supplier)->where('subTypeId', 4)->first();
            $subCodeId = $subCode->id;
            $this->insertPurchaseDebitVoucher($is_credit, $purchase_id, $COAID, $amountType, $amountPay, $Narration, $Comment, $reVID, $subCodeId);
        } else {
            $amountType = 'Debit';
            $paymentCodes = AccCoa::where('id', $request->payment_type)->first();
            $reVID = $paymentCodes->HeadCode;
            $amount_pay = $request->paid;
            $this->insertPurchaseDebitVoucher($is_credit, $purchase_id, $COAID, $amountType, $amount_pay, $Narration, $Comment, $reVID);
        }

        //Create Transaction Voucher
        $vouchers = AccVoucher::where('referenceNo', $purchase_id)->where('status', 0)->get();
        $ApprovedBy = auth()->user()->id;

        if ($vouchers) {
            foreach ($vouchers as $voucher) {
                $accTransaction = new AccTransaction();
                $accTransaction->vid   =  $voucher->id;
                $accTransaction->fyear = $voucher->fyear;
                $accTransaction->VNo   =  $voucher->VNo;
                $accTransaction->Vtype =  $voucher->Vtype;
                $accTransaction->referenceNo  =  $voucher->referenceNo;
                $accTransaction->VDate =  $voucher->VDate;
                $accTransaction->COAID =  $voucher->COAID;
                $accTransaction->Narration =  $voucher->Narration;
                $accTransaction->chequeNo  =  $voucher->chequeNo ? $voucher->chequeNo : '';
                $accTransaction->chequeDate =  $voucher->chequeDate;
                $accTransaction->isHonour   =  $voucher->isHonour;
                $accTransaction->ledgerComment  =  $voucher->ledgerComment;
                $accTransaction->Debit  =  $voucher->Debit;
                $accTransaction->Credit  =  $voucher->Credit;
                $accTransaction->StoreID  =  0;
                $accTransaction->IsPosted =  1;
                $accTransaction->RevCodde =  $voucher->RevCodde;
                $accTransaction->subType  =  $voucher->subType;
                $accTransaction->subCode  =  $voucher->subCode;
                $accTransaction->IsAppoved =  1;
                $accTransaction->CreateBy = $ApprovedBy;
                $accTransaction->save();
            }

            //Update Monthly record

            if ($accTransaction) {

                $this->storeTransactionSummery($voucher->COAID, $voucher->VDate);

                foreach ($vouchers as $voucher) {
                    $reverseAccTransaction = new AccTransaction();
                    $reverseAccTransaction->vid   =  $voucher->id;
                    $reverseAccTransaction->fyear = $voucher->fyear;
                    $reverseAccTransaction->VNo   =  $voucher->VNo;
                    $reverseAccTransaction->Vtype =  $voucher->Vtype;
                    $reverseAccTransaction->referenceNo  =  $voucher->referenceNo;
                    $reverseAccTransaction->VDate =  $voucher->VDate;
                    $reverseAccTransaction->COAID =  $voucher->RevCodde;
                    $reverseAccTransaction->Narration =  $voucher->Narration;
                    $reverseAccTransaction->chequeNo  =  $voucher->chequeNo ? $voucher->chequeNo : '';
                    $reverseAccTransaction->chequeDate =  $voucher->chequeDate;
                    $reverseAccTransaction->isHonour   =  $voucher->isHonour;
                    $reverseAccTransaction->ledgerComment  =  $voucher->ledgerComment;
                    $reverseAccTransaction->Debit  =  $voucher->Credit;
                    $reverseAccTransaction->Credit  =  $voucher->Debit;
                    $reverseAccTransaction->StoreID  =  0;
                    $reverseAccTransaction->IsPosted =  1;
                    $reverseAccTransaction->RevCodde =  $voucher->COAID;
                    $reverseAccTransaction->subType  =  $voucher->subType;
                    $reverseAccTransaction->subCode  =  $voucher->subCode;
                    $reverseAccTransaction->IsAppoved =  1;
                    $reverseAccTransaction->CreateBy = $ApprovedBy;
                    $reverseAccTransaction->save();
                }

                $this->storeTransactionSummery($voucher->RevCodde, $voucher->VDate);
            }
        }


        foreach ($vouchers as $voucher) {
            $voucher->isApproved = 1;
            $voucher->approvedBy = $ApprovedBy;
            $voucher->status = 1;
            $voucher->save();
        }



        //        return redirect()->route('purchase.purchase_receipt.details', ['order' => $productPurchase->id]);
        return redirect()->route('purchase.purchase_receipt_all');
    }

    public function purchaseReceipt()
    {
        return view('purchase::purchase.receipt.all');
    }

    public function purchaseReceiptDetails(ProductPurchase $productPurchase)
    {
        //        $productPurchase = ProductPurchase::with('supplier','products')->where('id',$productPurchase)->first()->toArray();
        //        dd($productPurchase);

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

    public function sentInInventory(ProductPurchase $productPurchase){

        $suppliers = Supplier::orderBy('name', 'desc')->get();
        $paymentCodes = AccCoa::where('isBankNature', 1)->orWhere('isCashNature', 1)->where('HeadLevel', 4)->where('IsActive', 1)->orderBy('HeadName')->get();
        return view('purchase::purchase.edit_purchase', compact('suppliers', 'paymentCodes','productPurchase'));

    }

    public function sentInInventoryPost(ProductPurchase $productPurchase, Request $request){

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


        $request->validate($rules);

        if ($request->paid > $request->grand_total_price) {
            return redirect()->back()->withInput()->with('error', 'Paid Amount Greater than Total Amount Paid');
        }



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
        $productDiscount = 0;

        foreach ($request->product as $reqProduct) {
            $product = Product::where('id', $reqProduct)->first();

            $inventoryOrderDetail = new InventoryOrderDetail();
            $inventoryOrderDetail->inventory_order_id = $inventoryOrder->id;
            $inventoryOrderDetail->product_id = $product->id;
            $inventoryOrderDetail->rate = $request->product_rate[$counter];
            $inventoryOrderDetail->batch_id = $inventoryOrder->batch_no;
            $inventoryOrderDetail->selling_rate = $request->selling_rate[$counter];
            $inventoryOrderDetail->quantity = $request->quantity[$counter];
            $inventoryOrderDetail->total_amount = ($request->quantity[$counter] * $request->product_rate[$counter]);
            $inventoryOrderDetail->save();

            $subTotal += $inventoryOrderDetail->total_amount;

            $inventory = new Inventory();
            $inventory->batch_no  = $inventoryOrder->batch_no;
            $inventory->product_id = $product->id;
            $inventory->selling_rate = $request->selling_rate[$counter];
            $inventory->quantity = $request->quantity[$counter];
            $inventory->save();

            $counter++;
        }

        $due = ($subTotal + $inventoryOrder->duty + $inventoryOrder->freight + $inventoryOrder->c_and_f + $inventoryOrder->ait + $inventoryOrder->at + $inventoryOrder->etc) - $request->paid;
        $inventoryOrder->due_amount = $due;

        $inventoryOrder->save();



        return redirect()->route('inventory.inventory_receipt_details',['inventoryOrder'=>$inventoryOrder->id]);
    }
}


