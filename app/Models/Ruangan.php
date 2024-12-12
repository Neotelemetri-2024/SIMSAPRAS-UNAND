<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ruangan extends Model
{
    protected $table = 'ruangan';

    protected $fillable = [
        'idGedung', 'nama', 'gambar', 'deskripsi', 'kapasitas'
    ];

    public function gedung()
    {
        return $this->belongsTo(Gedung::class, 'idGedung');
    }

    public function peminjamans()
    {
        return $this->hasMany(Peminjaman::class, 'idRuangan');
    }
}