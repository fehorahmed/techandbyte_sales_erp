<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\Purchase\Entities\ProductPurchase;
use Modules\Sale\Entities\Invoice;

class DashboardController extends Controller
{
    public function dashboard()
    {
        return view('dashboard_new');
    }
    public function dashboard2()
    {

        $start_date = Carbon::now()->subDays(6);
        $end_date = Carbon::now();


        $weekly_sale_info_query = Invoice::groupBy('date')
            ->selectRaw('sum(total_amount) as t_amount, sum(paid_amount) as p_amount, sum(due_amount) as d_amount, date')
            ->whereBetween('date', [$start_date, $end_date])->get();

        $monthly_start_date = Carbon::now()->startOfMonth();
        $monthly_end_date = Carbon::now();
        //Monthly Sales
        $monthly_sale_info_query = Invoice::select(
            DB::raw('SUM(total_amount) as t_amount'),
            DB::raw('SUM(paid_amount) as p_amount'),
            DB::raw('SUM(due_amount) as d_amount')
        )->whereBetween('date', [$monthly_start_date, $monthly_end_date])
            ->first();

        //Monthly Purchase
        $monthly_purchase_info_query = ProductPurchase::select(
            DB::raw('SUM(grand_total_amount) as t_amount'),
            DB::raw('SUM(paid_amount) as p_amount'),
            DB::raw('SUM(due_amount) as d_amount')
        )->whereBetween('purchase_date', [$monthly_start_date, $monthly_end_date])
            ->first();

        $daily_sale_info_query = Invoice::groupBy('date')
            ->selectRaw('sum(total_amount) as t_amount, sum(paid_amount) as p_amount, sum(due_amount) as d_amount, date')
            ->whereDate('date', $end_date)->get();
        $today_sales = Invoice::whereDate('date', $end_date)->get();
        $today_purcheses = ProductPurchase::whereDate('purchase_date', $end_date)->get();


        //  dd($monthly_purchase_info_query);
        $data['weekly_sale_info'] = $weekly_sale_info_query;
        $data['daily_sale_info_query'] = $daily_sale_info_query;
        $data['today_sales'] = $today_sales;
        $data['monthly_sale_info_query'] = $monthly_sale_info_query;
        $data['monthly_purchase_info_query'] = $monthly_purchase_info_query;
        $data['today_purcheses'] = $today_purcheses;


        return view('dashboard_2')->with($data);
    }
    public function dashboardSaleInformation()
    {

        //dd('sdfdsf');
        // return view('dashboard_2');
    }
}
