<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Product extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = [
        'sku',
        'category_id',
        'quality_id',
        'name_en',
        'name_ar',
        'slug',
        'bought_count',
        'is_new',
        'discount_price',
        'discount_start_date',
        'discount_end_date',
        'has_limited_time_discount',
        'is_discounted',
        'has_variants',
        'description_en',
        'description_ar',
        'status',
        'has_multiple_color',
    ];

    protected static function booted(): void
    {
        static::created(function (Product $product): void {
            cache()->flush();
        });

        static::updated(function (Product $product): void {
            cache()->flush();
        });
    }

    protected function casts(): array
    {
        return [
            'bought_count' => 'integer',
            'is_new' => 'boolean',
            'discount_price' => 'decimal:2',
            'discount_start_date' => 'date',
            'discount_end_date' => 'date',
            'has_limited_time_discount' => 'boolean',
            'is_discounted' => 'boolean',
            'has_variants' => 'boolean',
            'status' => 'boolean',
            'has_multiple_color' => 'boolean',
        ];
    }

    protected $appends = [
        'image',
        'name',
    ];

    public function getPlacementImageAttribute()
    {
        return $this->getFirstMediaUrl('placement');
    }

    public function getImageAttribute()
    {
        return $this->getFirstMediaUrl('featured');
    }

    public function getNameAttribute()
    {
        return app()->getLocale() === 'ar' ? $this->name_ar : $this->name_en;
    }

    public function getDescriptionAttribute()
    {
        return app()->getLocale() === 'ar' ? $this->description_ar : $this->description_en;
    }

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($product) {
            // Auto-generate SKU if not provided
            if (empty($product->sku)) {
                $latestProduct = static::latest('id')->first();
                $nextId = $latestProduct ? $latestProduct->id + 1 : 1;
                $product->sku = 'PROD-' . str_pad($nextId, 6, '0', STR_PAD_LEFT);
            }
        });
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(ProductCategory::class, 'category_id');
    }

    public function quality(): BelongsTo
    {
        return $this->belongsTo(ProductQuality::class, 'quality_id');
    }

    public function variants(): HasMany
    {
        return $this->hasMany(ProductVariant::class);
    }

    public function bundleItems(): HasMany
    {
        return $this->hasMany(ProductBundleItem::class);
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', true);
    }

    public function scopeInActive(Builder $query): Builder
    {
        return $query->where('status', false);
    }

    public function scopeHasMultipleColor(Builder $query): Builder
    {
        return $query->where('has_multiple_color', true);
    }

    public function scopeHasSingleColor(Builder $query): Builder
    {
        return $query->where('has_multiple_color', false);
    }
}
