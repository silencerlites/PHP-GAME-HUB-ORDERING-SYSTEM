@extends('layouts.app')

@section('title', 'Orders')

@section('content')
<div class="container py-5">

    {{-- PAGE HEADER --}}
    <div
        class="d-flex flex-column flex-lg-row
               justify-content-between align-items-lg-end gap-3"
    >
        <div>
            <span class="section-kicker">
                ORDER QUEUE
            </span>

            <h1 class="fw-black mb-1">
                All Orders
            </h1>

            <p class="text-secondary mb-0">
                View and manage customer orders.
            </p>
        </div>


        {{-- FILTER --}}
        <form
            method="GET"
            class="filter-bar"
        >

            {{-- ORDER NUMBER --}}
            <input
                type="text"
                class="form-control"
                name="q"
                value="{{ request('q') }}"
                placeholder="Search order number"
            >


            {{-- STATUS --}}
            <select
                class="form-select"
                name="status"
            >
                <option value="">
                    All statuses
                </option>

                @foreach([
                    'pending',
                    'confirmed',
                    'processing',
                    'completed',
                    'cancelled'
                ] as $status)

                    <option
                        value="{{ $status }}"
                        @selected(request('status') === $status)
                    >
                        {{ ucfirst($status) }}
                    </option>

                @endforeach

            </select>


            {{-- FILTER BUTTON --}}
            <button
                type="submit"
                class="btn btn-dark"
            >
                <i class="bi bi-funnel-fill"></i>
                Filter
            </button>


            {{-- RESET --}}
            @if(request()->filled('q') || request()->filled('status'))

                <a
                    href="{{ route('admin.orders.index') }}"
                    class="btn btn-outline-secondary"
                >
                    <i class="bi bi-arrow-counterclockwise"></i>
                    Reset
                </a>

            @endif

        </form>

    </div>


    {{-- ORDERS TABLE --}}
    <div class="mt-4">

        @include(
            'partials.orders-table',
            [
                'orders' => $orders,
                'showRoute' => 'admin.orders.show'
            ]
        )

    </div>


    {{-- PAGINATION --}}
    @if($orders->hasPages())

        <div class="mt-4">
            {{ $orders->withQueryString()->links() }}
        </div>

    @endif

</div>
@endsection