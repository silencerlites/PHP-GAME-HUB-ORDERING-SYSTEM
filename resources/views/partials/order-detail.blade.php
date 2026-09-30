<div class="row g-4">

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
                            <th>Unit Price</th>
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

    {{-- ORDER CONTROL --}}
    <div class="col-lg-4">

        <div class="summary-card">

            <h4 class="fw-black">
                Order Control
            </h4>

            {{-- CUSTOMER --}}
            <div class="small text-secondary">
                Customer
            </div>

            <div class="fw-bold mb-3">
                {{ $order->customer->name }}

                <br>

                <span class="fw-normal text-secondary">
                    {{ $order->customer->email }}
                </span>
            </div>

            {{-- TOTAL --}}
            <div
                class="d-flex justify-content-between
                       py-3 border-top border-bottom"
            >
                <span>
                    Total
                </span>

                <strong class="game-total">
                    ₱{{ number_format($order->total_amount, 2) }}
                </strong>
            </div>

            {{-- CURRENT STATUS --}}
            <div class="mt-3">

                <span class="status status-{{ $order->status }}">
                    {{ ucfirst($order->status) }}
                </span>

            </div>

            {{-- NOTES --}}
            @if($order->notes)

                <div class="note-box mt-3">

                    <strong>
                        Notes
                    </strong>

                    <br>

                    {{ $order->notes }}

                </div>

            @endif

            {{-- STATUS UPDATE --}}
            @if(!in_array($order->status, ['completed', 'cancelled']))

                <form
                    method="POST"
                    action="{{ $statusRoute }}"
                    class="mt-4"
                    data-confirm="Update this order status?"
                >
                    @csrf
                    @method('PATCH')

                    <label
                        for="status"
                        class="form-label fw-semibold"
                    >
                        Next Status
                    </label>

                    <select
                        id="status"
                        class="form-select mb-3"
                        name="status"
                        required
                    >

                        @if($order->status === 'pending')

                            <option value="confirmed">
                                Confirmed
                            </option>

                        @endif

                        @if($order->status === 'confirmed')

                            <option value="processing">
                                Processing
                            </option>

                        @endif

                        @if($order->status === 'processing')

                            <option value="completed">
                                Completed
                            </option>

                        @endif

                        <option value="cancelled">
                            Cancelled
                        </option>

                    </select>

                    <button
                        type="submit"
                        class="btn btn-game w-100"
                    >
                        Update Status
                    </button>

                </form>

            @endif

        </div>

    </div>

</div>