<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class ProductBundle extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = [
        'name_en',
        'name_ar',
        'slug',
        'description_en',
        'description_ar',
        'bundle_price',
        'original_price',
        'stock_quantity',
        'has_limited_time',
        'start_date',
        'end_date',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'bundle_price' => 'decimal:2',
            'original_price' => 'decimal:2',
            'stock_quantity' => 'integer',
            'has_limited_time' => 'boolean',
            'start_date' => 'date',
            'end_date' => 'date',
            'status' => 'boolean',
        ];
    }

    public function items(): HasMany
    {
        return $this->hasMany(ProductBundleItem::class, 'bundle_id');
    }

    public function products()
    {
        return $this->hasManyThrough(
            Product::class,
            ProductBundleItem::class,
            'bundle_id',
            'id',
            'id',
            'product_id'
        );
    }
}
