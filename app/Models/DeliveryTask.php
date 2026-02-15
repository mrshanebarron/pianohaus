<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DeliveryTask extends Model
{
    use SoftDeletes;

    protected $guarded = ['id'];

    protected $casts = [
        'scheduled_date' => 'date',
        'completed_at' => 'datetime',
        'address' => 'array',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function rental()
    {
        return $this->belongsTo(Rental::class);
    }

    public function getStatusLabelAttribute(): string
    {
        return ucfirst(str_replace('_', ' ', $this->status));
    }

    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'pending' => 'yellow',
            'scheduled' => 'blue',
            'in_transit' => 'indigo',
            'completed' => 'green',
            'cancelled' => 'gray',
            default => 'gray',
        };
    }

    public function getTypeLabelAttribute(): string
    {
        return ucfirst($this->type);
    }

    public function markCompleted(): void
    {
        $this->update(['status' => 'completed', 'completed_at' => now()]);
    }
}
