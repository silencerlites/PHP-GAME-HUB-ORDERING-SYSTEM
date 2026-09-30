<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Game;
use App\Models\Order;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $stats=[
            'games'=>Game::count(),
            'customers'=>User::where('role','customer')->count(),
            'pending'=>Order::where('status','pending')->count(),
            'sales'=>Order::where('status','completed')->sum('total_amount'),
        ];
        $recent=Order::with('customer')->latest()->limit(8)->get();
        return view('admin.dashboard',compact('stats','recent'));
    }
}
