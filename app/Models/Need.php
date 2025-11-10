<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Need extends Model
{
    protected $fillable = [
        'f_name',
        'l_name',
        'phone_number',
        'message',
    ];
}
