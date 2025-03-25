<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $primaryKey = 'post_id';
    protected $fillable = [
        "post_menu_id",
        "post_title",
        "post_slug",
        "post_image",
        "post_desc",
        "post_content",
        "post_date",
        "post_type",
        "post_status",
        "post_view",
        "post_title_ru",
        "post_title_en",
        "post_desc_ru",
        "post_desc_en",
        "post_content_ru",
        "post_content_en"
    ];
}
