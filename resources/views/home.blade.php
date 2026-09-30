@extends('layouts.app')
@section('title','Game Store')
@section('content')
<section class="hero-zone">
    <div class="container py-5 py-lg-6">
        <div class="row align-items-center g-4">
            <div class="col-lg-7">
                <span class="hero-chip"><i class="bi bi-stars"></i> READY, PLAYER ONE</span>
                <h1 class="display-3 fw-black mt-3">Your next game<br><span>starts here.</span></h1>
                <p class="lead opacity-90">Shop Nintendo Switch, PSP, PlayStation and Xbox titles in one colorful console-inspired store.</p>
                <div class="d-flex flex-wrap gap-2 mt-4">
                    @guest<a href="{{ route('register') }}" class="btn btn-light btn-lg rounded-pill fw-bold text-danger px-4">Create Player Account</a>@endguest
                    <a href="#games" class="btn btn-outline-light btn-lg rounded-pill px-4">Browse Games</a>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="console-art">
                    <div class="joy joy-left"><span class="stick"></span><span class="minus">−</span></div>
                    <div class="screen"><i class="bi bi-controller"></i><strong>GAMEHUB</strong><small>PLAY · ORDER · ENJOY</small></div>
                    <div class="joy joy-right"><span class="buttons">● ●<br>● ●</span><span class="plus">+</span></div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="container py-5" id="games">
    <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-end gap-3 mb-4">
        <div><span class="section-kicker">GAME LIBRARY</span><h2 class="fw-black mb-0">Pick your next adventure</h2></div>
        <form class="d-flex flex-wrap gap-2">
            <input class="form-control search-control" name="q" value="{{ request('q') }}" placeholder="Search games...">
            <select class="form-select search-control" name="platform"><option value="">All platforms</option>@foreach($platforms as $platform)<option value="{{ $platform }}" @selected(request('platform')===$platform)>{{ $platform }}</option>@endforeach</select>
            <button class="btn btn-game">Search</button>
        </form>
    </div>
    <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-3 row-cols-xl-4 g-4">@forelse($games as $game)@include('partials.game-card')@empty<div class="col-12"><div class="empty-state">No games found.</div></div>@endforelse</div>
    <div class="mt-4">{{ $games->links() }}</div>
</section>
@endsection
