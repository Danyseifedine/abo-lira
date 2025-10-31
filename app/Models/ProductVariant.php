<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class ProductVariant extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = [
        'sku',
        'product_id',
        'color_id',
        'size_id',
        'price',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'status' => 'boolean',
        ];
    }

    protected $appends = [
        'image',
    ];

    public function getImageAttribute()
    {
        return $this->getFirstMediaUrl('variant-image');
    }

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($variant) {
            // Auto-generate SKU if not provided
            if (empty($variant->sku)) {
                $product = Product::find($variant->product_id);
                if ($product) {
                    // Count existing variants for this product
                    $variantCount = static::where('product_id', $variant->product_id)->count();
                    $nextVariantNumber = $variantCount + 1;
                    // Generate SKU as: PROD-000001-VAR-01
                    $variant->sku = $product->sku . '-VAR-' . str_pad($nextVariantNumber, 2, '0', STR_PAD_LEFT);
                }
            }
        });
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function color(): BelongsTo
    {
        return $this->belongsTo(ProductVariantColor::class, 'color_id');
    }

    public function size(): BelongsTo
    {
        return $this->belongsTo(ProductVariantSize::class, 'size_id');
    }

    public function bundleItems(): HasMany
    {
        return $this->hasMany(ProductBundleItem::class, 'variant_id');
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', true);
    }

    public function scopeInActive(Builder $query): Builder
    {
        return $query->where('status', false);
    }
}
