<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\OrderService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $orders=Order::withCount('items')->where('customer_id',$request->user()->id)->latest()->paginate(10);
        return view('customer.orders.index',compact('orders'));
    }

    public function show(Request $request, Order $order)
    {
        abort_unless($order->customer_id === $request->user()->id, 403);
        $order->load('items');
        return view('customer.orders.show',compact('order'));
    }

    public function cancel(Request $request, Order $order, OrderService $orders)
    {
        abort_unless($order->customer_id === $request->user()->id, 403);
        if ($order->status !== 'pending') return back()->with('error','Only pending orders can be cancelled by customers.');
        $orders->cancel($order);
        return back()->with('success','Order cancelled and stock restored.');
    }
}
