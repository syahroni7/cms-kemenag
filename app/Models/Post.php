<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    // Jika tabel yang digunakan bukan 'posts' (misalnya 'artikel')
    protected $table = 'posts';

    // Definisikan kolom yang dapat diisi secara massal (fillable)
    protected $fillable = [
        'title', 'content', 'status', 'is_slider', 'published_at'
    ];

    // Atau jika Anda menggunakan timestamps
    public $timestamps = true;
}
