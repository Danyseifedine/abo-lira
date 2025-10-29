<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;

class ProductQuality extends Model
{
    protected $fillable = [
        'name_en',
        'name_ar',
        'slug',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'status' => 'boolean',
        ];
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'quality_id');
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
        return app()->getLocale() === 'ar' ? $this->name_ar : $this->name_en;
    }
}
