<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'unit_price', // paise, snapshot at time of purchase
    ];

    protected $casts = [
        'quantity' => 'integer',
        'unit_price' => 'integer',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function lineTotal(): int
    {
        return $this->quantity * $this->unit_price;
    }
}
