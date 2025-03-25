<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $primaryKey = 'member_id';

    protected $fillable = [
        'member_menu_id',
        'member_name',
        'member_photo',
        'member_deputy_name',
        'member_email',
        'member_phone',
        'member_address',
        'member_content',
        'member_bio',
        'member_function',
        'member_type',
        'member_status',
        'member_name_ru',
        'member_name_en',
        'member_deputy_name_ru',
        'member_deputy_name_en',
        'member_address_ru',
        'member_address_en',
        'member_content_ru',
        'member_content_en',
        'member_bio_ru',
        'member_bio_en',
        'member_function_ru',
        'member_function_en',
        "member_kafedra_id"
    ];
}
