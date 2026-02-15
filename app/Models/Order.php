<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    protected $casts = [
        'delivery_address' => 'array',
        'delivery_date' => 'date',
        'paid_at' => 'datetime',
        'subtotal' => 'integer',
        'tax_amount' => 'integer',
        'delivery_fee' => 'integer',
        'discount_amount' => 'integer',
        'total' => 'integer',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    public function contracts()
    {
        return $this->hasMany(Contract::class);
    }

    public function deliveryTasks()
    {
        return $this->hasMany(DeliveryTask::class);
    }

    public function ledgerEntries()
    {
        return $this->hasMany(LedgerEntry::class);
    }

    public function activityLogs()
    {
        return $this->morphMany(ActivityLog::class, 'subject');
    }

    // Scopes

    public function scopeStatus($query, string $status)
    {
        return $query->where('status', $status);
    }

    // Accessors

    public function getFormattedTotalAttribute(): string
    {
        return '$' . number_format($this->total / 100, 2);
    }

    public function getFormattedSubtotalAttribute(): string
    {
        return '$' . number_format($this->subtotal / 100, 2);
    }

    public function getFormattedTaxAttribute(): string
    {
        return '$' . number_format($this->tax_amount / 100, 2);
    }

    public function getFormattedDeliveryFeeAttribute(): string
    {
        return '$' . number_format($this->delivery_fee / 100, 2);
    }

    public function getIsPaidAttribute(): bool
    {
        return $this->paid_at !== null;
    }

    public function getStatusLabelAttribute(): string
    {
        return ucfirst(str_replace('_', ' ', $this->status));
    }

    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'pending' => 'yellow',
            'confirmed', 'processing' => 'blue',
            'ready_for_delivery' => 'indigo',
            'delivered', 'completed' => 'green',
            'cancelled' => 'gray',
            'refunded' => 'red',
            default => 'gray',
        };
    }

    // Number generation

    public static function generateOrderNumber(): string
    {
        $year = now()->format('Y');
        $last = static::withTrashed()->where('order_number', 'like', "ORD-{$year}-%")->count();
        return sprintf("ORD-%s-%05d", $year, $last + 1);
    }
}
