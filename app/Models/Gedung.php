<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gedung extends Model
{
    protected $table = 'gedung';

    protected $fillable = [
        'nama', 'gambar', 'deskripsi'
    ];

    public function ruangans()
    {
        return $this->hasMany(Ruangan::class, 'idGedung');
    }
}