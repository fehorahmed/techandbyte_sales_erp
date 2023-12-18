<?php

namespace Modules\Sale\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Account\Entities\AccCoa;
use Modules\Account\Entities\AccMonthlyBalance;
use Modules\Account\Entities\AccPredefineAccount;
use Modules\Account\Entities\AccSubcode;
use Modules\Account\Entities\AccTransaction;
use Modules\Account\Entities\AccVoucher;
use Modules\Customer\Entities\Customer;
use Modules\Product\Entities\Product;
use Modules\Purchase\Entities\ProductPurchaseDetail;
use Modules\Sale\Entities\Invoice;
use Modules\Sale\Entities\InvoiceDetail;
use Yajra\DataTables\Facades\DataTables;

class SaleController extends Controller
{
    public function addSale(){

        $customers = Customer::orderBy('name','desc')->get();
        $paymentCodes= AccCoa::where('isBankNature',1)->orWhere('isCashNature',1)->where('HeadLevel', 4)->where('IsActive', 1)->orderBy('HeadName')->get();
        return view('sale::sale.add_sale',compact('customers','paymentCodes'));
    }

    public function saleReceiptDatatable() {
        $query = Invoice::with('customer');

        return DataTables::eloquent($query)
            ->addColumn('customer', function(Invoice $invoice) {
                return $invoice->customer->name ?? '';
            })
            ->addColumn('action', function(Invoice $invoice) {

//                $btn   = '<a href="' . route('purchase_journal_voucher.details', ['order' => $invoice->id]) . '" class="btn btn-dark btn-sm">JV</i></a> ';
                $btn  = '<a href="' . route('sale.sale_receipt_details', ['invoice' => $invoice->id]) . '" class="btn btn-primary btn-sm">Details</a> ';
//                $btn  .= '<a class="btn btn-info btn-sm btn-pay" role="button" data-id="'.$invoice->id.'" data-order="'.$invoice->order_no.'" data-due="'.$invoice->due.'">Pay</a> ';
                return $btn;
            })
            ->editColumn('date', function(Invoice $invoice) {
                return $invoice->date;
            })

            ->addColumn('quantity', function (Invoice $invoice) {
                return $invoice->quantity ?? '';
            })
            ->editColumn('total_amount', function(Invoice $invoice) {
                return '৳'.number_format($invoice->total_amount, 2);
            })
            ->editColumn('paid_amount', function(Invoice $invoice) {
                return '৳'.number_format($invoice->paid_amount, 2);
            })
            ->editColumn('due_amount', function(Invoice $invoice) {
                return '৳'.number_format($invoice->due_amount, 2);
            })
            ->orderColumn('date', function ($query, $invoice) {
                $query->orderBy('date', $invoice)->orderBy('created_at', 'desc');
            })
            ->rawColumns(['action'])
            ->toJson();
    }


