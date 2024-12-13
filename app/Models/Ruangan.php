<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ruangan extends Model
{
    use HasFactory;
     protected $fillable = [
        'idSarana',
        'nama',
        'gambar',
        'deskripsi',
        'kapasitas',
    ];

    public function sarana()
    {
        return $this->belongsTo(Sarana::class, 'idSarana');
    }

    public function gambarRuangan()
    {
        return $this->hasMany(GambarRuangan::class, 'idRuangan');
    }

    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class, 'idRuangan');
    }
}
