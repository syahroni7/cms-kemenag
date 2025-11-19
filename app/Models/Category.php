<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    // Nama tabel (opsional, karena Laravel otomatis pakai plural)
    protected $table = 'categories';

    // Kolom yang boleh diisi
    protected $fillable = [
        'name',
    ];

    // Relasi jika suatu Category punya banyak Post (opsional)
    // Sesuaikan jika model Post Anda nanti punya category_id
    public function posts()
    {
        return $this->hasMany(Post::class);
    }
}
