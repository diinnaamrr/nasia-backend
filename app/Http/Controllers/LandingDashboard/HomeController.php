<?php

namespace App\Http\Controllers\LandingDashboard;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\StockUnit;
use App\Models\PromoCampaign;
use App\Models\FlashSale;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $stats = [
            'departments' => Department::count(),
            'stock_units' => StockUnit::count(),
            'flash_sales' => PromoCampaign::count(),
        ];
        
        $recent_flash_sales = PromoCampaign::orderBy('id', 'desc')->limit(5)->get();

        return view('landingdashboard.home', compact('stats', 'recent_flash_sales'));
    }
}
