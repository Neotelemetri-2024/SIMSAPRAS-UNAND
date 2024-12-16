<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sarana extends Model
{
    use HasFactory;
      protected $table = 'sarana';

    protected $fillable = [
        'IdKategori',
        'gambar',
        'deskripsi',
        'nama',
        'fasilitas'
    ];

    public function kategoriSarana()
    {
        return $this->belongsTo(KategoriSarana::class, 'IdKategori');
    }

    public function ruangan()
    {
        return $this->hasMany(Ruangan::class, 'idSarana');
    }
}
