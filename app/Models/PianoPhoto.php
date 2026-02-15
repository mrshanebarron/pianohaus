<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PianoPhoto extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'is_primary' => 'boolean',
    ];

    public function piano()
    {
        return $this->belongsTo(Piano::class);
    }

    public function getUrlAttribute(): string
    {
        return asset('storage/' . $this->path);
    }
}
