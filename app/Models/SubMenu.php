<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubMenu extends Model
{
    protected $primaryKey = 'sub_menu_id';

    protected $fillable = [
        'menu_id',
        'sub_title_uz',
        'sub_title_ru',
        'sub_title_en',
        'sub_type',
        'slug',
        "order",
        "status"
    ];
}
