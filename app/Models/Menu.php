<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'icon', 'url', 'parent_id', 'order'];

    // Relasi: menu punya banyak anak (submenu)
    public function children()
    {
        return $this->hasMany(Menu::class, 'parent_id')->orderBy('order');
    }

    // Relasi recursive: ambil children + cucu + seterusnya
    public function childrenRecursive()
    {
        return $this->children()->with('childrenRecursive');
    }

    // Relasi ke parent
    public function parent()
    {
        return $this->belongsTo(Menu::class, 'parent_id');
    }
}
