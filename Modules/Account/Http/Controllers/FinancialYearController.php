<?php

namespace Modules\Account\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Modules\Account\Entities\FinancialYear;
use Yajra\DataTables\Facades\DataTables;

class FinancialYearController extends Controller{
    public function index(){
        return view('account::financial_year.all');
    }
    public function datatable(){
        $query = FinancialYear::query();
        return DataTables::eloquent($query)
            ->addIndexColumn()
            ->addColumn('action', function(FinancialYear $financialYear) {
                return '<a href="'.route('account.financialyear_edit',['financialYear'=>$financialYear->id]).'" class="btn-edit"><i style="color:#01a9ac;font-size: 17px;" class="feather icon-edit"></i></a>';
            })
            ->addColumn('status', function(FinancialYear $financialYear) {
                if ($financialYear->status == 1)
                    return '<span class="badge badge-success">Active</span>';
                else
                    return '<span class="badge badge-danger">Inactive</span>';
            })
            ->addColumn('startDate', function (FinancialYear $financialYear){
                return date('d-m-Y', strtotime($financialYear->startDate));
            })
            ->addColumn('endDate', function (FinancialYear $financialYear){
                return date('d-m-Y', strtotime($financialYear->endDate));
            })
            ->rawColumns(['action','status'])
            ->toJson();
    }
    public function add(){
        return view('account::financial_year.add');
    }

    public function addPost(Request $request){
//        dd($request->all());
        $request->validate([
            'yearName' => ['required','string',Rule::unique('financial_years')],
            'status' => ['required','numeric'],
            'financial_year_start_date' => ['required','string'],
            'financial_year_end_date' => ['required','string'],
        ]);

        $chkstart   = FinancialYear::where('startDate','<=',$request->financial_year_start_date)->where('endDate','>=',$request->financial_year_start_date)->get();
        $chkend     = FinancialYear::where('startDate','<=',$request->financial_year_end_date)->where('endDate','>=',$request->financial_year_end_date)->get();
        $chkbtn     = FinancialYear::where('startDate','>=',$request->financial_year_start_date)->where('endDate','<=',$request->financial_year_end_date)->get();

        if(strtotime($request->financial_year_start_date) > strtotime($request->financial_year_end_date)){
            return redirect()->back()->with('error','Please select valid start & end date...')->withInput();
        }else if($chkstart > 0 || $chkend > 0|| $chkbtn > 0){
            return redirect()->back()->with('error','Invalid Date, Start date or End date fall into an old Financial Year')->withInput();
        }

        $financialYear = new FinancialYear();
        $financialYear->yearName  = $request->yearName;
        $financialYear->startDate = date('Y-m-d',strtotime($request->financial_year_start_date));
        $financialYear->endDate = date('Y-m-d',strtotime($request->financial_year_end_date));
        $financialYear->created_by = Auth::user()->id;
        $financialYear->status = $request->status;;
        $financialYear->save();

        return redirect()->route('account.financialyear_all')->with('message','Information added');
    }

    public function edit(FinancialYear $financialYear){
        return view('account::financial_year.edit', compact('financialYear'));
    }

    public function editPost(Request $request, FinancialYear $financialYear){
        $request->validate([
            'yearName' => ['required','string',Rule::unique('financial_years')->ignore($financialYear)],
            'status' => ['required','numeric'],
            'financial_year_start_date' => ['required','string'],
            'financial_year_end_date' => ['required','string'],
        ]);
        if(strtotime($request->financial_year_start_date) > strtotime($request->financial_year_end_date)){
            return redirect()->back()->with('error','Please select valid start & end date...')->withInput();
        }
        $financialYear->yearName = $request->yearName;
        $financialYear->startDate = date('Y-m-d',strtotime($request->financial_year_start_date));
        $financialYear->endDate = date('Y-m-d',strtotime($request->financial_year_end_date));
        $financialYear->updated_by = Auth::user()->id;
        $financialYear->status = $request->status;
        $financialYear->save();

        return redirect()->route('account.financialyear_all')->with('message','Information updated');
    }

    public function delete($id){
        //
    }
}
