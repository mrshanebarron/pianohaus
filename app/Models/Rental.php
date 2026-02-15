<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Rental extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    protected $casts = [
        'deposit_paid' => 'boolean',
        'start_date' => 'date',
        'end_date' => 'date',
        'minimum_end_date' => 'date',
        'next_payment_date' => 'date',
        'delivery_address' => 'array',
        'delivery_date' => 'date',
        'return_date' => 'date',
        'approved_at' => 'datetime',
        'monthly_rate' => 'integer',
        'deposit_amount' => 'integer',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function piano()
    {
        return $this->belongsTo(Piano::class);
    }

    public function contract()
    {
        return $this->belongsTo(Contract::class);
    }

    public function approvedByUser()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
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

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending_application');
    }

    // Accessors

    public function getFormattedMonthlyRateAttribute(): string
    {
        return '$' . number_format($this->monthly_rate / 100, 2);
    }

    public function getFormattedDepositAttribute(): string
    {
        return '$' . number_format($this->deposit_amount / 100, 2);
    }

    public function getStatusLabelAttribute(): string
    {
        return ucfirst(str_replace('_', ' ', $this->status));
    }

    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'pending_application' => 'yellow',
            'approved' => 'blue',
            'active' => 'green',
            'past_due' => 'red',
            'suspended' => 'orange',
            'completed' => 'gray',
            'cancelled' => 'gray',
            'denied' => 'red',
            default => 'gray',
        };
    }

    public function getDurationMonthsAttribute(): ?int
    {
        if (!$this->start_date || !$this->end_date) return null;
        return $this->start_date->diffInMonths($this->end_date);
    }

    public function getTotalPaidAttribute(): int
    {
        return $this->payments()->where('status', 'completed')->sum('amount');
    }

    // Number generation

    public static function generateRentalNumber(): string
    {
        $year = now()->format('Y');
        $last = static::withTrashed()->where('rental_number', 'like', "RNT-{$year}-%")->count();
        return sprintf("RNT-%s-%05d", $year, $last + 1);
    }
}
