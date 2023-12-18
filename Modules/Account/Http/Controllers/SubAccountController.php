<?php

namespace Modules\Account\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Modules\Account\Entities\AccSubcode;
use Modules\Account\Entities\AccSubtype;
use Modules\Bank\Entities\Bank;
use Ramsey\Uuid\Uuid;
use Yajra\DataTables\Facades\DataTables;

class SubAccountController extends Controller
{
    public function index(){
        return view('account::sub_account.all');
    }
    public function datatable(){
        $query = AccSubcode::query();
        return DataTables::eloquent($query)
            ->addIndexColumn()
            ->addColumn('action', function(AccSubcode $accSubCode) {
                return '<a href="'.route('account.sub_account_edit',['accSubCode'=>$accSubCode->id]).'" class="btn-edit"><i style="color:#01a9ac;font-size: 17px;" class="feather icon-edit"></i></a>';
            })
            ->addColumn('created_at', function (AccSubcode $accSubCode){
                return date('d-m-Y', strtotime($accSubCode->created_at));
            })
            ->addColumn('subTypeId', function (AccSubcode $accSubCode){
                return $accSubCode->accSubType->subtypeName??'';
            })
            ->rawColumns(['action'])
            ->toJson();
    }
    public function add(){
        $accSubTypes = AccSubtype::all();
        return view('account::sub_account.add',compact('accSubTypes'));
    }

    public function addPost(Request $request){
//        dd($request->all());
        $request->validate([
            'subtype' => ['required','numeric'],
            'account_name' => ['required','string','max:255'],
        ]);
        $accSubCode = new AccSubcode();
        $accSubCode->subTypeId  = $request->subtype;
        $accSubCode->name = $request->account_name;
        $accSubCode->referenceNo = 0;
        $accSubCode->created_by = Auth::user()->id;
        $accSubCode->updated_by = Auth::user()->id;
        $accSubCode->status = 1;
        $accSubCode->save();

        return redirect()->route('account.sub_account_all')->with('message','Information added');
    }

    public function edit(AccSubcode $accSubCode){
        $accSubTypes = AccSubtype::all();
        return view('account::sub_account.edit', compact('accSubCode','accSubTypes'));
    }

    public function editPost(Request $request, AccSubcode $accSubCode){
        $request->validate([
            'subtype' => ['required','numeric'],
            'account_name' => ['required','string','max:255'],
        ]);
        $accSubCode->subTypeId = $request->subtype;
        $accSubCode->name = $request->account_name;
        $accSubCode->updated_by = Auth::user()->id;
        $accSubCode->status = 1;
        $accSubCode->save();

        return redirect()->route('account.sub_account_all')->with('message','Information updated');
    }

    public function delete($id){
        //
    }
}
