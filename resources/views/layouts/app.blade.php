<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'GameHub') · Console Store</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="{{ asset('css/nintendo.css') }}" rel="stylesheet">
    @stack('styles')
</head>
<body>
<nav class="navbar navbar-expand-lg game-navbar sticky-top">
    <div class="container">
        <a class="navbar-brand game-logo" href="{{ route('home') }}">
            <span class="logo-pill"><i class="bi bi-controller"></i> GAMEHUB</span>
        </a>
        <button class="navbar-toggler bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav"><span class="navbar-toggler-icon"></span></button>
        <div class="collapse navbar-collapse" id="mainNav">
            <ul class="navbar-nav me-auto align-items-lg-center gap-lg-1">
                <li class="nav-item"><a class="nav-link" href="{{ route('home') }}">Store</a></li>
                @auth
                    @if(auth()->user()->isCustomer())
                        <li class="nav-item"><a class="nav-link" href="{{ route('customer.catalog') }}">Games</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('customer.orders.index') }}">My Orders</a></li>
                    @elseif(auth()->user()->isAdmin())
                        <li class="nav-item"><a class="nav-link" href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('admin.games.index') }}">Games</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('admin.orders.index') }}">Orders</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('admin.users.index') }}">Users</a></li>
                    @elseif(auth()->user()->isStaff())
                        <li class="nav-item"><a class="nav-link" href="{{ route('staff.dashboard') }}">Dashboard</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('staff.orders.index') }}">Orders</a></li>
                    @endif
                @endauth
            </ul>
            <div class="d-flex align-items-center gap-2 mt-3 mt-lg-0">
                @auth
                    @if(auth()->user()->isCustomer())
                        @php($cartCount = collect(session('cart', []))->sum('quantity'))
                        <a class="btn btn-light position-relative rounded-pill px-3" href="{{ route('customer.cart.index') }}">
                            <i class="bi bi-bag-fill"></i> Cart
                            @if($cartCount)<span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-dark">{{ $cartCount }}</span>@endif
                        </a>
                    @endif
                    <span class="text-white small d-none d-md-inline">{{ auth()->user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}">@csrf<button class="btn btn-outline-light rounded-pill">Logout</button></form>
                @else
                    <a class="btn btn-outline-light rounded-pill px-3" href="{{ route('login') }}">Login</a>
                    <a class="btn btn-light rounded-pill px-3 fw-bold text-danger" href="{{ route('register') }}">Sign Up</a>
                @endauth
            </div>
        </div>
    </div>
</nav>

@if(session('success') || session('error') || $errors->any())
<div class="container mt-3">
    @if(session('success'))<div class="alert alert-success game-alert"><i class="bi bi-check-circle-fill"></i> {{ session('success') }}</div>@endif
    @if(session('error'))<div class="alert alert-danger game-alert"><i class="bi bi-exclamation-triangle-fill"></i> {{ session('error') }}</div>@endif
    @if($errors->any())
        <div class="alert alert-danger game-alert"><strong>Please check:</strong><ul class="mb-0 mt-1">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
    @endif
</div>
@endif

<main>@yield('content')</main>

<footer class="game-footer mt-5">
    <div class="container py-4 d-flex flex-column flex-md-row justify-content-between gap-2">
        <div><strong><i class="bi bi-controller"></i> GameHub</strong> <span class="opacity-75">Console Game Ordering System</span></div>
        <div class="opacity-75">Nintendo-inspired student project · PSP · Switch · PlayStation · Xbox</div>
    </div>
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.querySelectorAll('[data-confirm]').forEach(form => form.addEventListener('submit', function(e){
    e.preventDefault();
    Swal.fire({title: this.dataset.confirm || 'Are you sure?', icon:'question', showCancelButton:true, confirmButtonColor:'#e60012', confirmButtonText:'Yes, continue'}).then(r=>{if(r.isConfirmed)this.submit();});
}));
</script>
@stack('scripts')
</body>
</html>
