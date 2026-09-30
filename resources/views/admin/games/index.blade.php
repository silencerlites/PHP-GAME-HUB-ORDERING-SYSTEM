@extends('layouts.app')
@section('title','Manage Games')
@section('content')
<div class="container py-5">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-end gap-3 mb-4">
        <div><span class="section-kicker">INVENTORY</span><h1 class="fw-black mb-0">Manage Games</h1></div>
        <a class="btn btn-game" href="{{ route('admin.games.create') }}"><i class="bi bi-plus-lg"></i> Add Game</a>
    </div>
    <form class="filter-bar mb-4">
        <input class="form-control" name="q" value="{{ request('q') }}" placeholder="Search title">
        <select class="form-select" name="platform">
            <option value="">All platforms</option>
            @foreach($platforms as $platform)<option value="{{ $platform }}" @selected(request('platform')===$platform)>{{ $platform }}</option>@endforeach
        </select>
        <button class="btn btn-dark">Filter</button>
    </form>
    <div class="table-card">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead><tr><th>Game</th><th>Platform</th><th>Price</th><th>Stock</th><th>Status</th><th class="text-end">Actions</th></tr></thead>
                <tbody>
                @forelse($games as $game)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center gap-3">
                                <div class="admin-game-thumb">
                                    @if($game->image_src)
                                        <img src="{{ $game->image_src }}" alt="{{ $game->title }}">
                                    @else
                                        <i class="bi bi-controller"></i>
                                    @endif
                                </div>
                                <div><strong>{{ $game->title }}</strong><div class="small text-secondary">{{ $game->genre }}</div></div>
                            </div>
                        </td>
                        <td><span class="platform-mini">{{ $game->platform }}</span></td>
                        <td>₱{{ number_format($game->price,2) }}</td>
                        <td><strong class="{{ $game->stock_quantity<=5?'text-danger':'' }}">{{ $game->stock_quantity }}</strong></td>
                        <td><span class="status {{ $game->status==='active'?'status-completed':'status-cancelled' }}">{{ ucfirst($game->status) }}</span></td>
                        <td>
                            <div class="d-flex justify-content-end gap-1">
                                <a class="btn btn-sm btn-outline-dark" href="{{ route('admin.games.edit',$game) }}"><i class="bi bi-pencil"></i></a>
                                <form method="POST" action="{{ route('admin.games.toggle',$game) }}">@csrf @method('PATCH')<button class="btn btn-sm btn-outline-secondary" title="Toggle status"><i class="bi bi-power"></i></button></form>
                                <form method="POST" action="{{ route('admin.games.destroy',$game) }}" data-confirm="Delete this game?">@csrf @method('DELETE')<button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button></form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center py-5">No games found.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="mt-4">{{ $games->links() }}</div>
</div>
@endsection
