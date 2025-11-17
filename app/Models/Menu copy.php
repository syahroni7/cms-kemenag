<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'icon', 'url', 'parent_id', 'order'];

    // Relasi: menu punya anak → cucu → cicit (rekursif)
    public function children()
    {
        return $this->hasMany(Menu::class, 'parent_id')
                    ->orderBy('order')
                    ->with('children');
    }

    // Relasi ke parent
    public function parent()
    {
        return $this->belongsTo(Menu::class, 'parent_id');
    }
}
