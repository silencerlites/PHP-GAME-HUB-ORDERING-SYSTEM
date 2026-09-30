<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Game;
use App\Services\OrderService;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index(Request $request)
    {
        return view('customer.cart.index', ['cart'=>$request->session()->get('cart', [])]);
    }

    public function add(Request $request, Game $game)
    {
        $request->validate(['quantity'=>['nullable','integer','min:1','max:99']]);
        abort_unless($game->inStock(), 422, 'Game is unavailable.');
        $qty=(int)$request->input('quantity',1);
        $cart=$request->session()->get('cart',[]);
        $existing=(int)($cart[$game->id]['quantity']??0);
        $newQty=$existing+$qty;
        if ($newQty>$game->stock_quantity) return back()->with('error','Quantity exceeds available stock.');
        $cart[$game->id]=[
            'game_id'=>$game->id,'title'=>$game->title,'platform'=>$game->platform,
            'price'=>(float)$game->price,'quantity'=>$newQty,'stock_quantity'=>$game->stock_quantity,
        ];
        $request->session()->put('cart',$cart);
        return back()->with('success',"{$game->title} added to cart.");
    }

    public function update(Request $request, Game $game)
    {
        $data=$request->validate(['quantity'=>['required','integer','min:1','max:99']]);
        if ($data['quantity']>$game->stock_quantity) return back()->with('error','Quantity exceeds available stock.');
        $cart=$request->session()->get('cart',[]);
        if (isset($cart[$game->id])) { $cart[$game->id]['quantity']=$data['quantity']; $cart[$game->id]['stock_quantity']=$game->stock_quantity; }
        $request->session()->put('cart',$cart);
        return back()->with('success','Cart updated.');
    }

    public function remove(Request $request, Game $game)
    {
        $cart=$request->session()->get('cart',[]); unset($cart[$game->id]);
        $request->session()->put('cart',$cart);
        return back()->with('success','Game removed from cart.');
    }

    public function clear(Request $request)
    {
        $request->session()->forget('cart');
        return back()->with('success','Cart cleared.');
    }

    public function checkout(Request $request, OrderService $orders)
    {
        $data=$request->validate(['notes'=>['nullable','string','max:1000']]);
        $order=$orders->createFromCart($request->user(),$request->session()->get('cart',[]),$data['notes']??null);
        $request->session()->forget('cart');
        return redirect()->route('customer.orders.show',$order)->with('success','Order submitted successfully!');
    }
}
