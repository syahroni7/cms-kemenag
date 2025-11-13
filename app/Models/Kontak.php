<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kontak extends Model
{
    use HasFactory;

    // Tambahkan baris ini agar Laravel tahu tabelnya 'kontak'
    protected $table = 'kontak';

    protected $fillable = [
        'nama_kantor',
        'alamat',
        'telepon',
        'email',
        'jam_operasional'
    ];
}
