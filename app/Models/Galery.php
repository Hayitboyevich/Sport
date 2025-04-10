<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Galery extends Model
{
    protected $guarded = false;

    public function images(): MorphMany
    {
        return $this->morphMany(Image::class, 'imageable');
    }
}
