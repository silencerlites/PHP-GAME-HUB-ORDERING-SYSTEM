@extends('layouts.app')

@section('content')
<div class="container py-4">

    @if(empty($cart))

        <div class="empty-state">
            <i class="bi bi-bag-x display-4"></i>

            <h3 class="mt-3">
                Your cart is empty
            </h3>

            <a href="{{ route('customer.catalog') }}" class="btn btn-game mt-2">
                Browse Games
            </a>
        </div>

    @else

        @php
            $total = 0;
        @endphp

        <div class="row g-4">

            {{-- CART ITEMS --}}
            <div class="col-lg-8">

                <div class="table-card">
                    <div class="table-responsive">

                        <table class="table align-middle mb-0">

                            <thead>
                                <tr>
                                    <th>Game</th>
                                    <th>Price</th>
                                    <th style="width: 170px;">Qty</th>
                                    <th>Subtotal</th>
                                    <th></th>
                                </tr>
                            </thead>

                            <tbody>

                                @foreach($cart as $row)

                                    @php
                                        $sub = $row['price'] * $row['quantity'];
                                        $total += $sub;
                                    @endphp

                                    <tr>

                                        {{-- GAME --}}
                                        <td>
                                            <div class="d-flex align-items-center gap-3">

                                                @if(!empty($row['image_path']))
                                                    <img
                                                        src="{{ asset('storage/' . $row['image_path']) }}"
                                                        alt="{{ $row['title'] }}"
                                                        style="
                                                            width: 65px;
                                                            height: 65px;
                                                            object-fit: cover;
                                                            border-radius: 12px;
                                                        "
                                                    >
                                                @else
                                                    <div
                                                        class="d-flex align-items-center justify-content-center bg-light"
                                                        style="
                                                            width: 65px;
                                                            height: 65px;
                                                            border-radius: 12px;
                                                        "
                                                    >
                                                        <i class="bi bi-controller fs-3"></i>
                                                    </div>
                                                @endif

                                                <div>
                                                    <div class="fw-bold">
                                                        {{ $row['title'] }}
                                                    </div>

                                                    <span class="platform-mini">
                                                        {{ $row['platform'] }}
                                                    </span>
                                                </div>

                                            </div>
                                        </td>

                                        {{-- PRICE --}}
                                        <td>
                                            ₱{{ number_format($row['price'], 2) }}
                                        </td>

                                        {{-- QUANTITY --}}
                                        <td>

                                            <form
                                                class="d-flex gap-2"
                                                method="POST"
                                                action="{{ route('customer.cart.update', $row['game_id']) }}"
                                            >
                                                @csrf
                                                @method('PUT')

                                                <input
                                                    class="form-control"
                                                    type="number"
                                                    name="quantity"
                                                    min="1"
                                                    max="{{ $row['stock_quantity'] }}"
                                                    value="{{ $row['quantity'] }}"
                                                >

                                                <button
                                                    type="submit"
                                                    class="btn btn-outline-dark"
                                                    title="Update"
                                                >
                                                    <i class="bi bi-arrow-repeat"></i>
                                                </button>

                                            </form>

                                        </td>

                                        {{-- SUBTOTAL --}}
                                        <td class="fw-bold">
                                            ₱{{ number_format($sub, 2) }}
                                        </td>

                                        {{-- REMOVE --}}
                                        <td>

                                            <form
                                                method="POST"
                                                action="{{ route('customer.cart.remove', $row['game_id']) }}"
                                                data-confirm="Remove this game from cart?"
                                            >
                                                @csrf
                                                @method('DELETE')

                                                <button
                                                    type="submit"
                                                    class="btn btn-sm btn-outline-danger"
                                                >
                                                    <i class="bi bi-trash3"></i>
                                                </button>

                                            </form>

                                        </td>

                                    </tr>

                                @endforeach

                            </tbody>

                        </table>

                    </div>
                </div>


                {{-- CLEAR CART --}}
                <form
                    method="POST"
                    action="{{ route('customer.cart.clear') }}"
                    data-confirm="Clear your entire cart?"
                    class="mt-3"
                >
                    @csrf
                    @method('DELETE')

                    <button
                        type="submit"
                        class="btn btn-link text-danger p-0"
                    >
                        <i class="bi bi-trash3"></i>
                        Clear cart
                    </button>

                </form>

            </div>


            {{-- ORDER SUMMARY --}}
            <div class="col-lg-4">

                <div class="summary-card">

                    <h4 class="fw-black">
                        Order Summary
                    </h4>

                    <div class="d-flex justify-content-between py-3 border-bottom">

                        <span>
                            Items
                        </span>

                        <strong>
                            {{ collect($cart)->sum('quantity') }}
                        </strong>

                    </div>

                    <div class="d-flex justify-content-between py-3">

                        <span>
                            Total
                        </span>

                        <strong class="game-total">
                            ₱{{ number_format($total, 2) }}
                        </strong>

                    </div>


                    {{-- CHECKOUT --}}
                    <form
                        method="POST"
                        action="{{ route('customer.checkout') }}"
                        data-confirm="Submit this order?"
                    >
                        @csrf

                        <label class="form-label fw-semibold">

                            Order notes

                            <span class="text-secondary fw-normal">
                                (optional)
                            </span>

                        </label>

                        <textarea
                            name="notes"
                            class="form-control mb-3"
                            rows="3"
                            placeholder="Pickup note or special request..."
                        >{{ old('notes') }}</textarea>

                        <button
                            type="submit"
                            class="btn btn-game btn-lg w-100"
                        >
                            <i class="bi bi-bag-check-fill"></i>
                            Place Order
                        </button>

                    </form>


                    <div class="secure-note mt-3">

                        <i class="bi bi-shield-check"></i>

                        Prices and stock are rechecked on the server before checkout.

                    </div>

                </div>

            </div>

        </div>

    @endif

</div>
@endsection