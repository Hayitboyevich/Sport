<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
        "status",
        "parent_id"
    ];

    public function submenus(): HasMany
    {
        return $this->hasMany(SubMenu::class, 'parent_id', 'sub_menu_id');
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(SubMenu::class, 'parent_id', 'sub_menu_id');
    }

}
