<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Game;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    public function index(Request $request)
    {
        $query = Game::active();
        if ($request->filled('platform')) $query->where('platform', $request->platform);
        if ($request->filled('q')) {
            $term=$request->q;
            $query->where(fn($q)=>$q->where('title','like',"%{$term}%")->orWhere('genre','like',"%{$term}%"));
        }
        $games=$query->orderByDesc('stock_quantity')->paginate(12)->withQueryString();
        $platforms=Game::active()->distinct()->orderBy('platform')->pluck('platform');
        return view('customer.catalog',compact('games','platforms'));
    }
}
