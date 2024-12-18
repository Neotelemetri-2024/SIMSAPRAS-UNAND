<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TanggalPeminjaman extends Model
{
    use HasFactory;
    protected $table = 'tanggal_peminjaman';
     protected $fillable = [
        'tanggal',
    ];

    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class, 'idTanggal');
    }
}
