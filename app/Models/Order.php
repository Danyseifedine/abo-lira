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

    protected function casts(): array
    {
        return [
            'status' => 'string',
        ];
    }

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

    public function changeStatus($status): void
    {
        // Ensure status is a string and trim any whitespace
        $status = is_string($status) ? trim($status) : (string) $status;

        // Validate status value
        $allowedStatuses = ['pending', 'accepted', 'on_the_way', 'completed', 'rejected', 'refunded'];
        if (! in_array($status, $allowedStatuses, true)) {
            throw new \InvalidArgumentException("Invalid status: {$status}");
        }

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

        return __('order.status.'.$rawStatus);
    }

    public function getStatusRawAttribute()
    {
        return $this->getRawOriginal('status');
    }
}
