<?php

namespace Modules\Account\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Modules\Account\Entities\AccCoa;
use Modules\Account\Entities\AccSubcode;
use Modules\Account\Entities\AccVoucher;
use Yajra\DataTables\Facades\DataTables;

class CreditVoucherController extends Controller{
    public function index(){
        return view('account::credit_voucher.all');
    }
    public function datatable(){
        $query = AccVoucher::query();
        $query->where('Vtype','CV');
        return DataTables::eloquent($query)
            ->addIndexColumn()
            ->addColumn('action', function(AccVoucher $accVoucher) {
                $btn = '<a class="btn-view" role="button" data-id="'.$accVoucher->id.'" data-toggle="modal" style="cursor: pointer;"><i style="color:#01a9ac;font-size: 17px;margin-right: 10px;" class="feather icon-eye"></i></a>';
                $btn .= '<a href="'.route('account.credit_voucher_edit',['accVoucher'=>$accVoucher->id]).'" class="btn-edit"><i style="color:#350ff0;font-size: 17px;" class="feather icon-edit"></i></a>';
                return $btn;
            })
            ->addColumn('COAID', function (AccVoucher $accVoucher){
                return $accVoucher->account->HeadName??'';
            })
            ->addColumn('RevCodde', function (AccVoucher $accVoucher){
                return $accVoucher->rev_account->HeadName??'';
            })
            ->addColumn('subType', function (AccVoucher $accVoucher){
                return $accVoucher->sub_account->name??'';
            })
            ->rawColumns(['action'])
            ->toJson();
    }
    public function add(){
        $transactionHeads = AccCoa::where('isBankNature',0)->where('isCashNature',0)->where('HeadLevel', 4)->where('IsActive', 1)->orderBy('HeadName')->get();
        $cashBankHeads = AccCoa::where('isBankNature',1)->orWhere('isCashNature',1)->where('HeadLevel', 4)->where('IsActive', 1)->orderBy('HeadName')->get();
        return view('account::credit_voucher.add',compact('transactionHeads','cashBankHeads'));
    }

    public function addPost(Request $request){
//        dd($request->all());
        $request->validate([
            'credit_account_code' => ['required','numeric'],
            'account_code.*' => ['required','numeric'],
            'amount.*' => ['required','numeric'],
        ]);

        try {
            DB::beginTransaction();
            for ($i=0; $i<count($request->account_code); $i++){
//                dd(voucherNo('DV'));
                $isSubtype = $request->isSubtype[$i];
                if($isSubtype != 1) {
                    $subcodeId = $request->subtype[$i];
                    $refno = AccSubcode::where('id',$subcodeId)->first()->referenceNo;
                } else {
                    $subcodeId = null;
                    $refno = null;
                }
                if(isset($request->ishonours)) {
                    $ishonour = 1;
                } else {
                    $ishonour = 0;
                }

                $accVoucher = new AccVoucher();
                $accVoucher->fyear = financial_year();
                $accVoucher->VNo = voucherNo('CV');
                $accVoucher->Vtype = 'CV';
                $accVoucher->referenceNo = $refno;
                $accVoucher->VDate = date('Y-m-d',strtotime($request->date));
                $accVoucher->COAID = $request->credit_account_code;
                $accVoucher->Narration = $request->remark;
                $accVoucher->chequeNo = $request->cheque_no;
                $accVoucher->chequeDate = date('Y-m-d',strtotime($request->cheque_date))??'';
                $accVoucher->isHonour = $ishonour;
                $accVoucher->ledgerComment = $request->comment[$i];
                $accVoucher->Debit = 0.00;
                $accVoucher->Credit = $request->amount[$i];
                $accVoucher->RevCodde = $request->account_code[$i];
                $accVoucher->subType = $isSubtype;
                $accVoucher->subCode = $subcodeId;
                $accVoucher->isApproved = 0;
                $accVoucher->CreateBy = Auth::user()->id;
                $accVoucher->status = 0;
                $accVoucher->save();
            }

            DB::commit();
            return redirect()->route('account.credit_voucher')->with('message','Information added');
        }catch (\Exception $e){
            DB::rollBack();
            return redirect()->back()->with('error',$e)->withInput();
        }
    }

    public function edit(AccVoucher $accVoucher){
        return view('account::credit_voucher.edit', compact('accVoucher'));
    }

    public function editPost(Request $request, AccVoucher $accVoucher){
        $request->validate([
            'yearName' => ['required','string',Rule::unique('financial_years')->ignore($accVoucher)],
            'status' => ['required','numeric'],
            'financial_year_start_date' => ['required','string'],
            'financial_year_end_date' => ['required','string'],
        ]);
        if(strtotime($request->financial_year_start_date) > strtotime($request->financial_year_end_date)){
            return redirect()->back()->with('error','Please select valid start & end date...')->withInput();
        }
        $accVoucher->yearName = $request->yearName;
        $accVoucher->startDate = date('Y-m-d',strtotime($request->financial_year_start_date));
        $accVoucher->endDate = date('Y-m-d',strtotime($request->financial_year_end_date));
        $accVoucher->updated_by = Auth::user()->id;
        $accVoucher->status = $request->status;
        $accVoucher->save();

        return redirect()->route('account.credit_voucher')->with('message','Information updated');
    }


    public function VoucherView(Request $request){

        $accVoucher=AccVoucher::with('details','sub_account','rev_account')->where('id',$request->accVoucherId)->first();
        $creditVoucherDetails = view('account::credit_voucher.view',compact('accVoucher'))->render();

        return response()->json([
            'html'=>$creditVoucherDetails,
        ]);

    }
}
