<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\OrderService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $orders=Order::with('customer')->withCount('items')
            ->when($request->filled('status'),fn($q)=>$q->where('status',$request->status))
            ->when($request->filled('q'),fn($q)=>$q->where('order_number','like','%'.$request->q.'%'))
            ->latest()->paginate(15)->withQueryString();
        return view('admin.orders.index',compact('orders'));
    }
    public function show(Order $order){ $order->load('items','customer','creator'); return view('admin.orders.show',compact('order')); }
    public function updateStatus(Request $request, Order $order, OrderService $orders)
    {
        $data=$request->validate(['status'=>['required','in:confirmed,processing,completed,cancelled']]);
        $orders->updateStatus($order,$data['status']);
        return back()->with('success','Order status updated.');
    }
}
