<?php

namespace Modules\Bank\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Modules\Account\Entities\AccCoa;
use Modules\Bank\Entities\Bank;
use Ramsey\Uuid\Uuid;
use Yajra\DataTables\Facades\DataTables;

class BankController extends Controller
{
    public function index(){
        return view('bank::bank.all');
    }
    public function datatable(){
        $query = Bank::query();
        return DataTables::eloquent($query)
            ->addIndexColumn()
            ->addColumn('action', function(Bank $bank) {
                return '<a href="'.route('bank.bank_edit',['bank'=>$bank->id]).'" class="btn-edit"><i style="color:#01a9ac;font-size: 17px;" class="feather icon-edit"></i></a>';
            })
            ->editColumn('balance', function (Bank $bank){
                return $bank->bank_name.'123';
            })
            ->addColumn('signature_pic', function(Bank $bank) {
                return '<img height="30px" src="'.asset($bank->signature_pic).'"   alt="">';
            })
            ->rawColumns(['action','signature_pic'])
            ->toJson();
    }
    public function add(){
        return view('bank::bank.add');
    }

    public function addPost(Request $request){
//        dd($request->all());
        $request->validate([
            'bank_name' => ['required','string','max:255',Rule::unique('banks')],
            'ac_name' => ['required','string','max:255'],
            'ac_number' => 'required|string|numeric',
            'branch' => 'required|string|max:255',
            'signature_pic' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $check_exist_bank = AccCoa::where('HeadName',$request->bank_name)->first();
        if(!empty($check_exist_bank)){
            return redirect()->back()->with('error','Bank exists!');
        }
        $headcode = AccCoa::where('HeadLevel',4)->where('HeadCode','like','10205%')->max('HeadCode');
        if($headcode != NULL){
            $headcode += 1;
        }else{
            $headcode = "1020501";
        }
//        dd($headcode);
        try {
            DB::beginTransaction();
            $bank = new Bank();
            $bank->bank_name = $request->bank_name;
            $bank->ac_name = $request->ac_name;
            $bank->ac_number = $request->ac_number;
            $bank->branch = $request->branch;
            $bank->status = 1;
            if ($request->signature_pic) {

                $file = $request->file('signature_pic');
                $filename = Uuid::uuid1()->toString() . '.' . $file->extension();
                $destinationPath = 'uploads/signature_image';
                $file->move($destinationPath, $filename);
                $path = 'uploads/signature_image/' . $filename;

                $bank->signature_pic = $path;
            }
            $bank->save();

            $acc_coa = new AccCoa();
            $acc_coa->HeadCode = $headcode;
            $acc_coa->HeadName = $request->bank_name;
            $acc_coa->PHeadName = 'Cash at Bank';
            $acc_coa->Pheadcode = 10205;
            $acc_coa->HeadLevel = 4;
            $acc_coa->IsActive = 1;
            $acc_coa->IsTransaction = 0;
            $acc_coa->IsGL = 0;
            $acc_coa->isCashNature = 0;
            $acc_coa->isBankNature = 1;
            $acc_coa->HeadType = 'A';
            $acc_coa->IsBudget = 0;
            $acc_coa->IsDepreciation = 0;
            $acc_coa->customer_id = 0;
            $acc_coa->supplier_id = 0;
            $acc_coa->bank_id = 0;
            $acc_coa->service_id = 0;
            $acc_coa->DepreciationRate = 0;
            $acc_coa->CreateBy = Auth::user()->id;
            $acc_coa->UpdateBy = 0;
            $acc_coa->isSubType = 0;
            $acc_coa->subType = 0;
            $acc_coa->isStock = 0;
            $acc_coa->isFixedAssetSch = 0;
            $acc_coa->noteNo = 0;
            $acc_coa->assetCode = 0;
            $acc_coa->depCode = 0;
            $acc_coa->save();
            DB::commit();
            return redirect()->route('bank.bank_all')->with('message','Information added');
        }catch (\Exception $e){
            DB::rollBack();
            return redirect()->route('bank.bank_all')->with('error','Opps! Error occured!!!');
        }
    }

    public function edit(Bank $bank){
        return view('bank::bank.edit', compact('bank'));
    }

    public function editPost(Request $request, Bank $bank){
        $request->validate([
            'bank_name' => ['required','string','max:255',Rule::unique('banks')->ignore($bank)],
            'ac_name' => ['required','string','max:255'],
            'ac_number' => 'required|string|numeric',
            'branch' => 'required|string|max:255',

        ]);
        try {
            DB::beginTransaction();
            AccCoa::where('HeadName',$bank->bank_name)->update(['HeadName'=>$request->bank_name]);

            $bank->bank_name = $request->bank_name;
            $bank->ac_name = $request->ac_name;
            $bank->ac_number = $request->ac_number;
            $bank->branch = $request->branch;
            $bank->status = 1;
            if ($request->signature_pic) {
                if (file_exists($bank->signature_pic)) {
                    unlink($bank->signature_pic);
                }
                $file = $request->file('signature_pic');
                $filename = Uuid::uuid1()->toString() . '.' . $file->extension();
                $destinationPath = 'uploads/signature_image';
                $file->move($destinationPath, $filename);
                $path = 'uploads/signature_image/' . $filename;

                $bank->signature_pic = $path;
            }
            $bank->save();
            DB::commit();
            return redirect()->route('bank.bank_all')->with('message','Information updated');
        }catch (\Exception $e){
            DB::rollBack();
            return redirect()->route('bank.bank_all')->with('error','Opps! Error occured!!!');
        }
    }

    public function delete($id){
        //
    }
}
