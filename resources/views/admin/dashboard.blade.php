@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="container py-5">

    {{-- PAGE HEADER --}}
    <div class="mb-4">
        <span class="section-kicker">
            ADMIN CONSOLE
        </span>

        <h1 class="fw-black">
            Store Dashboard
        </h1>
    </div>

    {{-- DASHBOARD STATISTICS --}}
    <div class="row g-3 mb-5">

        @foreach([
            [
                'Games',
                $stats['games'],
                'bi-controller'
            ],
            [
                'Customers',
                $stats['customers'],
                'bi-people-fill'
            ],
            [
                'Pending Orders',
                $stats['pending'],
                'bi-hourglass-split'
            ],
            [
                'Completed Sales',
                '₱' . number_format($stats['sales'], 2),
                'bi-graph-up-arrow'
            ]
        ] as $stat)

            <div class="col-6 col-lg-3">

                <div class="stat-card">

                    <i class="bi {{ $stat[2] }}"></i>

                    <div>
                        <span>
                            {{ $stat[0] }}
                        </span>

                        <strong>
                            {{ $stat[1] }}
                        </strong>
                    </div>

                </div>

            </div>

        @endforeach

    </div>

    {{-- RECENT ORDERS HEADER --}}
    <div
        class="d-flex justify-content-between
               align-items-end mb-3"
    >
        <div>
            <span class="section-kicker">
                LATEST ACTIVITY
            </span>

            <h3 class="fw-black mb-0">
                Recent Orders
            </h3>
        </div>

        <a
            href="{{ route('admin.orders.index') }}"
            class="btn btn-outline-dark rounded-pill"
        >
            View all
        </a>
    </div>

    {{-- RECENT ORDERS TABLE --}}
    @include(
        'partials.orders-table',
        [
            'orders' => $recent,
            'showRoute' => 'admin.orders.show'
        ]
    )

</div>
@endsection