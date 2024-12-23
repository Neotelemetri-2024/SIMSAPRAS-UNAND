<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TanggalPeminjaman extends Model
{
    protected $table = 'tanggalpeminjaman';
    
    protected $fillable = [
        'idPeminjaman',
        'idJadwal',
        'tanggal'
    ];

    public function peminjaman()
    {
        return $this->belongsTo(Peminjaman::class, 'idPeminjaman');
    }
    public function jadwal()
    {
        return $this->belongsTo(Jadwal::class, 'idJadwal');
    }
}