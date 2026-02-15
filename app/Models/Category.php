<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    protected static function booted(): void
    {
        static::creating(function ($category) {
            $category->slug = $category->slug ?: Str::slug($category->name);
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
