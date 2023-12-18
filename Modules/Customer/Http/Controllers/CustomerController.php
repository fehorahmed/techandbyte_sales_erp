<?php

namespace Modules\Customer\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Account\Entities\AccCoa;
use Modules\Account\Entities\AccSubcode;
use Modules\Customer\Entities\Customer;
use Modules\Supplier\Entities\Supplier;
use Yajra\DataTables\Facades\DataTables;

class CustomerController extends Controller
{
    public function index(){
        return view('customer::customer.all');
    }
    public function datatable(){
        $query = Customer::query();
        return DataTables::eloquent($query)
            ->addIndexColumn()
            ->addColumn('action', function(Customer $customer) {
                return '<a href="'.route('customer.customer_edit',['customer'=>$customer->id]).'" class="btn-edit"><i style="color:#01a9ac;font-size: 17px;" class="feather icon-edit"></i></a>';
            })
            ->addColumn('status', function(Customer $customer) {
                if ($customer->status == 1)
                    return '<span class="badge badge-success">Active</span>';
                else
                    return '<span class="badge badge-danger">Inactive</span>';
            })
            ->rawColumns(['action','status'])
            ->toJson();
    }
    public function add(){
        return view('customer::customer.add');
    }

    public function addPost(Request $request){
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['nullable','string','email','max:255',Rule::unique('customers')],
            'phone' => 'required|string|digits:11',
            'address' => 'nullable|string|max:255',
//            'opening_balance' => 'required|numeric',
            'status' => 'required',
        ]);

        $headcode = AccCoa::where('HeadLevel',4)->where('HeadCode','like','113100%')->max('HeadCode');
        if($headcode != NULL){
            $headcode += 1;
        }else{
            $headcode="113100000001";
        }
        try {
            DB::beginTransaction();
            $customer = new Customer();
            $customer->name = $request->name;
            $customer->email = $request->email;
            $customer->phone = $request->phone;
            $customer->address = $request->address;
            $customer->status = $request->status;
            $customer->created_by = Auth::user()->id;
            $customer->save();

            $acc_coa = new AccCoa();
            $acc_coa->HeadCode = $headcode;
            $acc_coa->HeadName = $request->name.'-'.$customer->id;
            $acc_coa->PHeadName = 'Customers';
            $acc_coa->HeadLevel = 4;
            $acc_coa->IsActive = 1;
            $acc_coa->IsTransaction = 1;
            $acc_coa->IsGL = 0;
            $acc_coa->HeadType = 'A';
            $acc_coa->IsBudget = 0;
            $acc_coa->customer_id = $customer->id;
            $acc_coa->IsDepreciation = 0;
            $acc_coa->DepreciationRate = 0;
            $acc_coa->CreateBy = Auth::user()->id;
            $acc_coa->UpdateBy = 0;
            //$acc_coa->save();

            $acc_subcode = new AccSubcode();
            $acc_subcode->subTypeId = 3;
            $acc_subcode->name = $request->name;
            $acc_subcode->referenceNo = $customer->id;
            $acc_subcode->created_by = Auth::user()->id;
            $acc_subcode->updated_by = 0;
            $acc_subcode->status = 1;
            $acc_subcode->save();

            DB::commit();
            return redirect()->route('customer.customer_all')->with('message','Information added');
        }catch (\Exception $e){
            DB::rollBack();
            return redirect()->back()->with('error',$e)->withInput();
        }
    }

    public function addAjaxPost(Request $request){
        $rules = [
            'name' => 'required|string|max:255',
            'email' => ['nullable','string','email','max:255',Rule::unique('customers')],
            'phone' => 'required|string|digits:11',
            'address' => 'nullable|string|max:255',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
        }

        try {
            DB::beginTransaction();
            $customer = new Customer();
            $customer->name = $request->name;
            $customer->email = $request->email;
            $customer->phone = $request->phone;
            $customer->address = $request->address;
            $customer->status = 1;
            $customer->created_by = Auth::user()->id;
            $customer->save();

            $acc_subcode = new AccSubcode();
            $acc_subcode->subTypeId = 4;
            $acc_subcode->name = $request->name;
            $acc_subcode->referenceNo = $customer->id;
            $acc_subcode->created_by = Auth::user()->id;
            $acc_subcode->updated_by = 0;
            $acc_subcode->status = 1;
            $acc_subcode->save();

            DB::commit();
            return response()->json(['success' => true, 'message' => 'added','customer'=>$customer]);
        }catch (\Exception $e){
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e]);
        }
    }

    public function edit(Customer $customer){
        return view('customer::customer.edit', compact('customer'));
    }

    public function editPost(Request $request, Customer $customer){
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['nullable','string','email','max:255',Rule::unique('customers')->ignore($customer)],
            'phone' => 'required|string|digits:11',
            'address' => 'nullable|string|max:255',
            'status' => 'required',
        ]);


        try {
            DB::beginTransaction();
            $customer->name = $request->name;
            $customer->email = $request->email;
            $customer->phone = $request->phone;
            $customer->address = $request->address;
            $customer->status = $request->status;
            $customer->save();

            //AccCoa::where('customer_id',$customer->id)->update(['HeadName'=>$request->name.'-'.$customer->id]);
            AccSubcode::where('referenceNo',$customer->id)->where('subTypeId', 3)->update(['name'=>$request->name]);

            DB::commit();
            return redirect()->route('customer.customer_all')->with('message','Information updated');
        }catch (\Exception $e){
            DB::rollBack();
            return redirect()->back()->with('error',$e)->withInput();
        }
    }

    public function delete($id){
        //
    }
}
