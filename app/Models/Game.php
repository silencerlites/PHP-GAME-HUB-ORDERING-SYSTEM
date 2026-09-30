<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Game extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'platform', 'genre', 'description', 'price',
        'stock_quantity', 'status', 'image_url', 'image_path',
    ];

    protected function casts(): array
    {
        return ['price' => 'decimal:2', 'stock_quantity' => 'integer'];
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function inStock(): bool
    {
        return $this->status === 'active' && $this->stock_quantity > 0;
    }

    public function getImageSrcAttribute(): ?string
    {
        if ($this->image_path) {
            return Storage::disk('public')->url($this->image_path);
        }

        return $this->image_url ?: null;
    }
}
