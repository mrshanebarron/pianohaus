<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LedgerEntry extends Model
{
    public $timestamps = false;

    protected $guarded = ['id'];

    protected $casts = [
        'amount' => 'integer',
        'running_balance' => 'integer',
        'metadata' => 'array',
        'created_at' => 'datetime',
    ];

    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function rental()
    {
        return $this->belongsTo(Rental::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function getFormattedAmountAttribute(): string
    {
        $prefix = $this->amount >= 0 ? '+' : '-';
        return $prefix . '$' . number_format(abs($this->amount) / 100, 2);
    }

    public function getFormattedBalanceAttribute(): string
    {
        return '$' . number_format($this->running_balance / 100, 2);
    }
}
