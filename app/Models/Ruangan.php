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
        'fasilitas'
    ];
    protected $table = 'ruangan';

  public function sarana()
{
    return $this->belongsTo(Sarana::class, 'idSarana', 'id');
}

     public function gambarRuangan()
    {
        return $this->hasMany(GambarRuangan::class, 'idRuangan', 'id');
    }

    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class, 'idRuangan', 'id');
    }
}