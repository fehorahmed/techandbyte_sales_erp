<?php

namespace Modules\Account\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Modules\Account\Entities\AccCoa;
use Modules\Account\Entities\AccPredefineAccount;
use Modules\Account\Entities\AccSubcode;
use Modules\Account\Entities\AccTransaction;
use Modules\Account\Entities\AccVoucher;
use Modules\Customer\Entities\Customer;
use Modules\Purchase\Entities\ProductPurchase;
use Modules\Sale\Entities\Invoice;

class AccountController extends Controller{
    public function predefineAccounts(){
        $transactionHeads = AccCoa::where('HeadLevel', 4)->orWhere('HeadLevel', 3)->orWhere('HeadLevel', 2)->where('IsActive', 1)->orderBy('HeadName')->get();
        return view('account::predefined_accounts.all',compact('transactionHeads'));
    }
    public function predefineAccountsAdd(Request $request){
        $predefined_account = AccPredefineAccount::where('id',1)->first();
        $predefined_account->cashCode = $request->cashCode ?? 0;
        $predefined_account->bankCode = $request->bankCode ?? 0;
        $predefined_account->advance = $request->advance ?? 0;
        $predefined_account->fixedAsset = $request->fixedAsset ?? 0;
        $predefined_account->purchaseCode = $request->purchaseCode ?? 0;
        $predefined_account->salesCode = $request->salesCode ?? 0;
        $predefined_account->serviceCode = $request->serviceCode ?? 0;
        $predefined_account->customerCode = $request->customerCode ?? 0;
        $predefined_account->supplierCode = $request->supplierCode ?? 0;
        $predefined_account->costs_of_good_solds = $request->costs_of_good_solds ?? 0;
        $predefined_account->vat = $request->vat ?? 0;
        $predefined_account->tax = $request->tax ?? 0;
        $predefined_account->inventoryCode = $request->inventoryCode ?? 0;
        $predefined_account->CPLCode = $request->CPLCode ?? 0;
        $predefined_account->LPLCode = $request->LPLCode ?? 0;
        $predefined_account->salary_code = $request->salary_code ?? 0;
        $predefined_account->emp_npf_contribution = $request->emp_npf_contribution ?? 0;
        $predefined_account->empr_npf_contribution = $request->empr_npf_contribution ?? 0;
        $predefined_account->emp_icf_contribution = $request->emp_icf_contribution ?? 0;
        $predefined_account->empr_icf_contribution = $request->empr_icf_contribution ?? 0;
        $predefined_account->prov_state_tax = $request->prov_state_tax ?? 0;
        $predefined_account->state_tax = $request->state_tax ?? 0;
        $predefined_account->prov_npfcode = $request->prov_npfcode ?? 0;
        $predefined_account->save();

        return redirect()->route('account.predefined_accounts')->with('message','Information Updated!');
    }

