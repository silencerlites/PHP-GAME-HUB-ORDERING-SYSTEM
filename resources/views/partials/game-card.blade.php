<div class="col">
    <div class="card game-card h-100 border-0">
        <div class="game-cover platform-{{ Str::slug($game->platform) }}">
            @if($game->image_src)
                <img src="{{ $game->image_src }}" alt="{{ $game->title }}">
            @else
                <div class="cover-placeholder"><i class="bi bi-controller"></i><span>{{ $game->platform }}</span></div>
            @endif
            <span class="platform-badge">{{ $game->platform }}</span>
        </div>
        <div class="card-body d-flex flex-column">
            <div class="small text-secondary mb-1">{{ $game->genre ?: 'Game' }}</div>
            <h5 class="card-title fw-bold">{{ $game->title }}</h5>
            <p class="card-text text-secondary small flex-grow-1">{{ Str::limit($game->description, 92) }}</p>
            <div class="d-flex justify-content-between align-items-end gap-2">
                <div><div class="game-price">₱{{ number_format($game->price, 2) }}</div><div class="small {{ $game->stock_quantity > 5 ? 'text-success' : 'text-warning' }}">{{ $game->stock_quantity }} in stock</div></div>
                @auth
                    @if(auth()->user()->isCustomer())
                    <form method="POST" action="{{ route('customer.cart.add',$game) }}">@csrf
                        <input type="hidden" name="quantity" value="1">
                        <button class="btn btn-game" {{ $game->stock_quantity<1?'disabled':'' }}><i class="bi bi-cart-plus-fill"></i> Add</button>
                    </form>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="btn btn-game">Buy</a>
                @endauth
            </div>
        </div>
    </div>
</div>
