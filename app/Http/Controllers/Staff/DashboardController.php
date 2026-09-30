<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Game;
use App\Models\Order;

class DashboardController extends Controller
{
    public function index()
    {
        $stats=[
            'pending'=>Order::where('status','pending')->count(),
            'processing'=>Order::where('status','processing')->count(),
            'completed_today'=>Order::where('status','completed')->whereDate('updated_at',today())->count(),
            'low_stock'=>Game::where('stock_quantity','<=',5)->where('status','active')->count(),
        ];
        $recent=Order::with('customer')->latest()->limit(10)->get();
        return view('staff.dashboard',compact('stats','recent'));
    }
}
