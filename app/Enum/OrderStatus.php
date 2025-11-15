<?php

namespace App\Enum;

enum OrderStatus: string
{
    case PENDING = 'pending';
    case ACCEPTED = 'accepted';
    case ON_THE_WAY = 'on_the_way';
    case COMPLETED = 'completed';
    case REJECTED = 'rejected';
    case REFUNDED = 'refunded';
}
