<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'order_number',
        'f_name',
        'l_name',
        'phone_number',
        'address',
        'city',
        'total_amount',
        'status',
    ];

    protected $appends = [
        'status_raw',
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function histories()
    {
        return $this->hasMany(OrderHistory::class)->orderBy('created_at', 'desc');
    }

    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function changeStatus($status)
    {
        $this->update([
            'status' => $status,
        ]);

        OrderHistory::create([
            'order_id' => $this->id,
            'status' => $status,
        ]);
    }

    public function getStatusAttribute($value)
    {
        // If accessing the attribute, return translated value
        // Use getRawOriginal to avoid recursion
        $rawStatus = $this->getRawOriginal('status') ?? $value;

        return __('order.status.' . $rawStatus);
    }

    public function getStatusRawAttribute()
    {
        return $this->getRawOriginal('status');
    }
}
