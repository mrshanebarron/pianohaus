<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'price' => 'integer',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function piano()
    {
        return $this->belongsTo(Piano::class);
    }

    public function getFormattedPriceAttribute(): string
    {
        return '$' . number_format($this->price / 100, 2);
    }

    public function getTotalAttribute(): int
    {
        return $this->price * $this->quantity;
    }
}
