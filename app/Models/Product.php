<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'type',        // 'ghee' | 'oil'
        'description',
        'price',       // stored in the smallest currency unit (paise)
        'stock',
        'image_path',
        'is_active',
    ];

    protected $casts = [
        'price' => 'integer',
        'stock' => 'integer',
        'is_active' => 'boolean',
    ];

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function inStock(int $qty = 1): bool
    {
        return $this->is_active && $this->stock >= $qty;
    }

    public function priceInRupees(): string
    {
        return number_format($this->price / 100, 2);
    }
}
