<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccessType extends Model
{
    protected $table = 'access_type';

    protected $fillable = [
        'code',
        'name',
        'description',
    ];

    public $timestamps = false; // kalau tabel tidak punya created_at / updated_at
}
