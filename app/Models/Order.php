<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number', 'customer_id', 'created_by', 'total_amount',
        'status', 'notes', 'cancelled_at',
    ];

    protected function casts(): array
    {
        return ['total_amount' => 'decimal:2', 'cancelled_at' => 'datetime'];
    }

    public function customer() { return $this->belongsTo(User::class, 'customer_id'); }
    public function creator() { return $this->belongsTo(User::class, 'created_by'); }
    public function items() { return $this->hasMany(OrderItem::class); }

    public static function nextNumber(): string
    {
        do {
            $number = 'GAME-'.now()->format('Ymd').'-'.strtoupper(substr(bin2hex(random_bytes(4)), 0, 6));
        } while (self::where('order_number', $number)->exists());
        return $number;
    }
}