    //Start Supplier Payment
    public function supplierPaymentAdd(){
        $transactionHeads = AccCoa::where('isBankNature',0)->where('isCashNature',0)->where('HeadLevel', 4)->where('IsActive', 1)->orderBy('HeadName')->get();
        $cashBankHeads = AccCoa::where('isBankNature',1)->orWhere('isCashNature',1)->where('HeadLevel', 4)->where('IsActive', 1)->orderBy('HeadName')->get();
        return view('account::supplier_payment.add',compact('transactionHeads','cashBankHeads'));
    }
    public function supplierDueList(Request $request){
        $invoices = ProductPurchase::where('supplier_id',$request->supplierId)->where('due_amount','>',0)->get();
        return response([
            'status' => true,
            'invoices' => $invoices,
        ]);
    }
    public function supplierVoucherDetail(Request $request){
        $invoice = ProductPurchase::where('id',$request->voucherId)->first();
        return response([
            'status' => true,
            'invoice' => $invoice,
        ]);
    }
    public function supplierPaymentAddPost(Request $request){
        //dd($request->all());
        $request->validate([
            'supplier' => ['required','numeric'],
            'voucher_no' => ['required','numeric'],
            'amount' => ['required','numeric','min:1'],
            'account_code' => ['required','numeric'],
            'paid_amount' => ['required','numeric','min:1'],
            'date' => ['nullable','date'],
        ]);

        try {
            DB::beginTransaction();
            $purchaseOrder = ProductPurchase::where('id',$request->voucher_no)->first();
            $paid_amount = $purchaseOrder->paid_amount + $request->amount;
            $due_amount = $purchaseOrder->due_amount - $request->amount;
            $purchaseOrder->paid_amount = $paid_amount;
            $purchaseOrder->due_amount = $due_amount;
            $purchaseOrder->save();
            $predefine_account = AccPredefineAccount::where('id',1)->first();
            $subcodeID = AccSubcode::where('referenceNo',$purchaseOrder->supplier_id)->where('subTypeId', 4)->first()->id;
            //dd($subcodeID);

            $accVoucher = new AccVoucher();
            $accVoucher->fyear = financial_year();
            $accVoucher->VNo = voucherNo('DV');
            $accVoucher->Vtype = 'DV';
            $accVoucher->referenceNo = $purchaseOrder->id;
            $accVoucher->VDate = date('Y-m-d',strtotime($request->date));
            $accVoucher->COAID = $predefine_account->supplierCode;
            $accVoucher->Narration = "Purchase Due Voucher";
            $accVoucher->ledgerComment = "Purchase Due Voucher for supplier";
            $accVoucher->Debit = $request->amount;
            $accVoucher->Credit = 0.00;
            $accVoucher->RevCodde = $request->account_code;
            $accVoucher->subType = 4;//AccSubType table ID
            $accVoucher->subCode = $subcodeID;//AccSubCode table ID
            $accVoucher->isApproved = 0;
            $accVoucher->CreateBy = Auth::user()->id;
            $accVoucher->status = 0;
            $accVoucher->save();

            $vouchers = AccVoucher::where('referenceNo',$request->voucher_no)->where('status',0)->get();
            //dd($vouchers);
            foreach ($vouchers as $row) {
                //$data = $this->approved_vaucher($value->VNo, 'active');
                //Debit
                $accTransaction = new AccTransaction();
                $accTransaction->vid = $row->id;
                $accTransaction->fyear = financial_year();
                $accTransaction->VNo = $row->VNo;
                $accTransaction->Vtype = $row->Vtype;
                $accTransaction->referenceNo = $row->referenceNo;
                $accTransaction->VDate = $row->VDate;
                $accTransaction->COAID = $row->COAID;
                $accTransaction->Narration = $row->Narration;
                $accTransaction->chequeNo = $row->chequeNo?$row->chequeNo:'';
                $accTransaction->chequeDate = $row->chequeDate;
                $accTransaction->isHonour = $row->isHonour;
                $accTransaction->ledgerComment = $row->ledgerComment;
                $accTransaction->Debit = $row->Debit;
                $accTransaction->Credit = $row->Credit;
                $accTransaction->StoreID = 0;
                $accTransaction->IsPosted = 1;
                $accTransaction->RevCodde = $row->RevCodde;
                $accTransaction->subType = $row->subType;
                $accTransaction->subCode = $row->subCode;
                $accTransaction->IsAppoved = 1;
                $accTransaction->CreateBy = Auth::user()->id;
                $accTransaction->save();
                //Update monthly Balance

                //Credit
                $accTransaction = new AccTransaction();
                $accTransaction->vid = $row->id;
                $accTransaction->fyear = financial_year();
                $accTransaction->VNo = $row->VNo;
                $accTransaction->Vtype = $row->Vtype;
                $accTransaction->referenceNo = $row->referenceNo;
                $accTransaction->VDate = $row->VDate;
                $accTransaction->COAID = $row->RevCodde;
                $accTransaction->Narration = $row->Narration;
                $accTransaction->chequeNo = $row->chequeNo?$row->chequeNo:'';
                $accTransaction->chequeDate = $row->chequeDate;
                $accTransaction->isHonour = $row->isHonour;
                $accTransaction->ledgerComment = $row->ledgerComment;
                $accTransaction->Debit = $row->Debit;
                $accTransaction->Credit = $row->Credit;
                $accTransaction->StoreID = 0;
                $accTransaction->IsPosted = 1;
                $accTransaction->RevCodde = $row->COAID;
                $accTransaction->subType = $row->subType;
                $accTransaction->subCode = $row->subCode;
                $accTransaction->IsAppoved = 1;
                $accTransaction->CreateBy = Auth::user()->id;
                $accTransaction->save();
                //Update monthly Balance

            }
            AccVoucher::where('referenceNo',$request->voucher_no)->where('status',0)->update([
                'isApproved'  =>  1,
                'status'      =>  1,
                'approvedBy'  =>  Auth::user()->id,
                'approved_at' =>  date('Y-m-d',strtotime($request->date))
            ]);

            DB::commit();
            return redirect()->route('account.supplier_payment')->with('message','Information added');
        }catch (\Exception $e){
            DB::rollBack();
            return redirect()->back()->with('error',$e)->withInput();
        }
    }
    //End Supplier Payment

    //Start Customer Receive
    public function customerReceiveAdd(){
        $transactionHeads = AccCoa::where('isBankNature',0)->where('isCashNature',0)->where('HeadLevel', 4)->where('IsActive', 1)->orderBy('HeadName')->get();
        $cashBankHeads = AccCoa::where('isBankNature',1)->orWhere('isCashNature',1)->where('HeadLevel', 4)->where('IsActive', 1)->orderBy('HeadName')->get();
        return view('account::customer_receive.add',compact('transactionHeads','cashBankHeads'));
    }
    public function customerDueList(Request $request){
        $invoices = Invoice::where('customer_id',$request->customerId)->where('due_amount','>',0)->get();
        return response([
            'status' => true,
            'invoices' => $invoices,
        ]);
    }
    public function customerVoucherDetail(Request $request){
        $invoice = Invoice::where('id',$request->voucherId)->first();
        return response([
            'status' => true,
            'invoice' => $invoice,
        ]);
    }
    public function customerReceiveAddPost(Request $request){
//        dd($request->all());
        $request->validate([
            'customer' => ['required','numeric'],
            'voucher_no' => ['required','numeric'],
            'amount' => ['required','numeric','min:1'],
            'account_code' => ['required','numeric'],
            'paid_amount' => ['required','numeric','min:1'],
            'date' => ['required','date'],
        ]);
        try {
            DB::beginTransaction();
            $purchaseOrder = ProductPurchase::where('id',$request->voucher_no)->first();
            dd($purchaseOrder);

            DB::commit();
            return redirect()->route('account.contra_voucher')->with('message','Information added');
        }catch (\Exception $e){
            DB::rollBack();
            return redirect()->back()->with('error',$e)->withInput();
        }
    }
    //End Customer Receive

}
