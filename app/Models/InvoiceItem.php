<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvoiceItem extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'unit_price' => 'integer',
        'total' => 'integer',
    ];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    public function getFormattedUnitPriceAttribute(): string
    {
        return '$' . number_format($this->unit_price / 100, 2);
    }

    public function getFormattedTotalAttribute(): string
    {
        return '$' . number_format($this->total / 100, 2);
    }
}
