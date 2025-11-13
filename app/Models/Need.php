<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Need extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = [
        'f_name',
        'l_name',
        'phone_number',
        'message',
    ];
}
