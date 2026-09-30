<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = ['order_id', 'game_id', 'game_title', 'platform', 'quantity', 'unit_price', 'subtotal'];

    protected function casts(): array
    {
        return ['unit_price' => 'decimal:2', 'subtotal' => 'decimal:2', 'quantity' => 'integer'];
    }

    public function order() { return $this->belongsTo(Order::class); }
    public function game() { return $this->belongsTo(Game::class); }
}
