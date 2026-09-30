<?php

namespace App\Services;

use App\Models\Game;
use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class OrderService
{
    public function createFromCart(User $customer, array $cart, ?string $notes = null, ?User $creator = null): Order
    {
        if (empty($cart)) {
            throw ValidationException::withMessages(['cart' => 'Your cart is empty.']);
        }

        return DB::transaction(function () use ($customer, $cart, $notes, $creator) {
            $ids = array_keys($cart);
            $games = Game::whereIn('id', $ids)->lockForUpdate()->get()->keyBy('id');
            $lines = [];
            $total = 0;

            foreach ($cart as $gameId => $row) {
                $game = $games->get((int) $gameId);
                $qty = max(1, (int) ($row['quantity'] ?? 1));

                if (! $game || $game->status !== 'active') {
                    throw ValidationException::withMessages(['cart' => 'One of the selected games is no longer available.']);
                }
                if ($game->stock_quantity < $qty) {
                    throw ValidationException::withMessages(['cart' => "Not enough stock for {$game->title}. Available: {$game->stock_quantity}."]);
                }

                $subtotal = round(((float) $game->price) * $qty, 2);
                $total += $subtotal;
                $lines[] = compact('game', 'qty', 'subtotal');
            }

            $order = Order::create([
                'order_number' => Order::nextNumber(),
                'customer_id' => $customer->id,
                'created_by' => ($creator ?? $customer)->id,
                'total_amount' => $total,
                'status' => 'pending',
                'notes' => $notes,
            ]);

            foreach ($lines as $line) {
                $game = $line['game'];
                $order->items()->create([
                    'game_id' => $game->id,
                    'game_title' => $game->title,
                    'platform' => $game->platform,
                    'quantity' => $line['qty'],
                    'unit_price' => $game->price,
                    'subtotal' => $line['subtotal'],
                ]);
                $game->decrement('stock_quantity', $line['qty']);
            }

            return $order->load('items', 'customer');
        });
    }

    public function cancel(Order $order): Order
    {
        return DB::transaction(function () use ($order) {
            $order = Order::whereKey($order->id)->lockForUpdate()->firstOrFail();

            if ($order->status === 'cancelled') {
                return $order;
            }
            if ($order->status === 'completed') {
                throw ValidationException::withMessages(['status' => 'Completed orders cannot be cancelled.']);
            }

            $order->load('items');
            foreach ($order->items as $item) {
                if ($item->game_id) {
                    Game::whereKey($item->game_id)->lockForUpdate()->increment('stock_quantity', $item->quantity);
                }
            }

            $order->update(['status'=>'cancelled', 'cancelled_at'=>now()]);
            return $order->fresh('items');
        });
    }

    public function updateStatus(Order $order, string $status): Order
    {
        if ($status === 'cancelled') {
            return $this->cancel($order);
        }

        $allowed = [
            'pending' => ['confirmed'],
            'confirmed' => ['processing'],
            'processing' => ['completed'],
            'completed' => [],
            'cancelled' => [],
        ];

        if (! in_array($status, $allowed[$order->status] ?? [], true)) {
            throw ValidationException::withMessages(['status' => "Invalid transition from {$order->status} to {$status}."]);
        }

        $order->update(['status'=>$status]);
        return $order->fresh();
    }
}
