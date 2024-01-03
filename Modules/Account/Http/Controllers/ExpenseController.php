<?php

namespace Modules\Account\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Modules\Account\Entities\AccTransaction;
use Modules\Account\Entities\ExpenseItem;
use Yajra\DataTables\Facades\DataTables;

class ExpenseController extends Controller
{
    public function index(){
        return view('account::expense.expense_item.all');
    }
    public function datatable(){
        $query = ExpenseItem::query();
        return DataTables::eloquent($query)
            ->addIndexColumn()
            ->addColumn('action', function(ExpenseItem $expenseItem) {
                return '<a href="'.route('account.expense_item_edit',['expenseItem'=>$expenseItem->id]).'" class="btn-edit"><i style="color:#01a9ac;font-size: 17px;" class="feather icon-edit"></i></a>';
            })
            ->addColumn('status', function(ExpenseItem $expenseItem) {
                if ($expenseItem->status == 1)
                    return '<span class="badge badge-success">Active</span>';
                else
                    return '<span class="badge badge-danger">Inactive</span>';
            })
            ->rawColumns(['action','status'])
            ->toJson();
    }
    public function add(){
        return view('account::expense.expense_item.add');
    }

    public function addPost(Request $request){
//        dd($request->all());
        $request->validate([
            'name' => ['required','string'],
        ]);


        $expenseItem = new ExpenseItem();
        $expenseItem->name  = $request->name;
        $expenseItem->save();

        return redirect()->route('account.expense_item_all')->with('message','Information added');
    }

    public function edit(ExpenseItem $expenseItem){
        return view('account::expense.expense_item.edit', compact('expenseItem'));
    }

    public function editPost(Request $request, ExpenseItem $expenseItem){
        $request->validate([
            'name' => ['required','string'],

        ]);
        $expenseItem->name  = $request->name;
        $expenseItem->save();


        return redirect()->route('account.expense_item_all')->with('message','Information updated');
    }

    public function expense(){
        return view('account::expense.all');
    }
    public function expenseDatatable(){
        $query = AccTransaction::query();
        $query->where('COAID',4);
        return DataTables::eloquent($query)
            ->addIndexColumn()
            ->rawColumns(['status'])
            ->toJson();
    }
    public function expenseAdd(){
        $expenseItems = ExpenseItem::get();
        return view('account::expense.add',compact('expenseItems'));
    }

    public function expenseAddPost(Request $request){
//        return($request->all());
        $request->validate([
            'payment_type' => ['required'],
            'expense_item' => ['required'],
            'amount' => ['required'],
        ]);

//        return($request->all());
        $accTransaction = new AccTransaction();
        $accTransaction->vid  = 0;
        $accTransaction->fyear = financial_year();
        $accTransaction->VDate = date('Y-m-d',strtotime($request->date));
        $accTransaction->COAID = 1020101;
        $accTransaction->Narration = $request->expense_item.' Expense';
        $accTransaction->Credit = $request->amount;
        $accTransaction->RevCodde = 0;
        $accTransaction->save();

        $accTransaction = new AccTransaction();
        $accTransaction->vid  = 0;
        $accTransaction->fyear = financial_year();
        $accTransaction->VDate = date('Y-m-d',strtotime($request->date));
        $accTransaction->COAID = 4;
        $accTransaction->Narration = $request->expense_item.' Expense';
        $accTransaction->Debit = $request->amount;
        $accTransaction->RevCodde = 0;
        $accTransaction->save();

        return redirect()->route('account.expense_all')->with('message','Information added');
    }
}
