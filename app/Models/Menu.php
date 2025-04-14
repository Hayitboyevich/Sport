<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $fillable = [
        'title_uz',
        "title_ru",
        "title_en",
        "slug",
        "type",
        "order",
        "status"
    ];
}
