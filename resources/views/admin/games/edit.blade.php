@extends('layouts.app')
@section('title','Edit Game')
@section('content')
<div class="container py-5">
    <a href="{{ route('admin.games.index') }}" class="text-decoration-none text-dark"><i class="bi bi-arrow-left"></i> Games</a>
    <div class="form-card mt-3">
        <span class="section-kicker">EDIT INVENTORY</span>
        <h1 class="fw-black mb-4">{{ $game->title }}</h1>
        <form method="POST" action="{{ route('admin.games.update',$game) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            @include('admin.games._form')
            <div class="mt-4 d-flex gap-2">
                <button class="btn btn-game btn-lg">Update Game</button>
                <a href="{{ route('admin.games.index') }}" class="btn btn-light btn-lg">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
