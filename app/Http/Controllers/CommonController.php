<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\Account\Entities\AccCoa;
use Modules\Account\Entities\AccountHeadSubType;
use Modules\Account\Entities\AccSubcode;
use Modules\Account\Entities\Cash;
use Modules\Customer\Entities\Customer;
use Modules\Inventory\Entities\Inventory;
use Modules\Product\Entities\Product;
use Modules\Product\Entities\SupplierProduct;
use Modules\Purchase\Entities\ProductPurchaseDetail;
use Modules\Supplier\Entities\Supplier;
use Modules\Account\Entities\AccountHeadType;
use Modules\Account\Entities\TransactionLog;
use Modules\Client\Entities\Client;

class CommonController extends Controller
{
    public function cash()
    {
        $cash = Cash::first();
        return view('cash.all', compact('cash'));
    }
    public function addCash()
    {
        $cash = Cash::first();
        return view('cash.add', compact('cash'));
    }
    public function addCashPost(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();
        try {
            $cash = Cash::first();

            if ($cash) {
                $cash->amount =  $cash->amount + $request->amount;
            } else {
                $cash = new Cash();
                $cash->amount = $request->amount;
            }
            if ($cash->save()) {
                $transaction_log = new TransactionLog();
                $transaction_log->date = now();
                $transaction_log->particular = 'Cash Add';
                $transaction_log->transaction_type = 3;
                $transaction_log->transaction_method = 1;
                $transaction_log->amount = $request->amount;
                $transaction_log->created_by = auth()->id();
                $transaction_log->save();
            }
            DB::commit();
            return redirect()->route('cash')->with('success', 'Cash Added.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function productsJson(Request $request)
    {
        if (!$request->searchTerm) {
            $products = Product::with('unit')->where('status', 1)
                ->orderBy('product_name')
                ->limit(20)
                ->get();
        } else {
            $products = Product::with('unit')->where('product_name', 'like', '%' . $request->searchTerm . '%')
                ->orderBy('product_name')
                ->limit(20)
                ->get();
        }
        $data = array();
        foreach ($products as $product) {
            $supplierProduct = SupplierProduct::where('product_id', $product->id)->first();
            $data[] = [
                'id' => $product->id,
                'text' => $product->product_name ?? '',
                'unit' => $product->unit->name ?? '',
                'vat' => $product->product_vat ?? '',
                'rate' => $supplierProduct->supplier_price ?? '',
            ];
        }
        echo json_encode($data);
    }
    public function saleProductsJson(Request $request)
    {
        if (!$request->searchTerm) {
            $products = Product::with('unit')->where('status', 1)
                ->orderBy('product_name')
                ->limit(20)
                ->get();
        } else {
            $products = Product::with('unit')->where('product_name', 'like', '%' . $request->searchTerm . '%')
                ->orderBy('name')
                ->limit(20)
                ->get();
        }
        $data = array();
        foreach ($products as $product) {
            $supplierProduct = SupplierProduct::where('product_id', $product->id)->first();
            $data[] = [
                'id' => $product->id,
                'text' => $product->product_name ?? '',
                'unit' => $product->unit->name ?? '',
                'vat' => $product->product_vat ?? '',
                'price' => $product->price ?? '',
            ];
        }
        echo json_encode($data);
    }
    public function batchProductsJson(Request $request)
    {
        if (!$request->searchTerm) {
            $batchProducts = ProductPurchaseDetail::with('product')->where('product_id', $request->productID)->selectRaw('product_id, batch_id, SUM(quantity) as totalQuantity')
                ->groupBy('product_id', 'batch_id')->orderBy('product_id')->limit(20)->get();

            $productBatches = Inventory::with('product')->where('product_id', $request->productID)->orderBy('batch_no')->limit(20)->get();
        } else {
            $batchProducts = ProductPurchaseDetail::with('product')->where('product.product_name', 'like', '%' . $request->searchTerm . '%')->selectRaw('product_id, batch_id, SUM(quantity) as totalQuantity')
                ->groupBy('product_id', 'batch_id')->orderBy('product_id')->limit(20)->get();
            $productBatches = Inventory::with('product')->where('product_id', $request->productID)->where('batch_no', 'like', '%' . $request->searchTerm . '%')->orderBy('batch_no')->limit(20)->get();
        }
        $data = array();
        foreach ($productBatches as $inventory) {
            $data[] = [
                'id' => $inventory->id,
                'text' => $inventory->batch_no ?? '',
                'stock' => $inventory->quantity ?? '',
                'unit' => $inventory->product->unit->name ?? '',
                'price' => $inventory->selling_rate ?? '',
                'vat' => $inventory->product->product_vat ?? '',
            ];
        }
        echo json_encode($data);
    }
    public function productInfoJson(Request $request)
    {
        $batchProduct = ProductPurchaseDetail::with('product')->where('product_id', $request->productID)->selectRaw('product_id, batch_id, SUM(quantity) as totalQuantity')->groupBy('product_id', 'batch_id')->get();
        $product = Product::where('id', $request->productID)->first();

        $productBatch = Inventory::with('product')->where('product_id', $request->productID)->get();
        return response()->json([
            'batchProduct' => $batchProduct,
            'product' => $product,
            'productBatch' => $productBatch
        ]);
    }
    public function accountCodeJson(Request $request)
    {
        if (!$request->searchTerm) {
            $transactionHeads = AccCoa::where('isBankNature', 0)->where('isCashNature', 0)
                ->where('HeadLevel', 4)->where('IsActive', 1)
                ->orderBy('HeadName')
                ->limit(20)
                ->get();
        } else {
            $transactionHeads = AccCoa::where('isBankNature', 0)->where('isCashNature', 0)
                ->where('HeadLevel', 4)->where('IsActive', 1)
                ->where('HeadName', 'like', '%' . $request->searchTerm . '%')
                ->orderBy('HeadName')
                ->limit(20)
                ->get();
        }
        $data = array();
        foreach ($transactionHeads as $transactionHead) {
            $data[] = [
                'id' => $transactionHead->HeadCode,
                'text' => $transactionHead->HeadName,
            ];
        }
        echo json_encode($data);
    }
    public function accountOpeningCodeJson(Request $request)
    {
        if (!$request->searchTerm) {
            $transactionHeads = AccCoa::where('HeadLevel', 4)->where('IsActive', 1)
                ->orderBy('HeadName')
                ->limit(20)
                ->get();
        } else {
            $transactionHeads = AccCoa::where('HeadLevel', 4)->where('IsActive', 1)
                ->where('HeadName', 'like', '%' . $request->searchTerm . '%')
                ->orderBy('HeadName')
                ->limit(20)
                ->get();
        }
        $data = array();
        foreach ($transactionHeads as $transactionHead) {
            $data[] = [
                'id' => $transactionHead->HeadCode,
                'text' => $transactionHead->HeadName,
            ];
        }
        echo json_encode($data);
    }
    public function accountSubtypeJson(Request $request)
    {
        $status = false;
        $acc_sutypes = [];
        $subtype = 1;
        $acc_coa = AccCoa::where('HeadCode', $request->acc_code)->first();
        if ($acc_coa->isSubType == 1) {
            $status = true;
            $subtype = $acc_coa->subType;
            $acc_sutypes = AccSubcode::where('subTypeId', $acc_coa->subType)->get();
        }
        return response()->json([
            'status' => $status,
            'acc_sutypes' => $acc_sutypes,
            'subtype' => $subtype
        ]);
    }
    public function customersJson(Request $request)
    {
        if (!$request->searchTerm) {
            $customers = Customer::where('status', 1)
                ->orderBy('name')
                ->limit(20)
                ->get();
        } else {
            $customers = Customer::where('status', 1)
                ->where('name', 'like', '%' . $request->searchTerm . '%')
                ->orderBy('name')
                ->limit(20)
                ->get();
        }
        $data = array();
        foreach ($customers as $customer) {
            $data[] = [
                'id' => $customer->id,
                'text' => $customer->name,
            ];
        }
        echo json_encode($data);
    }
    public function suppliersJson(Request $request)
    {
        if (!$request->searchTerm) {
            $suppliers = Supplier::where('status', 1)
                ->orderBy('name')
                ->limit(20)
                ->get();
        } else {
            $suppliers = Supplier::where('status', 1)
                ->where('name', 'like', '%' . $request->searchTerm . '%')
                ->orderBy('name')
                ->limit(20)
                ->get();
        }
        $data = array();
        foreach ($suppliers as $supplier) {
            $data[] = [
                'id' => $supplier->id,
                'text' => $supplier->name,
            ];
        }
        echo json_encode($data);
    }

    public function getAccountHeadType(Request $request)
    {
        $types = AccountHeadType::where('transaction_type', $request->type)
            ->where('status', 1)
            ->orderBy('name')
            ->get()->toArray();

        return response()->json($types);
    }
    public function getAccountHeadSubType(Request $request)
    {
        $subTypes = AccountHeadSubType::where('account_head_type_id', $request->typeId)
            ->where('status', 1)
            ->orderBy('name')
            ->get()->toArray();

        return response()->json($subTypes);
    }

    public function clientJson(Request $request)
    {
        if (!$request->searchTerm) {
            $clients = Client::orderBy('name', 'asc')->limit(10)->get();
        } else {
            $clients = Client::where('name', 'like', '%' . $request->searchTerm . '%')
                ->orderBy('name', 'asc')
                ->limit(50)->get();
        }

        $data = array();

        foreach ($clients as $client) {
            $data[] = [
                'id' => $client->id,
                'text' => $client->name . '|' . $client->address,
            ];
        }

        echo json_encode($data);
    }
}
