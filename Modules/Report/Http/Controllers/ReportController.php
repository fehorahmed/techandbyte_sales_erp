<?php

namespace Modules\Report\Http\Controllers;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Modules\Client\Entities\Client;
use Modules\Account\Entities\TransactionLog;
use Modules\Customer\Entities\Customer;
use Modules\Inventory\Entities\Inventory;
use Modules\Inventory\Entities\InventoryOrder;
use Modules\Product\Entities\Product;
use Modules\Sale\Entities\Invoice;
use Modules\Sale\Entities\SalePayment;
use Modules\Supplier\Entities\Supplier;
use Modules\Warehouse\Entities\Warehouse;
use Yajra\DataTables\Facades\DataTables;

class ReportController extends Controller
{
    public function purchase(Request $request)
    {
        $suppliers = Supplier::orderBy('name')->get();
        $productitems = [];
        $inventories = InventoryOrder::get();
        $appends = [];
        $query = InventoryOrder::query();

        if ($request->start && $request->end) {

            $query->whereBetween('purchase_date', [$request->start, $request->end]);
            $appends['start'] = $request->start;
            $appends['end'] = $request->end;
        } else {
            $query->whereBetween('purchase_date', [date('Y-m-d'), date('Y-m-d')]);
            $appends['start'] = date('Y-m-d');
            $appends['end'] = date('Y-m-d');
        }

        if ($request->supplier && $request->supplier != '') {
            $query->where('supplier_id', $request->supplier);
            $appends['supplier'] = $request->supplier;
        }

        if ($request->purchaseId && $request->purchaseId != '') {
            $query->where('order_no', $request->purchaseId);
            $appends['purchaseId'] = $request->purchaseId;
        }

        if ($request->product && $request->product != '') {
            $query->whereHas('products', function ($q) use ($request) {
                $q->where('purchase_order_products.product_id', '=', $request->product);
            });

            $appends['product'] = $request->product;
        }

        $query->orderBy('purchase_date', 'desc')->orderBy('created_at', 'desc');
        $query->with('products');
        $orderTotalAmount = 0;
        $orderPaidAmount = 0;
        $orderDueAmount = 0;
        $totalQuantity = 0;

        $totalOrders = $query->get();
        foreach ($totalOrders as $totalOrder) {
            $orderTotalAmount += $totalOrder->grand_total_amount;
            $orderPaidAmount += $totalOrder->paid_amount;
            $orderDueAmount += $totalOrder->due_amount;
            $totalQuantity += $totalOrder->sum_quantity();
        }
        $orders = $query->paginate(10);


        foreach ($orders as $order) {
            $orderProducts = [];

            foreach ($order->products as $orderProduct)

                $orderProducts[] = $orderProduct->name;

            $order->product_name = implode(', ', $orderProducts);
        }

        return view('report::report.purchase', compact(
            'orders',
            'suppliers',
            'appends',
            'productitems',
            'orderTotalAmount',
            'orderPaidAmount',
            'orderDueAmount',
            'totalQuantity'
        ));
    }
    public function sale(Request $request)
    {

        $customers = Client::orderBy('name')->where('status', 1)->get();
        $suppliers = Supplier::orderBy('name')->get();
        $products = Product::orderBy('product_name')->get();
        $appends = [];

        if ($request->report_type == 2) {
            $query = Invoice::whereNotIn('paid_amount', [0]);
        } elseif ($request->report_type == 1) {
            $query = Invoice::whereNotIn('due_amount', [0]);
        } else {
            $query = Invoice::query();
        }

        if ($request->start && $request->end) {
            $query->whereBetween('date', [$request->start, $request->end]);
            $appends['start'] = $request->start;
            $appends['end'] = $request->end;
        } else {
            $query->whereBetween('date', [date('Y-m-d'), date('Y-m-d')]);
            $appends['start'] = date('Y-m-d');
            $appends['end'] = date('Y-m-d');
        }

        if ($request->customer && $request->customer != '') {
            $query->where('customer_id', $request->customer);
            $appends['customer'] = $request->customer;
        }

        if ($request->order_no && $request->order_no != '') {
            $query->where('order_no', $request->order_no);
            $appends['order_no'] = $request->order_no;
        }

        if ($request->product && $request->product != '') {
            $query->whereHas('products', function ($q) use ($request) {
                $q->where('invoice_details.product_id', '=', $request->product);
            });

            $appends['product_item'] = $request->product_item;
        }

        $query->orderBy('date', 'desc')->orderBy('created_at', 'desc');
        $query->with('products');
        $orderTotalAmount = 0;
        $orderPaidAmount = 0;
        $orderDueAmount = 0;
        $totalQuantity = 0;

        $totalOrders = $query->get();
        foreach ($totalOrders as $totalOrder) {
            $orderTotalAmount += $totalOrder->total;
            $orderPaidAmount += $totalOrder->paid;
            $orderDueAmount += $totalOrder->due;
            $totalQuantity += $totalOrder->sum_quantity();
        }

        $orders = $query->paginate(10);

        foreach ($orders as $order) {
            $orderProducts = [];

            foreach ($order->products as $orderProduct)
                $orderProducts[] = $orderProduct->product_name ?? '';

            $order->product_name = implode(', ', $orderProducts);
        }

        return view('report::report.sale', compact(
            'customers',
            'products',
            'appends',
            'orders',
            'suppliers',
            'orderTotalAmount',
            'orderPaidAmount',
            'orderDueAmount',
            'totalQuantity'
        ));
    }
    public function partyLedger(Request $request)
    {
        //        $party_discount_amount = 0;

        $clients = Client::where('status', 1)->orderBy('name')
            ->get();
        $clientName = '';
        $clientHistories = [];

        if (
            $request->client && $request->client != ''
            && $request->start && $request->start != ''
            && $request->end && $request->end != ''
        ) {

            $startDateArray = [];
            $endDateArray = [];

            $clientName = $openingDue = Client::where('id', $request->client)
                ->first();

            $firstOrder = Invoice::where('customer_id', $request->client)
                ->orderBy('date', 'asc')
                ->first();

            $lastOrder = Invoice::where('customer_id', $request->client)
                ->orderBy('date', 'desc')
                ->first();

            $firstPayment = SalePayment::where('customer_id', $request->client)
                ->orderBy('date', 'asc')
                ->first();

            $lastPayment = SalePayment::where('customer_id', $request->client)
                ->orderBy('date', 'desc')
                ->first();

            $firstReturn = Invoice::where('customer_id', $request->client)
                ->orderBy('date', 'asc')
                ->first();

            $lastReturn = Invoice::where('customer_id', $request->client)
                ->orderBy('date', 'desc')
                ->first();

            if ($firstOrder != '') {
                array_push($startDateArray, Carbon::parse($openingDue->created_at)->format('d-m-Y'));

                array_push($endDateArray, Carbon::parse($openingDue->created_at)->format('d-m-Y'));
            }

            if ($firstOrder)
                array_push($startDateArray, Carbon::parse($firstOrder->date)->format('d-m-Y'));

            if ($firstPayment)
                array_push($startDateArray, Carbon::parse($firstPayment->date)->format('d-m-Y'));

            if ($firstReturn)
                array_push($startDateArray, Carbon::parse($firstReturn->date)->format('d-m-Y'));

            if ($lastOrder)
                array_push($endDateArray, Carbon::parse($lastOrder->date)->format('d-m-Y'));
            if ($lastPayment)
                array_push($endDateArray, Carbon::parse($lastPayment->date)->format('d-m-Y'));
            if ($lastReturn)
                array_push($endDateArray, Carbon::parse($lastReturn->date)->format('d-m-Y'));


            if (count($startDateArray) > 0 && count($endDateArray) > 0) {


                array_multisort(array_map('strtotime', $startDateArray), $startDateArray);
                array_multisort(array_map('strtotime', $endDateArray), $endDateArray);

                $startMin = $startDateArray[0];
                $endMax = $endDateArray[array_key_last($endDateArray)];


                $startDateObj = new Carbon($startMin);
                $endDateObj = new Carbon($endMax);


                $totalDurationLengths = $startDateObj->diffInDays($endDateObj) + 1;
                //dd($totalDurationLengths);

                $clientHistories = [];
                array_push($clientHistories, [
                    'date' => $openingDue->created_at->format('d-m-Y') ?? '',
                    'particular' => 'Opening Balance',
                    'quantity' => 0,
                    'invoice' => 0,
                    'discount' => 0,
                    'transport_cost' => 0,
                    'return' => 0,
                    'sale_adjustment' => 0,
                    'party_discount' => 0,
                    'payment' => 0,
                    'due_balance' => $openingDue->opening_due,
                ]);

                $orderPayment = [];

                for ($i = 0; $i < $totalDurationLengths; $i++) {
                    $date = Carbon::createFromFormat('d-m-Y', $startMin);
                    $searchDate = $date->addDays($i)->format('Y-m-d');

                    $orders = Invoice::where('customer_id', $request->client)
                        ->whereBetween('date', [$request->start, $request->end])
                        ->where('date', $searchDate)->get();

                    foreach ($orders as $order) {
                        if ($order->total <= 0 || $order->return_amount > 0 || $order->sale_adjustment > 0 || $order->discount > 0) {
                            array_push($clientHistories, [
                                'date' => Carbon::parse($order->date)->format('d-m-Y') ?? '',
                                'particular' => 'Invoice Total' . ' ' . $order->customer->name . ' ' . $order->invoice ?? '',
                                'quantity' => $order->sum_quantity() ?? 0,
                                'invoice' => $order->total_amount,
                                'discount' => $order->total_discount ?? '0',
                                'transport_cost' => $order->shipping_cost ?? '0',
                                'return' => $order->return_amount ?? '0',
                                'sale_adjustment' => $order->sale_adjustment ?? '0',
                                'party_discount' => 0,
                                'payment' => 0,
                                'due_balance' => $order->total_amount - $order->total_discount - $order->sale_adjustment,
                            ]);


                            $salePayments = SalePayment::where('invoice_id', $order->id)->get();
                            foreach ($salePayments as $salePayment) {
                                //                                if ($salePayment->transactionLog->payment_cheak_status != 3){
                                array_push($clientHistories, [
                                    'date' => Carbon::parse($order->date)->format('d-m-Y') ?? '',
                                    'particular' => 'Payment From' . ' ' . $order->customer->name . ' ' . $order->invoice ?? '',
                                    'quantity' => 0,
                                    'invoice' => 0,
                                    'discount' => 0,
                                    'transport_cost' => 0,
                                    'return' => 0,
                                    'sale_adjustment' => 0,
                                    'party_discount' => 0,
                                    'payment' => $salePayment->amount,
                                    'due_balance' => 0,
                                ]);
                                //                                }elseif ($salePayment->transactionLog->payment_cheak_status == 3){
                                //                                    array_push($clientHistories,[
                                //                                        'date'=>$order->date->format('d-m-Y') ?? '',
                                //                                        'particular' => $salePayment->transactionLog->particular.' '.$order->order_no??'',
                                //                                        'quantity'=>0,
                                //                                        'invoice'=>0,
                                //                                        'return'=>0,
                                //                                        'payment'=> $salePayment->amount,
                                //                                        'due_balance'=>0,
                                //                                    ]);
                                //                                }
                            }

                            //                            foreach ($salePayments as $payment){
                            //                                if ($payment->transaction_method == 4) {
                            //                                    array_push($clientHistories,[
                            //                                        'date'=>$payment->date->format('d-m-Y') ?? '',
                            //                                        'particular'=>$payment->customer->name.'-'.'Balance Adjustment-'.$payment->id,
                            //                                        'quantity'=>0,
                            //                                        'invoice'=> 0,
                            //                                        'return'=> 0,
                            //                                        'payment'=>$payment->amount,
                            //                                        'due_balance'=>0,
                            //                                    ]);
                            //                                }
                            //                            }
                            //
                            //                            foreach ($salePayments as $payment) {
                            //                                if($payment->transaction_method == 5) {
                            //                                    array_push($clientHistories, [
                            //                                        'date' => $payment->date->format('d-m-Y') ?? '',
                            //                                        'particular' => $payment->customer->name . '-' . 'Return Adjustment Amount-' . $payment->id,
                            //                                        'quantity' => 0,
                            //                                        'invoice' => 0,
                            //                                        'return' => $payment->amount,
                            //                                        'payment' => 0,
                            //                                        'due_balance' => 0,
                            //                                    ]);
                            //                                }
                            //                            }

                        } else {

                            array_push($clientHistories, [
                                'date' => Carbon::parse($order->date)->format('d-m-Y') ?? '',
                                'particular' => 'Invoice Total' . ' ' . $order->customer->name . ' ' . $order->invoice ?? '',
                                'quantity' => $order->sum_quantity() ?? 0,
                                'invoice' => $order->total_amount,
                                'discount' => $order->total_discount ?? '0',
                                'transport_cost' => $order->shipping_cost ?? '0',
                                'return' => $order->return_amount ?? '0',
                                'sale_adjustment' => $order->sale_adjustment ?? '0',
                                'party_discount' => 0,
                                'payment' => 0,
                                'due_balance' => $order->total_amount - $order->total_discount,

                            ]);


                            $salePayments = SalePayment::with('transactionLog')->where('sales_order_id', $order->id)->where('status', 2)->get();

                            //dd();

                            foreach ($salePayments as $salePayment) {
                                //                                if ($salePayment->transactionLog->payment_cheak_status != 3){
                                array_push($clientHistories, [
                                    'date' => Carbon::parse($order->date)->format('d-m-Y') ?? '',
                                    'particular' => 'Payment From' . ' ' . $order->customer->name . ' ' . $order->invoice ?? '',
                                    'quantity' => 0,
                                    'invoice' => 0,
                                    'discount' => 0,
                                    'transport_cost' => 0,
                                    'return' => 0,
                                    'sale_adjustment' => 0,
                                    'party_discount' => 0,
                                    'payment' => $salePayment->amount,
                                    'due_balance' => 0,
                                ]);
                                //                                }elseif ($salePayment->transactionLog->payment_cheak_status == 3){
                                //                                    array_push($clientHistories,[
                                //                                        'date'=>$order->date->format('d-m-Y') ?? '',
                                //                                        'particular' => $salePayment->transactionLog->particular.' '.$order->order_no??'',
                                //                                        'quantity'=>0,
                                //                                        'invoice'=>0,
                                //                                        'return'=>0,
                                //                                        'payment'=> $salePayment->amount,
                                //                                        'due_balance'=>0,
                                //                                    ]);
                                //                                }

                            }

                            //                            foreach ($salePayments as $payment){
                            //                                if ($payment->transaction_method == 4) {
                            //                                    array_push($clientHistories,[
                            //                                        'date'=>$payment->date->format('d-m-Y') ?? '',
                            //                                        'particular'=>$payment->customer->name.'-'.'Balance Adjustment-'.$payment->id,
                            //                                        'quantity'=>0,
                            //                                        'invoice'=> 0,
                            //                                        'return'=> 0,
                            //                                        'payment'=>$payment->amount,
                            //                                        'due_balance'=>0,
                            //                                    ]);
                            //                                }
                            //                            }
                            //                            foreach ($salePayments as $payment) {
                            //
                            //                                if($payment->transaction_method == 5) {
                            //                                    array_push($clientHistories, [
                            //                                        'date' => $payment->date->format('d-m-Y') ?? '',
                            //                                        'particular' => $payment->customer->name . '-' . 'Return Adjustment Amount-' . $payment->id,
                            //                                        'quantity' => 0,
                            //                                        'invoice' => 0,
                            //                                        'return' => $payment->amount,
                            //                                        'payment' => 0,
                            //                                        'due_balance' => 0,
                            //                                    ]);
                            //                                }
                            //                            }

                        }
                    }


                    $payments = SalePayment::where('customer_id', $request->client)
                        ->whereBetween('date', [$request->start, $request->end])
                        ->where('date', $searchDate)
                        ->where('invoice_id', '=', null)
                        ->get();

                    foreach ($payments as $payment) {
                        //                        if ($payment->transactionLog->payment_cheak_status != 3){
                        if ($payment->transaction_method != 4 && $payment->transaction_method != 5) {
                            array_push($clientHistories, [
                                'date' => Carbon::parse($payment->date)->format('d-m-Y') ?? '',
                                // 'particular' => 'Receipt From'.' '.$payment->customer->name.' '.'Without Invoice',
                                'particular' => 'Receipt From' . ' ' . $payment->customer->name . ' ' . $payment->id ?? '',
                                'quantity' => 0,
                                'invoice' => 0,
                                'discount' => 0,
                                'transport_cost' => 0,
                                'return' => 0,
                                'sale_adjustment' => 0,
                                'party_discount' => 0,
                                'payment' => $payment->amount,
                                'due_balance' => 0,
                            ]);
                        }
                        //                        }elseif ($payment->transactionLog->payment_cheak_status == 3){
                        //                            if ($payment->transaction_method != 4 && $payment->transaction_method != 5){
                        //                                array_push($clientHistories, [
                        //                                    'date' => $payment->date->format('d-m-Y') ?? '',
                        //                                    // 'particular' => 'Receipt From'.' '.$payment->customer->name.' '.'Without Invoice',
                        //                                    'particular' => $payment->transactionLog->particular .' ' . $order->order_no ?? '',
                        //                                    'quantity' => 0,
                        //                                    'invoice' => 0,
                        //                                    'return' => 0,
                        //                                    'payment' => $payment->amount,
                        //                                    'due_balance' => 0,
                        //                                ]);
                        //                            }
                        //                        }


                    }

                    foreach ($payments as $payment) {
                        if ($payment->transaction_method == 4) {
                            array_push($clientHistories, [
                                'date' => Carbon::parse($payment->date)->format('d-m-Y') ?? '',
                                'particular' => $payment->customer->name . '-' . 'Balance Adjustment-' . $payment->id,
                                'quantity' => 0,
                                'invoice' => 0,
                                'discount' => 0,
                                'transport_cost' => 0,
                                'return' => 0,
                                'sale_adjustment' => 0,
                                'party_discount' => 0,
                                'payment' => $payment->amount,
                                'due_balance' => 0,
                            ]);
                        }
                    }
                    foreach ($payments as $payment) {

                        if ($payment->transaction_method == 5) {
                            array_push($clientHistories, [
                                'date' => Carbon::parse($payment->date)->format('d-m-Y') ?? '',
                                'particular' => $payment->customer->name . '-' . 'Return Adjustment Amount-' . $payment->id,
                                'quantity' => 0,
                                'invoice' => 0,
                                'discount' => 0,
                                'transport_cost' => 0,
                                'return' => $payment->amount,
                                'sale_adjustment' => 0,
                                'party_discount' => 0,
                                'payment' => 0,
                                'due_balance' => 0,
                            ]);
                        }
                    }
                }
            }
        } elseif ($request->client && $request->client != '') {

            //            $party_discount_amount = PartyLess::where('customer_id', $request->client)->sum('amount');

            $startDateArray = [];
            $endDateArray = [];

            $clientName = $openingDue = Client::where('id', $request->client)
                ->first();

            $firstOrder = Invoice::where('customer_id', $request->client)
                ->orderBy('date', 'asc')
                ->first();

            $lastOrder = Invoice::where('customer_id', $request->client)
                ->orderBy('date', 'desc')
                ->first();

            $firstPayment = SalePayment::where('customer_id', $request->client)
                ->orderBy('date', 'asc')
                ->first();

            $lastPayment = SalePayment::where('customer_id', $request->client)
                ->orderBy('date', 'desc')
                ->first();

            $firstReturn = Invoice::where('customer_id', $request->client)
                ->orderBy('date', 'asc')
                ->first();

            $lastReturn = Invoice::where('customer_id', $request->client)
                ->orderBy('date', 'desc')
                ->first();

            if ($firstOrder != '') {
                array_push($startDateArray, $openingDue->created_at->format('d-m-Y'));

                array_push($endDateArray, $openingDue->created_at->format('d-m-Y'));
            }

            if ($firstOrder)
                array_push($startDateArray, $firstOrder->date->format('d-m-Y'));

            if ($firstPayment)
                array_push($startDateArray, $firstPayment->date->format('d-m-Y'));

            if ($firstReturn)
                array_push($startDateArray, $firstReturn->date->format('d-m-Y'));

            if ($lastOrder)
                array_push($endDateArray, $lastOrder->date->format('d-m-Y'));
            if ($lastPayment)
                array_push($endDateArray, $lastPayment->date->format('d-m-Y'));
            if ($lastReturn)
                array_push($endDateArray, $lastReturn->date->format('d-m-Y'));


            if (count($startDateArray) > 0 && count($endDateArray) > 0) {


                array_multisort(array_map('strtotime', $startDateArray), $startDateArray);
                array_multisort(array_map('strtotime', $endDateArray), $endDateArray);

                $startMin = $startDateArray[0];
                $endMax = $endDateArray[array_key_last($endDateArray)];


                $startDateObj = new Carbon($startMin);
                $endDateObj = new Carbon($endMax);


                $totalDurationLengths = $startDateObj->diffInDays($endDateObj) + 1;


                $clientHistories = [];
                array_push($clientHistories, [
                    'date' => Carbon::parse($openingDue->created_at)->format('d-m-Y') ?? '',
                    'particular' => 'Opening Balance',
                    'quantity' => 0,
                    'invoice' => 0,
                    'discount' => 0,
                    'transport_cost' => 0,
                    'return' => 0,
                    'sale_adjustment' => 0,
                    'party_discount' => 0,
                    'payment' => 0,
                    'due_balance' => $openingDue->opening_due,
                ]);

                for ($i = 0; $i < $totalDurationLengths; $i++) {
                    $date = Carbon::createFromFormat('d-m-Y', $startMin);
                    $searchDate = $date->addDays($i)->format('Y-m-d');

                    $orders = Invoice::where('customer_id', $request->client)
                        ->where('date', $searchDate)->get();


                    foreach ($orders as $order) {
                        if ($order->total <= 0 || $order->return_amount > 0 || $order->sale_adjustment > 0 || $order->discount > 0) {
                            array_push($clientHistories, [
                                'date' => Carbon::parse($order->date)->format('d-m-Y') ?? '',
                                'particular' => 'Invoice Total' . ' ' . $order->customer->name . ' ' . $order->invoice ?? '',
                                'quantity' => $order->quantity() ?? 0,
                                'invoice' => $order->sub_total,
                                'discount' => $order->discount ?? '0',
                                'transport_cost' => $order->transport_cost ?? '0',
                                'return' => $order->return_amount ?? '0',
                                'sale_adjustment' => $order->sale_adjustment ?? '0',
                                'party_discount' => 0,
                                'payment' => 0,
                                'due_balance' => $order->sub_total - $order->discount - $order->sale_adjustment,
                            ]);

                            $salePayments = SalePayment::where('invoice_id', $order->id)
                                ->whereNotIn('transaction_method', [4, 5])
                                ->get();
                            foreach ($salePayments as $salePayment) {
                                //                                if ($salePayment->transactionLog->payment_cheak_status != 3){
                                array_push($clientHistories, [
                                    'date' => Carbon::parse($order->date)->format('d-m-Y') ?? '',
                                    'particular' => 'Receipt From' . ' ' . $order->customer->name . ' ' . $order->invoice ?? '',
                                    'quantity' => 0,
                                    'invoice' => 0,
                                    'discount' => 0,
                                    'transport_cost' => 0,
                                    'return' => 0,
                                    'sale_adjustment' => 0,
                                    'party_discount' => 0,
                                    'payment' => $salePayment->amount,
                                    'due_balance' => 0,
                                ]);
                                //                                }elseif ($salePayment->transactionLog->payment_cheak_status == 3){
                                //                                    array_push($clientHistories,[
                                //                                        'date'=>$order->date->format('d-m-Y') ?? '',
                                //                                        'particular' => $salePayment->transactionLog->particular.' '.$order->order_no??'',
                                //                                        'quantity'=>0,
                                //                                        'invoice'=>0,
                                //                                        'return'=>0,
                                //                                        'payment'=> $salePayment->amount,
                                //                                        'due_balance'=>0,
                                //                                    ]);
                                //                                }
                            }
                        } else {
                            array_push($clientHistories, [
                                'date' => Carbon::parse($order->date)->format('d-m-Y') ?? '',
                                'particular' => 'Invoice Total' . ' ' . $order->customer->name . ' ' . $order->invoice ?? '',
                                'quantity' => $order->quantity() ?? 0,
                                'invoice' => $order->sub_total,
                                'discount' => $order->discount ?? '0',
                                'transport_cost' => $order->transport_cost ?? '0',
                                'return' => $order->return_amount ?? '0',
                                'sale_adjustment' => $order->sale_adjustment ?? '0',
                                'party_discount' => 0,
                                'payment' => 0,
                                'due_balance' => $order->total,

                            ]);


                            $salePayments = SalePayment::where('invoice_id', $order->id)
                                ->whereNotIn('transaction_method', [4, 5])
                                ->get();

                            foreach ($salePayments as $salePayment) {
                                //                                if ($salePayment->transactionLog->payment_cheak_status != 3){
                                array_push($clientHistories, [
                                    'date' => Carbon::parse($order->date)->format('d-m-Y') ?? '',
                                    'particular' => 'Payment From' . ' ' . $order->customer->name . ' ' . $order->invoice ?? '',
                                    'quantity' => 0,
                                    'invoice' => 0,
                                    'discount' => 0,
                                    'transport_cost' => 0,
                                    'return' => 0,
                                    'sale_adjustment' => 0,
                                    'party_discount' => 0,
                                    'payment' => $salePayment->amount,
                                    'due_balance' => 0,
                                ]);
                                //                                }elseif ($salePayment->transactionLog->payment_cheak_status == 3){
                                //                                    array_push($clientHistories, [
                                //                                        'date' => $order->date->format('d-m-Y') ?? '',
                                //                                        'particular' => $salePayment->transactionLog->particular .' ' . $order->order_no ?? '',
                                //                                        'quantity' => 0,
                                //                                        'invoice' => 0,
                                //                                        'return' => 0,
                                //                                        'payment' => $salePayment->amount,
                                //                                        'due_balance' => 0,
                                //                                    ]);
                                //                                }
                            }
                        }
                    }

                    $payments = SalePayment::where('customer_id', $request->client)
                        ->where('date', $searchDate)
                        ->where('invoice_id', '=', null)
                        ->get();

                    //dd($payments);
                    foreach ($payments as $payment) {
                        if ($payment->transaction_method != 4 && $payment->transaction_method != 5) {
                            array_push($clientHistories, [
                                'date' => Carbon::parse($payment->date)->format('d-m-Y') ?? '',
                                // 'particular' => 'Receipt From'.' '.$payment->customer->name.' '.'Without Invoice',
                                'particular' => 'Receipt From' . ' ' . $payment->customer->name . ' ' . $payment->id ?? '',
                                'quantity' => 0,
                                'invoice' => 0,
                                'discount' => 0,
                                'transport_cost' => 0,
                                'return' => 0,
                                'sale_adjustment' => 0,
                                'party_discount' => 0,
                                'payment' => $payment->amount,
                                'due_balance' => 0,
                            ]);
                        }
                    }

                    foreach ($payments as $payment) {
                        if ($payment->transaction_method == 4) {
                            array_push($clientHistories, [
                                'date' => Carbon::parse($payment->date)->format('d-m-Y') ?? '',
                                'particular' => $payment->customer->name . '-' . 'Balance Adjustment-' . $payment->id,
                                'quantity' => 0,
                                'invoice' => 0,
                                'discount' => 0,
                                'transport_cost' => 0,
                                'return' => 0,
                                'sale_adjustment' => 0,
                                'party_discount' => 0,
                                'payment' => $payment->amount,
                                'due_balance' => 0,
                            ]);
                        }
                    }

                    foreach ($payments as $payment) {
                        if ($payment->transaction_method == 5) {
                            array_push($clientHistories, [
                                'date' => Carbon::parse($payment->date)->format('d-m-Y') ?? '',
                                'particular' => $payment->customer->name . '-' . 'Return Adjustment Amount-' . $payment->id,
                                'quantity' => 0,
                                'invoice' => 0,
                                'discount' => 0,
                                'transport_cost' => 0,
                                'return' => $payment->amount,
                                'sale_adjustment' => 0,
                                'party_discount' => 0,
                                'payment' => 0,
                                'due_balance' => 0,
                            ]);
                        }
                    }
                }
            }
        }
        //        $partyDiscounts = PartyLess::where('customer_id', $request->client)->whereBetween('date', [$request->start, $request->end])->get();
        //        foreach ($partyDiscounts as $partyDiscount) {
        ////                                if ($salePayment->transactionLog->payment_cheak_status != 3){
        //            array_push($clientHistories, [
        //                'date'=> Carbon::parse($partyDiscount->date)->format('d-m-Y') ?? '',
        //                'particular' => 'Party Discount' . ' ' . $partyDiscount->customer->name,
        //                'quantity' => 0,
        //                'invoice' => 0,
        //                'discount' => 0,
        //                'transport_cost'=>0,
        //                'return' => 0,
        //                'sale_adjustment' => 0,
        //                'party_discount' => $partyDiscount->amount ?? '0',
        //                'payment' => 0,
        //                'due_balance' => 0,
        //            ]);
        //        }

        //        return($clientHistories);
        return view('report::report.party_ledger', compact(
            'clients',
            'clientHistories',
            'clientName'
        ));
    }
    public function supplierStatement(Request $request)
    {

        $allSuppliers = Supplier::where('status', 1)->orderBy('id', 'desc')->get();
        if ($request->supplier != null) {
            $suppliers = Supplier::where('status', 1)->where('id', $request->supplier)->orderBy('id', 'desc')->get();
        } else {
            $suppliers = Supplier::where('status', 1)->orderBy('id', 'desc')->get();
        }

        return view('report::report.supplier_statement', compact('suppliers', 'allSuppliers'));
    }

    public function vatCertificateSixPointSix(Request $request)
    {
//return($request->all());

        $vats = [];
        $selectParty = null;

        if ($request->party) {
            $selectParty = Client::where('id', $request->party)->first();


            $query = TransactionLog::where('id', $request->party);
            if ($request->start && $request->start != '' && $request->end && $request->end != '') {
                $query->whereBetween('date', [Carbon::parse($request->start)->format('Y-m-d'), Carbon::parse($request->end)->format('Y-m-d')]);
            }
            $vats = $query->orderBy('date')->get();

        }


        return view('report::report.vat_certificate_six_point_six', compact('vats', 'selectParty'));
    }
}
