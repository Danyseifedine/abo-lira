<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class ProductCategory extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = [
        'parent_id',
        'name_en',
        'name_ar',
        'slug',
        'status',
    ];

    protected $with = [
        'media',
    ];

    protected $appends = [
        'image',
    ];

    public function getImageAttribute()
    {
        return $this->getFirstMediaUrl('category-image');
    }

    protected function casts(): array
    {
        return [
            'status' => 'boolean',
        ];
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(ProductCategory::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(ProductCategory::class, 'parent_id');
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'category_id');
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', true);
    }

    public function scopeInActive(Builder $query): Builder
    {
        return $query->where('status', false);
    }

    public function getNameAttribute()
    {
        if (app()->isLocale('en')) {
            return $this->name_en;
        }

        return $this->name_ar;
    }
}
