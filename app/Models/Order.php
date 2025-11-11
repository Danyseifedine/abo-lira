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

    public function items() {
        return $this->hasMany(OrderItem::class);
    }

    public function scopeStatus($query, $status) {
        return $query->where('status', $status);
    }
}
