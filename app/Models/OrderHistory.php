<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderHistory extends Model
{
    protected $fillable = [
        'order_id',
        'status',
    ];

    protected $appends = [
        'status_raw',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function getStatusAttribute($value): string
    {
        $rawStatus = $this->getRawOriginal('status') ?? $value;

        return __('order.status.'.$rawStatus);
    }

    public function getStatusRawAttribute(): string
    {
        return $this->getRawOriginal('status');
    }
}