    public function addSalePost(Request $request){

//return($request->all());
        $rules = [
            'customer' => 'required',
            'lc_no' => 'nullable',
            'date' => 'required|date',
            'inva_details' => 'nullable',
            'product.*' => 'required|numeric|min:0',
            'quantity.*' => 'required|numeric|min:0',
            'stock.*' => 'required|numeric|min:0',
            'product_rate.*' => 'required|numeric|min:0',
            'batch_no.*' => 'required|string|max:255',
            'paid' => 'required|numeric|min:0',

        ];


        $request->validate($rules);

        $counter1=0;
        foreach ($request->product as $reqProduct) {

            $product = Product::where('id', $reqProduct)->first();

            if ($request->stock[$counter1] < $request->quantity[$counter1]) {
                return redirect()->back()->withInput()->with('error', 'Sale Quantity Greater than Stock Quantity in product '.$product->product_name);
            }
            $counter1++;
        }



        if ($request->paid == 0) {
            $is_credit = 1;
        }
        else {
            $is_credit = '';
        }
//        $is_fixed   = 1;
//        $is_dynamic = 0;
//        $paid_tax = $request->total_vat;

        $invoice_no = Invoice::max('invoice');
        if($invoice_no){
            $invoice_no += 1;
        }else{
            $invoice_no = 1000;
        }

        $invoice = new Invoice();
        $invoice->customer_id = $request->customer;
        $invoice->date = Carbon::parse($request->date)->format('Y-m-d');
        $invoice->total_amount = round($request->grand_total_price);
        $invoice->invoice_details = $request->inva_details;
        $invoice->paid_amount = $request->paid;
        $invoice->due_amount = 0;
        $invoice->invoice = $invoice_no;
        $invoice->total_discount = $request->discount;
        $invoice->total_vat_amnt = $request->total_vat;
        $invoice->invoice_discount = 0;
        $invoice->status = 1;
        $invoice->payment_type = 1;
        $invoice->save();



        $counter = 0;
        $subTotal = 0;
        $sumVal = 0;
        $productDiscount = 0;


        foreach ($request->product as $reqProduct) {

            $product = Product::where('id', $reqProduct)->first();

            $inventory = ProductPurchaseDetail::where('product_id',$product->id)->where('batch_id',$request->batch_no[$counter])->first();
            $purchaseAverageRate = ProductPurchaseDetail::where('product_id', $product->id)
                ->selectRaw('product_id, AVG(rate) as product_rate')
                ->groupBy('product_id')
                ->first();

            $invoiceDetail = new InvoiceDetail();
            $invoiceDetail->invoice_id = $invoice->id;
            $invoiceDetail->product_id = $product->id;
            $invoiceDetail->rate = $request->product_rate[$counter];
            $invoiceDetail->quantity = $request->quantity[$counter];
            $invoiceDetail->batch_id = $request->batch_no[$counter];
            $invoiceDetail->discount_per = $request->discount_percent[$counter];
            $invoiceDetail->discount = $request->discount_value[$counter];
            $invoiceDetail->vat_amnt_per = $request->vat_percent[$counter];
            $invoiceDetail->vat_amnt = $request->vat_value[$counter];
            $invoiceDetail->total_price = ($request->quantity[$counter] * $request->product_rate[$counter])- $request->discount_value[$counter];
            $invoiceDetail->save();


            $subTotal += $invoiceDetail->total_price+ $request->vat_value[$counter];
            $productDiscount += $invoiceDetail->discount;

            $inventory->decrement('quantity', $request->quantity[$counter]);

            $sumVal += $purchaseAverageRate->product_rate*$request->quantity[$counter];

            $counter++;
        }


        $due = round($subTotal) - $request->paid;
        $invoice->due_amount = $due;
        $invoice->invoice_discount = $productDiscount;
        $invoice->save();

        //Insert Tax

//        if($tax_v > 0){
//            $this->db->insert('tax_collection',$taxdata);
//        }

        $predefineAccount  = AccPredefineAccount::first();
        $Narration          = "Sales Voucher";
        $Comment            = "Sales Voucher for customer";
        $reVID              = $predefineAccount->salesCode;

        $invoice_id = $invoice->id;

        if ($request->paid == 0) {
            $amountPay = $invoice->total_amount;
            $amountType = 'Debit';
            $COAID      = $predefineAccount->customerCode;
            $subCode   = AccSubcode::where('referenceNo', $request->customer)->where('subTypeId', 3)->first();
            $subCodeId = $subCode->id;
            $this->insertSaleCreditVoucher($is_credit,$invoice_id,$COAID,$amountType,$amountPay,$Narration,$Comment,$reVID,$subCodeId);
        }
        else {
            $amountType = 'Credit';
            $paymentCodes= AccCoa::where('id',$request->payment_type)->first();
            $COAID = $paymentCodes->HeadCode;
            $amount_pay = $request->paid;
            $this->insertSaleCreditVoucher($is_credit,$invoice_id,$COAID,$amountType,$amount_pay,$Narration,$Comment,$reVID);
        }

        // for inventory & cost of goods sold start
        $goodsCOAID     = $predefineAccount->costs_of_good_solds;
        $purchasevalue  = $sumVal;
        $goodsNarration = "Sales cost of goods Voucher";
        $goodsComment   = "Sales cost of goods Voucher for customer";
        $goodsreVID     = $predefineAccount->inventoryCode;

        $this->insertSaleInventoryVoucher($invoice_id,$goodsCOAID,$purchasevalue,$goodsNarration,$goodsComment,$goodsreVID);

        //Debit Transaction Voucher
        $vouchers = AccVoucher::where('referenceNo',$invoice_id)->where('status',0)->get();
        $ApprovedBy=auth()->user()->id;

        if($vouchers){
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

            if($accTransaction){

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

//        return redirect()->route('purchase.purchase_receipt.details', ['order' => $invoice->id]);
        return redirect()->route('sale.sale_receipt_all');
    }

    public function saleReceipt() {
        return view('sale::sale.receipt.all');
    }

    public function saleReceiptDetails(Invoice $invoice){
//        $invoice = Invoice::with('customer','products')->where('id',$invoice)->first()->toArray();
//        dd($invoice);

        return view('sale::sale.receipt.details',compact('invoice'));
    }

    public function edit($id){
        return view('sale::edit');
    }

    //Insert Sale Cedit Voucher
    public function insertSaleCreditVoucher($is_credit = null,$invoice_id = null,$dbtid = null,$amountType = null,$amount = null,$Narration = null,$Comment = null,$reVID = null,$subCodeId = null){

        $fyear = financial_year();
        $VDate = date('Y-m-d');

        // Cash & credit voucher insert

        if ($is_credit == 1) {

            $Vtype = 'JV';
            $voucherNo = voucherNo($Vtype);

            $accVoucher = new AccVoucher();
            $accVoucher->fyear = $fyear;
            $accVoucher->VNo = $voucherNo;
            $accVoucher->Vtype = 'JV';
            $accVoucher->referenceNo = $invoice_id;
            if($amountType == 'Debit'){
                $accVoucher->Debit = $amount;
                $accVoucher->Credit = 0.00;
            }else{
                $accVoucher->Debit = 0.00;
                $accVoucher->Credit = $amount;
            }
            $accVoucher->VDate = $VDate;
            $accVoucher->COAID = $dbtid;
            $accVoucher->Narration = $Narration;
            $accVoucher->ledgerComment = $Comment;
            $accVoucher->RevCodde = $reVID;
            $accVoucher->isApproved = 0;
            $accVoucher->CreateBy = auth()->user()->id;
            $accVoucher->status = 0;
            $accVoucher->save();
        }else{
            $Vtype = 'CV';
            $voucherNo = voucherNo($Vtype);

            $accVoucher = new AccVoucher();
            $accVoucher->fyear = $fyear;
            $accVoucher->VNo = $voucherNo;
            $accVoucher->Vtype = 'CV';
            $accVoucher->referenceNo = $invoice_id;
            if($amountType == 'Debit'){
                $accVoucher->Debit = $amount;
                $accVoucher->Credit = 0.00;
            }else{
                $accVoucher->Debit = 0.00;
                $accVoucher->Credit = $amount;
            }
            $accVoucher->VDate = $VDate;
            $accVoucher->COAID = $dbtid;
            $accVoucher->Narration = $Narration;
            $accVoucher->ledgerComment = $Comment;
            $accVoucher->RevCodde = $reVID;
            $accVoucher->isApproved = 0;
            $accVoucher->CreateBy = auth()->user()->id;
            $accVoucher->status = 0;
            $accVoucher->save();
        }

        return true;
    }


    //Insert Sale Inventory Voucher

    public function insertSaleInventoryVoucher($invoice_id = null,$dbtid = null,$amount = null,$Narration = null,$Comment = null,$reVID = null){

        $fyear = financial_year();
        $VDate = date('Y-m-d');

        // cost of goods sold voucher insert

            $Vtype = 'JV';
            $voucherNo = voucherNo($Vtype);

            $accVoucher = new AccVoucher();
            $accVoucher->fyear = $fyear;
            $accVoucher->VNo = $voucherNo;
            $accVoucher->Vtype = 'JV';
            $accVoucher->referenceNo = $invoice_id;
            $accVoucher->Debit = $amount;
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
            $accMonthlyBalance->fyear =$fyear;
            $accMonthlyBalance->COAID =$coaid;
            $accMonthlyBalance['balance'.$currentMonth] =$summary;
            $accMonthlyBalance->save();
        } else {
            $existingRecord->fyear =$fyear;
            $existingRecord->COAID =$coaid;
            $existingRecord['balance'.$currentMonth] = $summary;
            $existingRecord->save();
        }

        return true;
    }


}
