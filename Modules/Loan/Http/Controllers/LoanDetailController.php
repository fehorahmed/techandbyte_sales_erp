<?php

namespace Modules\Loan\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Modules\Loan\Entities\Loan;
use Modules\Loan\Entities\LoanDetail;
use Yajra\DataTables\Facades\DataTables;

class LoanDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Loan $loan)
    {
        return view('loan::load_detail.index', compact('loan'));
    }

    public function detailsDatatable()
    {
        $query = LoanDetail::with('creator');
        return DataTables::eloquent($query)
            ->addIndexColumn()
            ->addColumn('action', function (LoanDetail $promotion) {
                // return '<a href="' . route('promotion.edit', ['detail' => $promotion->id]) . '" class="btn-edit"><i style="color:#01a9ac;font-size: 17px;" class="feather icon-edit"></i></a>';
                return '<a href="" class="btn-edit"><i style="color:#01a9ac;font-size: 17px;" class="feather icon-edit"></i></a>';
            })
            ->rawColumns(['action'])
            ->toJson();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('loan::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function paymentStore(Request $request)
    {
        $rules = [
            'loan_id' => 'required|numeric',
            'amount' => 'required|numeric',
            'date' => 'required|date',
        ];
        $validation = Validator::make($request->all(), $rules);
        if ($validation->fails()) {
            return response([
                'status' => false,
                'message' => $validation->errors()->first(),
            ]);
        }
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('loan::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('loan::edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): RedirectResponse
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
    }
}
