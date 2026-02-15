<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contract extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    protected $casts = [
        'customer_signed_at' => 'datetime',
        'admin_signed_at' => 'datetime',
        'valid_from' => 'date',
        'valid_until' => 'date',
        'sent_at' => 'datetime',
        'viewed_at' => 'datetime',
    ];

    public function rental()
    {
        return $this->belongsTo(Rental::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function getIsSigned(): bool
    {
        return $this->customer_signed_at !== null;
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
            'viewed' => 'yellow',
            'signed' => 'green',
            'expired' => 'red',
            'voided' => 'red',
            default => 'gray',
        };
    }

    public static function generateContractNumber(): string
    {
        $year = now()->format('Y');
        $last = static::withTrashed()->where('contract_number', 'like', "CTR-{$year}-%")->count();
        return sprintf("CTR-%s-%05d", $year, $last + 1);
    }
}
