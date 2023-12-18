<?php

namespace Modules\Supplier\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Modules\Account\Entities\AccCoa;
use Modules\Account\Entities\AccSubcode;
use Modules\Supplier\Entities\Supplier;
use Yajra\DataTables\Facades\DataTables;

class SupplierController extends Controller
{
    public function index(){
        return view('supplier::supplier.all');
    }
    public function datatable(){
        $query = Supplier::query();
        return DataTables::eloquent($query)
            ->addIndexColumn()
            ->addColumn('action', function(Supplier $supplier) {
                return '<a href="'.route('supplier.supplier_edit',['supplier'=>$supplier->id]).'" class="btn-edit"><i style="color:#01a9ac;font-size: 17px;" class="feather icon-edit"></i></a>';
            })
            ->addColumn('status', function(Supplier $supplier) {
                if ($supplier->status == 1)
                    return '<span class="badge badge-success">Active</span>';
                else
                    return '<span class="badge badge-danger">Inactive</span>';
            })
            ->rawColumns(['action','status'])
            ->toJson();
    }
    public function add(){
        return view('supplier::supplier.add');
    }

    public function addPost(Request $request){
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['nullable','string','email','max:255',Rule::unique('suppliers')],
            'phone' => 'required|string|digits:11',
            'address' => 'nullable|string|max:255',
            'opening_balance' => 'required|numeric',
            'status' => 'required',
        ]);

        $headcode = AccCoa::where('HeadLevel',4)->where('HeadCode','like','21110%')->max('HeadCode');
        if($headcode != NULL){
            $headcode += 1;
        }else{
            $headcode="21110000001";
        }

        try {
            DB::beginTransaction();
            $supplier = new Supplier();
            $supplier->name = $request->name;
            $supplier->email = $request->email;
            $supplier->phone = $request->phone;
            $supplier->address = $request->address;
            $supplier->opening_balance = $request->opening_balance;
            $supplier->status = $request->status;
            $supplier->created_by = Auth::user()->id;
            $supplier->save();

            $acc_coa = new AccCoa();
            $acc_coa->HeadCode = $headcode;
            $acc_coa->HeadName = $request->name.'-'.$supplier->id;
            $acc_coa->PHeadName = 'Suppliers';
            $acc_coa->HeadLevel = 4;
            $acc_coa->IsActive = 1;
            $acc_coa->IsTransaction = 1;
            $acc_coa->IsGL = 0;
            $acc_coa->HeadType = 'L';
            $acc_coa->IsBudget = 0;
            $acc_coa->supplier_id = $supplier->id;
            $acc_coa->IsDepreciation = 0;
            $acc_coa->DepreciationRate = 0;
            $acc_coa->CreateBy = Auth::user()->id;
            $acc_coa->UpdateBy = 0;
            //dd($acc_coa);
            //$acc_coa->save();

            $acc_subcode = new AccSubcode();
            $acc_subcode->subTypeId = 4;
            $acc_subcode->name = $request->name;
            $acc_subcode->referenceNo = $supplier->id;
            $acc_subcode->created_by = Auth::user()->id;
            $acc_subcode->updated_by = 0;
            $acc_subcode->status = 1;
            $acc_subcode->save();

            DB::commit();
            return redirect()->route('supplier.supplier_all')->with('message','Information added');
        }catch (\Exception $e){
            DB::rollBack();
            return redirect()->back()->with('error','Opps! Error occured!!!')->withInput();
        }
    }

    public function addAjaxPost(Request $request){
        $rules = [
            'name' => 'required|string|max:255',
            'email' => ['nullable','string','email','max:255',Rule::unique('suppliers')],
            'phone' => 'required|string|digits:11',
            'address' => 'nullable|string|max:255',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
        }

        try {
            DB::beginTransaction();
            $supplier = new Supplier();
            $supplier->name = $request->name;
            $supplier->email = $request->email;
            $supplier->phone = $request->phone;
            $supplier->address = $request->address;
            $supplier->opening_balance = 0;
            $supplier->status = 1;
            $supplier->created_by = Auth::user()->id;
            $supplier->save();

            $acc_subcode = new AccSubcode();
            $acc_subcode->subTypeId = 4;
            $acc_subcode->name = $request->name;
            $acc_subcode->referenceNo = $supplier->id;
            $acc_subcode->created_by = Auth::user()->id;
            $acc_subcode->updated_by = 0;
            $acc_subcode->status = 1;
            $acc_subcode->save();

            DB::commit();
            return response()->json(['success' => true, 'message' => 'added','supplier'=>$supplier]);
        }catch (\Exception $e){
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e]);
        }
    }

    public function edit(Supplier $supplier){
        return view('supplier::supplier.edit', compact('supplier'));
    }

    public function editPost(Request $request, Supplier $supplier){
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['nullable','string','email','max:255',Rule::unique('suppliers')->ignore($supplier)],
            'phone' => 'required|string|digits:11',
            'address' => 'nullable|string|max:255',
            'opening_balance' => 'required|numeric',
            'status' => 'required',
        ]);


        try {
            DB::beginTransaction();
            $supplier->name = $request->name;
            $supplier->email = $request->email;
            $supplier->phone = $request->phone;
            $supplier->address = $request->address;
            $supplier->opening_balance = $request->opening_balance;
            $supplier->status = $request->status;
            $supplier->save();

            //AccCoa::where('supplier_id',$supplier->id)->update(['HeadName'=>$request->name.'-'.$supplier->id]);
            AccSubcode::where('referenceNo',$supplier->id)->where('subTypeId', 4)->update(['name'=>$request->name]);

            DB::commit();
            return redirect()->route('supplier.supplier_all')->with('message','Information updated');
        }catch (\Exception $e){
            DB::rollBack();
            return redirect()->back()->with('error',$e)->withInput();
        }
    }

    public function delete($id){
        //
    }
}
