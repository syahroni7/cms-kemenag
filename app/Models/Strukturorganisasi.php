<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Strukturorganisasi extends Model
{
    protected $fillable = [
        'nama',
        'jabatan',
        'foto',
        'parent_id',
        'tipe'
    ];

    public function children()
    {
        return $this->hasMany(Strukturorganisasi::class, 'parent_id');
    }

    public function parent()
    {
        return $this->belongsTo(Strukturorganisasi::class, 'parent_id');
    }
}
