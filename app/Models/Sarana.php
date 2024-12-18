<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sarana extends Model
{
    protected $fillable = [
        'IdKategori',
        'gambar',
        'deskripsi',
        'nama',
        'fasilitas'
    ];
    protected $table = 'sarana';

    public function kategoriSarana()
    {
        return $this->belongsTo(KategoriSarana::class, 'IdKategori');
    }

    public function ruangan()
    {
        return $this->hasMany(Ruangan::class);
    }

    public function gambarSarana()
    {
        return $this->hasMany(GambarSarana::class);
    }

    public function penjaga()
    {
        return $this->hasMany(Penjaga::class);
    }

    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class);
    }
}
