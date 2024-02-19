<?php

namespace Modules\Client\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Modules\Client\Entities\Client;
use Modules\Client\Entities\ClientCategory;
use Yajra\DataTables\Facades\DataTables;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('client::client.index');
    }

    public function datatable()
    {
        $query = Client::query();
        return DataTables::eloquent($query)
            ->addIndexColumn()
            ->addColumn('action', function (Client $client) {
                return '<a href="' . route('client.edit', ['client' => $client->id]) . '" class="btn-edit"><i style="color:#01a9ac;font-size: 17px;" class="feather icon-edit"></i></a>';
            })
            ->addColumn('status', function (Client $client) {
                if ($client->status == 1)
                    return '<span class="badge badge-success">Active</span>';
                else
                    return '<span class="badge badge-danger">Inactive</span>';
            })
            ->rawColumns(['action', 'status'])
            ->toJson();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $client_categories = ClientCategory::all();
        return view('client::client.create', compact('client_categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'client_category' => 'required|numeric',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('clients')],
            'phone' => 'required|string|digits:11',
            'address' => 'nullable|string|max:255',
            //            'opening_balance' => 'required|numeric',
            'status' => 'required',
        ]);

        //  dd($request->all());
        // $headcode = AccCoa::where('HeadLevel', 4)->where('HeadCode', 'like', '113100%')->max('HeadCode');
        // if ($headcode != NULL) {
        //     $headcode += 1;
        // } else {
        //     $headcode = "113100000001";
        // }
        try {
            DB::beginTransaction();
            $customer = new Client();
            $customer->name = $request->name;
            $customer->email = $request->email;
            $customer->phone = $request->phone;
            $customer->client_category_id = $request->client_category;
            $customer->address = $request->address;
            $customer->status = $request->status;
            $customer->created_by = Auth::user()->id;
            $customer->save();

            // $acc_coa = new AccCoa();
            // $acc_coa->HeadCode = $headcode;
            // $acc_coa->HeadName = $request->name . '-' . $customer->id;
            // $acc_coa->PHeadName = 'Customers';
            // $acc_coa->HeadLevel = 4;
            // $acc_coa->IsActive = 1;
            // $acc_coa->IsTransaction = 1;
            // $acc_coa->IsGL = 0;
            // $acc_coa->HeadType = 'A';
            // $acc_coa->IsBudget = 0;
            // $acc_coa->customer_id = $customer->id;
            // $acc_coa->IsDepreciation = 0;
            // $acc_coa->DepreciationRate = 0;
            // $acc_coa->CreateBy = Auth::user()->id;
            // $acc_coa->UpdateBy = 0;
            // //$acc_coa->save();

            // $acc_subcode = new AccSubcode();
            // $acc_subcode->subTypeId = 3;
            // $acc_subcode->name = $request->name;
            // $acc_subcode->referenceNo = $customer->id;
            // $acc_subcode->created_by = Auth::user()->id;
            // $acc_subcode->updated_by = 0;
            // $acc_subcode->status = 1;
            // $acc_subcode->save();

            DB::commit();
            return redirect()->route('client.index')->with('message', 'Information added');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', $e)->withInput();
        }
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('client::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $client_categories = ClientCategory::all();
        $client = Client::findOrFail($id);
        return view('client::client.edit', compact('client_categories', 'client'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): RedirectResponse
    {

        $request->validate([
            'name' => 'required|string|max:255',
            'client_category' => 'required|numeric',
            'email' => 'required|email|unique:clients,email,' . $id,
            'phone' => 'required|string|digits:11',
            'address' => 'nullable|string|max:255',
            //            'opening_balance' => 'required|numeric',
            'status' => 'required',
        ]);

        try {
            //dd($request->all());
            DB::beginTransaction();
            $customer =  Client::find($id);
            $customer->name = $request->name;
            $customer->email = $request->email;
            $customer->phone = $request->phone;
            $customer->client_category_id = $request->client_category;
            $customer->address = $request->address;
            $customer->status = $request->status;
            $customer->updated_by = Auth::user()->id;
            $customer->update();

            DB::commit();
            return redirect()->route('client.index')->with('message', 'Information updated');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
    }

    public function addAjaxPost(Request $request)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => ['nullable', 'string', 'email', 'max:255', Rule::unique('customers')],
            'phone' => 'required|string|digits:11',
            'address' => 'nullable|string|max:255',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
        }

        try {
            DB::beginTransaction();
            $customer = new Client();
            $customer->name = $request->name;
            $customer->email = $request->email;
            $customer->phone = $request->phone;
            $customer->address = $request->address;
            $customer->status = 1;
            $customer->created_by = Auth::user()->id;
            $customer->save();

            // $acc_subcode = new AccSubcode();
            // $acc_subcode->subTypeId = 4;
            // $acc_subcode->name = $request->name;
            // $acc_subcode->referenceNo = $customer->id;
            // $acc_subcode->created_by = Auth::user()->id;
            // $acc_subcode->updated_by = 0;
            // $acc_subcode->status = 1;
            // $acc_subcode->save();

            DB::commit();
            return response()->json(['success' => true, 'message' => 'added', 'customer' => $customer]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e]);
        }
    }
}
