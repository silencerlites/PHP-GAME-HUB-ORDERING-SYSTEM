@extends('layouts.app')

@section('title', $order->order_number)

@section('content')
<div class="container py-5">

    {{-- BACK BUTTON --}}
    <a
        href="{{ route('admin.orders.index') }}"
        class="text-decoration-none text-dark"
    >
        <i class="bi bi-arrow-left"></i>
        Orders
    </a>

    {{-- ORDER HEADER --}}
    <div class="order-header mt-3 mb-4">

        <div>
            <span class="section-kicker">
                ADMIN ORDER
            </span>

            <h1 class="fw-black mb-0">
                {{ $order->order_number }}
            </h1>

            <p class="text-secondary mb-0">
                Created by {{ $order->creator->name ?? 'Unknown' }}
                ·
                {{ $order->created_at->format('M d, Y h:i A') }}
            </p>
        </div>

        {{-- ORDER STATUS --}}
        <span class="status status-{{ $order->status }} fs-6">
            {{ ucfirst($order->status) }}
        </span>

    </div>

    {{-- ORDER DETAILS --}}
    @include(
        'partials.order-detail',
        [
            'statusRoute' => route(
                'admin.orders.status',
                $order
            )
        ]
    )

</div>
@endsection