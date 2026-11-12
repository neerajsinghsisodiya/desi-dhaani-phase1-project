<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'status',            // pending | paid | failed | fulfilled
        'total',              // paise
        'razorpay_order_id',
        'address_id',
    ];

    protected $casts = [
        'total' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function address()
    {
        return $this->belongsTo(Address::class);
    }

    public function markPaid(): void
    {
        $this->update(['status' => 'paid']);
    }
}
