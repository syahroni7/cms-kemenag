<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $fillable = [
        'name', 'icon', 'url', 'parent_id', 'order'
    ];

    public function parent()
    {
        return $this->belongsTo(Menu::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Menu::class, 'parent_id')->orderBy('order');
    }

    // Normalisasi URL (menghilangkan slash depan)
    public function getNormalizedUrlAttribute()
    {
        return ltrim($this->url, '/');
    }
}
