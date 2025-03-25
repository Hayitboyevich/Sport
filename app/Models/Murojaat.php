<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Murojaat extends Model
{

    protected $primaryKey = 'murojaat_id';
    protected $fillable = [
        'f_i_sh',
        'birth_day',
        'email',
        'type',
        'phone_number',
        'murojaat_text',
        'offerta',
        'status',
        'answered_user',
        'answered_date',
        'answered_text',
        'answered_file',
        'a_number'
    ];
}
