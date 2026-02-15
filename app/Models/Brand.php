<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Brand extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    protected static function booted(): void
    {
        static::creating(function ($brand) {
            $brand->slug = $brand->slug ?: Str::slug($brand->name);
        });
    }

    public function pianos()
    {
        return $this->hasMany(Piano::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
