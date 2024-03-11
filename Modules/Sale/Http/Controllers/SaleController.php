<?php

namespace Modules\Sale\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Account\Entities\AccCoa;
use Modules\Account\Entities\AccMonthlyBalance;
use Modules\Account\Entities\AccPredefineAccount;
use Modules\Account\Entities\AccSubcode;
use Modules\Account\Entities\AccTransaction;
use Modules\Account\Entities\AccVoucher;
use Modules\Account\Entities\Cash;
use Modules\Account\Entities\TransactionLog;
use Modules\Bank\Entities\Bank;
use Modules\Client\Entities\Client;
use Modules\Customer\Entities\Customer;
use Modules\Inventory\Entities\Inventory;
use Modules\Inventory\Entities\InventoryLog;
use Modules\Product\Entities\Product;
use Modules\Purchase\Entities\ProductPurchaseDetail;
use Modules\Sale\Entities\Invoice;
use Modules\Sale\Entities\InvoiceDetail;
use Modules\Sale\Entities\SalePayment;
use Modules\Sale\Entities\SaleVat;
use Ramsey\Uuid\Uuid;
use Yajra\DataTables\Facades\DataTables;

class SaleController extends Controller
{
    public function addSale()
    {

        $customers = Client::orderBy('name', 'desc')->get();
        $banks = Bank::get();
        return view('sale::sale.add_sale', compact('customers', 'banks'));
    }

    public function saleReceiptDatatable()
    {
        $query = Invoice::with('customer');

        return DataTables::eloquent($query)
            ->addColumn('customer', function (Invoice $invoice) {
                return $invoice->customer->name ?? '';
            })
            ->addColumn('action', function (Invoice $invoice) {

                //                $btn   = '<a href="' . route('purchase_journal_voucher.details', ['order' => $invoice->id]) . '" class="btn btn-dark btn-sm">JV</i></a> ';
                $btn  = '<a href="' . route('sale.sale_receipt_details', ['invoice' => $invoice->id]) . '" class="btn btn-primary btn-sm">Details</a> ';
                //                $btn  .= '<a class="btn btn-info btn-sm btn-pay" role="button" data-id="'.$invoice->id.'" data-order="'.$invoice->order_no.'" data-due="'.$invoice->due.'">Pay</a> ';
                return $btn;
            })
            ->editColumn('date', function (Invoice $invoice) {
                return $invoice->date;
            })

            ->addColumn('quantity', function (Invoice $invoice) {
                return $invoice->quantity ?? '';
            })
            ->editColumn('total_amount', function (Invoice $invoice) {
                return '৳' . number_format($invoice->total_amount, 2);
            })
            ->editColumn('paid_amount', function (Invoice $invoice) {
                return '৳' . number_format($invoice->paid_amount, 2);
            })
            ->editColumn('due_amount', function (Invoice $invoice) {
                return '৳' . number_format($invoice->due_amount, 2);
            })
            ->orderColumn('date', function ($query, $invoice) {
                $query->orderBy('date', $invoice)->orderBy('created_at', 'desc');
            })
            ->rawColumns(['action'])
            ->toJson();
    }


