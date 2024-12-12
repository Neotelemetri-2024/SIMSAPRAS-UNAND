<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TanggalPeminjaman extends Model
{
    protected $table = 'tanggalPeminjaman';

    protected $fillable = [
        'tanggal'
    ];

    protected $casts = [
        'tanggal' => 'date'
    ];

    public function peminjamans()
    {
        return $this->hasMany(Peminjaman::class, 'idTanggal');
    }
}