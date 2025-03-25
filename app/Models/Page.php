<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $primaryKey = 'page_id';
    protected $fillable = [
        'page_menu_id',
        'page_title',
        'page_slug',
        'page_content',
        'page_image',
        'page_view',
        'page_date',
        'page_type',
        'page_status',
        'page_content_ru',
        'page_content_en'
    ];
}
