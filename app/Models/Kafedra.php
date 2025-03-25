<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kafedra extends Model
{
    protected $primaryKey = 'kafedra_id';

    protected $fillable = [
        'kafedra_menu_id',
        'kafedra_name',
        'kafedra_name_ru',
        'kafedra_name_en',
        'kafedra_about',
        'kafedra_status',
        'kafedra_about_ru',
        'kafedra_about_en'
    ];
}
