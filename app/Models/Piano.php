<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Piano extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    protected $casts = [
        'dimensions' => 'array',
        'features' => 'array',
        'includes' => 'array',
        'sale_price' => 'integer',
        'original_price' => 'integer',
        'rental_price_monthly' => 'integer',
        'rental_deposit' => 'integer',
        'is_featured' => 'boolean',
        'is_certified' => 'boolean',
        'published_at' => 'datetime',
    ];

    protected static function booted(): void
    {
        static::creating(function ($piano) {
            $piano->slug = $piano->slug ?: Str::slug($piano->name);
        });
    }

    // Relationships

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function photos()
    {
        return $this->hasMany(PianoPhoto::class)->orderBy('sort_order');
    }

    public function primaryPhoto()
    {
        return $this->hasOne(PianoPhoto::class)->where('is_primary', true);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function approvedReviews()
    {
        return $this->hasMany(Review::class)->where('is_approved', true);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function rentals()
    {
        return $this->hasMany(Rental::class);
    }

    // Scopes

    public function scopeAvailable($query)
    {
        return $query->where('status', 'available');
    }

    public function scopeForSale($query)
    {
        return $query->whereIn('type', ['sale', 'both']);
    }

    public function scopeForRent($query)
    {
        return $query->whereIn('type', ['rental', 'both']);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopePublished($query)
    {
        return $query->whereNotNull('published_at')->where('published_at', '<=', now());
    }

    public function scopeSearch($query, string $term)
    {
        return $query->where(function ($q) use ($term) {
            $q->where('name', 'like', "%{$term}%")
              ->orWhere('description', 'like', "%{$term}%")
              ->orWhere('sku', 'like', "%{$term}%")
              ->orWhereHas('brand', fn ($b) => $b->where('name', 'like', "%{$term}%"));
        });
    }

    // Accessors

    public function getFormattedSalePriceAttribute(): string
    {
        return $this->sale_price ? '$' . number_format($this->sale_price / 100, 0) : 'N/A';
    }

    public function getFormattedOriginalPriceAttribute(): string
    {
        return $this->original_price ? '$' . number_format($this->original_price / 100, 0) : '';
    }

    public function getFormattedRentalPriceAttribute(): string
    {
        return $this->rental_price_monthly ? '$' . number_format($this->rental_price_monthly / 100, 0) . '/mo' : 'N/A';
    }

    public function getFormattedRentalDepositAttribute(): string
    {
        return $this->rental_deposit ? '$' . number_format($this->rental_deposit / 100, 0) : 'N/A';
    }

    public function getAverageRatingAttribute(): float
    {
        return round($this->approvedReviews()->avg('rating') ?? 0, 1);
    }

    public function getReviewCountAttribute(): int
    {
        return $this->approvedReviews()->count();
    }

    public function getConditionLabelAttribute(): string
    {
        return config("pianohaus.inventory.conditions.{$this->condition}", ucfirst(str_replace('_', ' ', $this->condition)));
    }

    public function getPrimaryPhotoUrlAttribute(): ?string
    {
        $photo = $this->primaryPhoto ?? $this->photos->first();
        return $photo ? asset('storage/' . $photo->path) : null;
    }

    public function getHasDiscountAttribute(): bool
    {
        return $this->original_price && $this->original_price > $this->sale_price;
    }

    public function getDiscountPercentAttribute(): int
    {
        if (!$this->has_discount) return 0;
        return (int) round((($this->original_price - $this->sale_price) / $this->original_price) * 100);
    }

    // Methods

    public function isAvailable(): bool
    {
        return $this->status === 'available';
    }

    public function canBePurchased(): bool
    {
        return $this->isAvailable() && in_array($this->type, ['sale', 'both']) && $this->sale_price > 0;
    }

    public function canBeRented(): bool
    {
        return $this->isAvailable() && in_array($this->type, ['rental', 'both']) && $this->rental_price_monthly > 0;
    }

    public function markAsSold(): void
    {
        $this->update(['status' => 'sold']);
    }

    public function markAsRented(): void
    {
        $this->update(['status' => 'rented']);
    }

    public function markAsAvailable(): void
    {
        $this->update(['status' => 'available']);
    }

    public static function generateSku(string $name): string
    {
        $base = strtoupper(substr(preg_replace('/[^a-zA-Z0-9]/', '', $name), 0, 8));
        $count = static::where('sku', 'like', $base . '%')->count();
        return $base . '-' . str_pad($count + 1, 3, '0', STR_PAD_LEFT);
    }
}
