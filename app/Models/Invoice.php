<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    protected $casts = [
        'subtotal' => 'integer',
        'tax_amount' => 'integer',
        'total' => 'integer',
        'paid_amount' => 'integer',
        'due_date' => 'date',
        'paid_at' => 'datetime',
        'sent_at' => 'datetime',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function rental()
    {
        return $this->belongsTo(Rental::class);
    }

    public function items()
    {
        return $this->hasMany(InvoiceItem::class);
    }

    public function getFormattedTotalAttribute(): string
    {
        return '$' . number_format($this->total / 100, 2);
    }

    public function getBalanceDueAttribute(): int
    {
        return $this->total - $this->paid_amount;
    }

    public function getFormattedBalanceDueAttribute(): string
    {
        return '$' . number_format($this->balance_due / 100, 2);
    }

    public function getIsOverdueAttribute(): bool
    {
        return $this->status !== 'paid' && $this->due_date->isPast();
    }

    public function getStatusLabelAttribute(): string
    {
        return ucfirst($this->status);
    }

    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'draft' => 'gray',
            'sent' => 'blue',
            'paid' => 'green',
            'overdue' => 'red',
            'voided' => 'red',
            'refunded' => 'purple',
            default => 'gray',
        };
    }

    public static function generateInvoiceNumber(): string
    {
        $year = now()->format('Y');
        $last = static::withTrashed()->where('invoice_number', 'like', "INV-{$year}-%")->count();
        return sprintf("INV-%s-%05d", $year, $last + 1);
    }
}
