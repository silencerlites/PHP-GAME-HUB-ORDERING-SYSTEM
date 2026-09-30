<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $query = Game::active()->where('stock_quantity', '>', 0);
        if ($request->filled('platform')) $query->where('platform', $request->platform);
        if ($request->filled('q')) {
            $term = $request->q;
            $query->where(fn($q) => $q->where('title','like',"%{$term}%")->orWhere('genre','like',"%{$term}%"));
        }
        $games = $query->latest()->paginate(12)->withQueryString();
        $platforms = Game::active()->distinct()->orderBy('platform')->pluck('platform');
        return view('home', compact('games','platforms'));
    }
}
