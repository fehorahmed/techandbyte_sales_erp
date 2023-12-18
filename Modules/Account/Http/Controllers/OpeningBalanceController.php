<?php

namespace Modules\Account\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Modules\Account\Entities\AccCoa;
use Modules\Account\Entities\AccOpeningBalance;
use Modules\Account\Entities\AccSubcode;
use Modules\Account\Entities\AccVoucher;
use Modules\Account\Entities\FinancialYear;
use Yajra\DataTables\Facades\DataTables;

class OpeningBalanceController extends Controller{
    public function index(){
        return view('account::opening_balance.all');
    }
    public function datatable(){
        $query = AccOpeningBalance::query();
        return DataTables::eloquent($query)
            ->addIndexColumn()
            ->addColumn('action', function(AccOpeningBalance $accOpeningBalance) {
                $btn = '<a class="btn-view" role="button" data-id="'.$accOpeningBalance->id.'" data-toggle="modal" style="cursor: pointer;"><i style="color:#01a9ac;font-size: 17px;margin-right: 10px;" class="feather icon-eye"></i></a>';
                $btn .= '<a href="'.route('account.opening_balance_edit',['accVoucher'=>$accOpeningBalance->id]).'" class="btn-edit"><i style="color:#350ff0;font-size: 17px;" class="feather icon-edit"></i></a>';
                return $btn;
            })
            ->addColumn('COAID', function (AccOpeningBalance $accOpeningBalance){
                return $accOpeningBalance->account->HeadName??'';
            })
            ->addColumn('subType', function (AccOpeningBalance $accOpeningBalance){
                return $accOpeningBalance->sub_account->name??'';
            })
            ->rawColumns(['action'])
            ->toJson();
    }
    public function add(){
        $financial_years = FinancialYear::orderBy('yearName')->get();
        return view('account::opening_balance.add',compact('financial_years'));
    }

    public function addPost(Request $request){
        //dd($request->all());
        $request->validate([
            'financial_year' => ['required','numeric'],
            'account_code.*' => ['required','numeric'],
        ]);

        try {
            DB::beginTransaction();
            for ($i=0; $i<count($request->account_code); $i++){
                //dd(voucherNo('DV'));
                $isSubtype = $request->isSubtype[$i];
                if($isSubtype != 1) {
                    $subcodeId = $request->subtype[$i];
                    $refno = AccSubcode::where('id',$subcodeId)->first()->referenceNo;
                } else {
                    $subcodeId = null;
                    $refno = null;
                }

                $accVoucher = new AccOpeningBalance();
                $accVoucher->fyear = $request->financial_year;
                $accVoucher->COAID = $request->account_code[$i];
                $accVoucher->subType = $isSubtype;//SubType Table ID
                $accVoucher->subCode = $subcodeId;//SubCode Table ID
                $accVoucher->Debit = $request->debit[$i] ?? 0.00;
                $accVoucher->Credit = $request->credit[$i] ?? 0.00;
                $accVoucher->openDate = date('Y-m-d',strtotime($request->date));
                $accVoucher->CreateBy = Auth::user()->id;
                $accVoucher->save();
            }

            DB::commit();
            return redirect()->route('account.opening_balance')->with('message','Information added');
        }catch (\Exception $e){
            DB::rollBack();
            return redirect()->back()->with('error',$e)->withInput();
        }
    }

    public function edit(AccOpeningBalance $accOpeningBalance){
        return view('account::journal_voucher.edit', compact('accOpeningBalance'));
    }

    public function editPost(Request $request, AccOpeningBalance $accOpeningBalance){
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

        return redirect()->route('account.journal_voucher')->with('message','Information updated');
    }
}
