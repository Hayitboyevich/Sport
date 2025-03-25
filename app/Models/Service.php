<?php

namespace App\Models;

use App\Enum\ServiceTypeEnum;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $guarded = false;

    protected $casts = [
        'type' => ServiceTypeEnum::class
    ];


}
