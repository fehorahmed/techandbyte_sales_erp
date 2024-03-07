<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function dashboard(){
        return view('dashboard_new');
    }
    public function dashboard2(){
        return view('dashboard_2');
    }
    public function dashboardSaleInformation(){

        dd('sdfdsf');
        return view('dashboard_2');
    }
}
