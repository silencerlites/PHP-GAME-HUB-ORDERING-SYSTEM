<div class="table-card">

    <div class="table-responsive">

        <table class="table align-middle mb-0">

            <thead>
                <tr>
                    <th>Order</th>
                    <th>Customer</th>
                    <th>Date</th>
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

                        {{-- CUSTOMER --}}
                        <td>
                            {{ $order->customer->name ?? 'Unknown' }}
                        </td>

                        {{-- DATE --}}
                        <td>
                            {{ $order->created_at->format('M d, Y h:i A') }}
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
                                href="{{ route($showRoute, $order) }}"
                                class="btn btn-sm btn-outline-dark"
                            >
                                <i class="bi bi-box-arrow-up-right"></i>
                                Open
                            </a>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td
                            colspan="6"
                            class="text-center py-5 text-secondary"
                        >
                            <i class="bi bi-inbox display-6 d-block mb-3"></i>

                            No orders found.
                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>