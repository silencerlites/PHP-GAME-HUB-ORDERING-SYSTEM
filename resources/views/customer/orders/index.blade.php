@extends('layouts.app')

@section('title', 'My Orders')

@section('content')
<div class="container py-5">

    {{-- PAGE HEADER --}}
    <div class="mb-4">

        <span class="section-kicker">
            PLAYER HISTORY
        </span>

        <h1 class="fw-black">
            My Orders
        </h1>

    </div>

    {{-- ORDERS TABLE --}}
    <div class="table-card">

        <div class="table-responsive">

            <table class="table align-middle mb-0">

                <thead>
                    <tr>
                        <th>Order</th>
                        <th>Date</th>
                        <th>Items</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($orders as $order)

                        <tr>

                            {{-- ORDER NUMBER --}}
                            <td class="fw-bold">
                                {{ $order->order_number }}
                            </td>

                            {{-- DATE --}}
                            <td>
                                {{ $order->created_at->format('M d, Y h:i A') }}
                            </td>

                            {{-- ITEM COUNT --}}
                            <td>
                                {{ $order->items_count }}
                            </td>

                            {{-- TOTAL --}}
                            <td class="fw-bold">
                                ₱{{ number_format($order->total_amount, 2) }}
                            </td>

                            {{-- STATUS --}}
                            <td>

                                <span class="status status-{{ $order->status }}">
                                    {{ ucfirst($order->status) }}
                                </span>

                            </td>

                            {{-- ACTION --}}
                            <td class="text-end">

                                <a
                                    href="{{ route('customer.orders.show', $order) }}"
                                    class="btn btn-sm btn-outline-dark"
                                >
                                    <i class="bi bi-eye"></i>
                                    View
                                </a>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="6"
                                class="text-center py-5 text-secondary"
                            >
                                <i class="bi bi-receipt display-5 d-block mb-3"></i>

                                No orders yet.
                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

    {{-- PAGINATION --}}
    @if($orders->hasPages())

        <div class="mt-4">
            {{ $orders->withQueryString()->links() }}
        </div>

    @endif

</div>
@endsection