@extends('layouts.app')

@section('title', $order->order_number)

@section('content')
<div class="container py-5">

    {{-- BACK LINK --}}
    <a
        href="{{ route('customer.orders.index') }}"
        class="text-decoration-none text-dark"
    >
        <i class="bi bi-arrow-left"></i>
        My Orders
    </a>

    {{-- ORDER HEADER --}}
    <div class="order-header mt-3">

        <div>
            <span class="section-kicker">
                ORDER DETAILS
            </span>

            <h1 class="fw-black">
                {{ $order->order_number }}
            </h1>

            <p class="text-secondary mb-0">
                Placed {{ $order->created_at->format('F d, Y \a\t h:i A') }}
            </p>
        </div>

        <span class="status status-{{ $order->status }} fs-6">
            {{ ucfirst($order->status) }}
        </span>

    </div>

    {{-- ORDER CONTENT --}}
    <div class="row g-4 mt-1">

        {{-- ORDER ITEMS --}}
        <div class="col-lg-8">

            <div class="table-card">

                <div class="table-responsive">

                    <table class="table align-middle mb-0">

                        <thead>
                            <tr>
                                <th>Game</th>
                                <th>Platform</th>
                                <th>Qty</th>
                                <th>Price</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>

                        <tbody>

                            @foreach($order->items as $item)

                                <tr>

                                    {{-- GAME --}}
                                    <td class="fw-bold">
                                        {{ $item->game_title }}
                                    </td>

                                    {{-- PLATFORM --}}
                                    <td>
                                        <span class="platform-mini">
                                            {{ $item->platform }}
                                        </span>
                                    </td>

                                    {{-- QUANTITY --}}
                                    <td>
                                        {{ $item->quantity }}
                                    </td>

                                    {{-- UNIT PRICE --}}
                                    <td>
                                        ₱{{ number_format($item->unit_price, 2) }}
                                    </td>

                                    {{-- SUBTOTAL --}}
                                    <td class="fw-bold">
                                        ₱{{ number_format($item->subtotal, 2) }}
                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

        {{-- ORDER SUMMARY --}}
        <div class="col-lg-4">

            <div class="summary-card">

                <h4 class="fw-black">
                    Summary
                </h4>

                {{-- STATUS --}}
                <div class="d-flex justify-content-between py-3 border-bottom">

                    <span>
                        Status
                    </span>

                    <span class="status status-{{ $order->status }}">
                        {{ ucfirst($order->status) }}
                    </span>

                </div>

                {{-- TOTAL --}}
                <div class="d-flex justify-content-between py-3">

                    <span>
                        Total
                    </span>

                    <strong class="game-total">
                        ₱{{ number_format($order->total_amount, 2) }}
                    </strong>

                </div>

                {{-- NOTES --}}
                @if($order->notes)

                    <div class="note-box">

                        <strong>
                            Notes
                        </strong>

                        <br>

                        {{ $order->notes }}

                    </div>

                @endif

                {{-- CANCEL ORDER --}}
                @if($order->status === 'pending')

                    <form
                        class="mt-3"
                        method="POST"
                        action="{{ route('customer.orders.cancel', $order) }}"
                        data-confirm="Cancel this order? Stock will be returned."
                    >
                        @csrf

                        <button
                            type="submit"
                            class="btn btn-outline-danger w-100"
                        >
                            <i class="bi bi-x-circle"></i>
                            Cancel Order
                        </button>

                    </form>

                @endif

            </div>

        </div>

    </div>

</div>
@endsection