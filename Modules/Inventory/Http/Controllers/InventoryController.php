<?php

namespace Modules\Inventory\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Inventory\Entities\InventoryOrder;
use Yajra\DataTables\Facades\DataTables;

class InventoryController extends Controller
{

    public function inventoryReceipt()
    {
        return view('inventory::inventory.receipt.all');
    }

    public function inventoryReceiptDatatable()
    {
        $query = InventoryOrder::with('supplier');

        return DataTables::eloquent($query)
            ->addColumn('supplier', function (InventoryOrder $inventoryOrder) {
                return $inventoryOrder->supplier->name ?? '';
            })
            ->addColumn('action', function (InventoryOrder $inventoryOrder) {

                //                $btn   = '<a href="' . route('purchase_journal_voucher.details', ['order' => $inventoryOrder->id]) . '" class="btn btn-dark btn-sm">JV</i></a> ';
                $btn  = '<a href="' . route('inventory.inventory_receipt_details', ['inventoryOrder' => $inventoryOrder->id]) . '" class="btn btn-primary btn-sm">Details</a> ';
//                $btn  .= '<a class="btn btn-info btn-sm btn-pay" role="button" data-id="'.$inventoryOrder->id.'" data-order="'.$inventoryOrder->order_no.'" data-due="'.$inventoryOrder->due.'">Pay</a> ';
                return $btn;
            })
            ->editColumn('purchase_date', function (InventoryOrder $inventoryOrder) {
                return $inventoryOrder->purchase_date;
            })

            ->addColumn('quantity', function (InventoryOrder $inventoryOrder) {
                return $inventoryOrder->quantity ?? '';
            })
            ->editColumn('grand_total_amount', function (InventoryOrder $inventoryOrder) {
                return '৳' . number_format($inventoryOrder->grand_total_amount, 2);
            })
            ->editColumn('paid_amount', function (InventoryOrder $inventoryOrder) {
                return '৳' . number_format($inventoryOrder->paid_amount, 2);
            })
            ->editColumn('due_amount', function (InventoryOrder $inventoryOrder) {
                return '৳' . number_format($inventoryOrder->due_amount, 2);
            })
            ->orderColumn('purchase_date', function ($query, $inventoryOrder) {
                $query->orderBy('purchase_date', $inventoryOrder)->orderBy('created_at', 'desc');
            })
            ->rawColumns(['action'])
            ->toJson();
    }
    public function inventoryReceiptDetails(InventoryOrder $inventoryOrder)
    {

        return view('inventory::inventory.receipt.details', compact('inventoryOrder'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('inventory::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        //
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('inventory::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('inventory::edit');
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