    public function addSalePost(Request $request)
    {

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

        $counter1 = 0;
        foreach ($request->product as $reqProduct) {

            $product = Product::where('id', $reqProduct)->first();

            if ($request->stock[$counter1] < $request->quantity[$counter1]) {
                return redirect()->back()->withInput()->with('error', 'Sale Quantity Greater than Stock Quantity in product ' . $product->product_name);
            }
            $counter1++;
        }

        try {

            DB::beginTransaction();

            $invoice_no = Invoice::max('invoice');
            if ($invoice_no) {
                $invoice_no += 1;
            } else {
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
            $invoice->total_vat_amnt = $request->vat;
            $invoice->invoice_discount = 0;
            $invoice->status = 1;
            $invoice->payment_type = 1;
            $invoice->save();



            $counter = 0;
            $subTotal = 0;
            $sumVal = 0;



            foreach ($request->product as $reqProduct) {

                $product = Product::where('id', $reqProduct)->first();

                $inventory = Inventory::where('product_id', $product->id)->where('batch_no', $request->batch_name[$counter])->first();

                $invoiceDetail = new InvoiceDetail();
                $invoiceDetail->invoice_id = $invoice->id;
                $invoiceDetail->product_id = $product->id;
                $invoiceDetail->rate = $request->product_rate[$counter];
                $invoiceDetail->quantity = $request->quantity[$counter];

                $invoiceDetail->batch_id = $request->batch_no[$counter];

                $invoiceDetail->total_price = ($request->quantity[$counter] * $request->product_rate[$counter]);
                $invoiceDetail->save();

                $subTotal += $invoiceDetail->total_price;


                $inventory->quantity = $inventory->quantity - $request->quantity[$counter];
                if ($inventory->save()) {
                    //Inventory Log
                    $inv_log = new InventoryLog();
                    $inv_log->inventory_id =  $inventory->id;
                    $inv_log->order_id =  $invoice->id;
                    $inv_log->quantity =  $request->quantity[$counter];
                    $inv_log->type =  'stock_out';
                    $inv_log->remark =  'Sale Order';
                    $inv_log->save();
                }

                $sumVal += $request->product_rate[$counter] * $request->quantity[$counter];

                $counter++;
            }

            $invoice->invoice_discount = 0;
            $invoice->base_amount = $subTotal;
            $due = round($subTotal - $request->discount) - $request->paid + $request->vat;
            $invoice->due_amount = $due;

            $invoice->save();

            //Vat amount
            if ($request->vat > 0) {
                $saleVat = new SaleVat();
                $saleVat->invoice_id  = $invoice->id;
                $saleVat->customer_id = $request->customer;
                $saleVat->amount = $request->vat;
                $saleVat->date = Carbon::parse($request->date)->format('Y-m-d');
                $saleVat->status = 0;
                $saleVat->save();
            }

            // Sales Payment
            if ($request->paid > 0) {

                $point_amount = ($request->paid / 1000);
                $record = Client::find($request->customer);
                if ($record) {
                    $record->increment('point', $point_amount);
                    $record->save();
                }



                if ($request->payment_type == 1) {
                    $payment = new SalePayment();
                    $payment->invoice_id = $invoice->id;
                    $payment->customer_id = $request->customer;
                    $payment->transaction_method = $request->payment_type;
                    $payment->amount = $request->paid;
                    $payment->date = Carbon::parse($request->date)->format('Y-m-d');
                    $payment->save();

                    Cash::first()->increment('amount', $request->paid);

                    $log = new TransactionLog();
                    $log->date = Carbon::parse($request->date)->format('Y-m-d');
                    $log->particular = 'Payment for ' . $invoice_no;
                    $log->transaction_type = 1;
                    $log->transaction_method = $request->payment_type;
                    $log->amount = $request->paid;
                    $log->sale_payment_id = $payment->id;
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

                    $payment = new SalePayment();
                    $payment->invoice_id = $invoice->id;
                    $payment->customer_id = $request->customer;
                    $payment->transaction_method = 2;
                    $payment->bank_id = $request->bank;
                    $payment->cheque_no = $request->cheque_no;
                    $payment->cheque_image = $image;
                    $payment->amount = $request->paid;
                    $payment->date = Carbon::parse($request->date)->format('Y-m-d');
                    $payment->save();

                    Bank::find($request->bank)->increment('amount', $request->paid);


                    $log = new TransactionLog();
                    $log->date = Carbon::parse($request->date)->format('Y-m-d');
                    $log->particular = 'Payment for ' . $invoice_no;
                    $log->transaction_type = 1;
                    $log->transaction_method = 2;
                    $log->bank_id = $request->bank;
                    $log->cheque_no = $request->cheque_no;
                    $log->cheque_image = $image;
                    $log->amount = $request->paid;
                    $log->sale_payment_id = $payment->id;
                    $log->save();
                }
            }

            DB::commit();
            return redirect()->route('sale.sale_receipt_details', ['invoice' => $invoice->id]);
        } catch (\Exception $exception) {
            DB::rollBack();

            return redirect()->back()->with('error', $exception->getMessage())->withInput();
        }
    }

    public function saleReceipt()
    {
        return view('sale::sale.receipt.all');
    }

    public function saleReceiptDetails(Invoice $invoice)
    {
        //        $invoice = Invoice::with('customer','products')->where('id',$invoice)->first()->toArray();
        //        dd($invoice);

        return view('sale::sale.receipt.details', compact('invoice'));
    }

    public function edit($id)
    {
        return view('sale::edit');
    }

    //Insert Sale Cedit Voucher
    public function insertSaleCreditVoucher($is_credit = null, $invoice_id = null, $dbtid = null, $amountType = null, $amount = null, $Narration = null, $Comment = null, $reVID = null, $subCodeId = null)
    {

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
            if ($amountType == 'Debit') {
                $accVoucher->Debit = $amount;
                $accVoucher->Credit = 0.00;
            } else {
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
        } else {
            $Vtype = 'CV';
            $voucherNo = voucherNo($Vtype);

            $accVoucher = new AccVoucher();
            $accVoucher->fyear = $fyear;
            $accVoucher->VNo = $voucherNo;
            $accVoucher->Vtype = 'CV';
            $accVoucher->referenceNo = $invoice_id;
            if ($amountType == 'Debit') {
                $accVoucher->Debit = $amount;
                $accVoucher->Credit = 0.00;
            } else {
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

    public function insertSaleInventoryVoucher($invoice_id = null, $dbtid = null, $amount = null, $Narration = null, $Comment = null, $reVID = null)
    {

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
}
