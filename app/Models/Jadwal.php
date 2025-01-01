<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    protected $fillable = [
        'shift',
        'mulai',
        'selesai',
        'status',
    ];
    protected $table = 'jadwal';

    public function tanggalPeminjaman()
    {
        return $this->hasMany(TanggalPeminjaman::class, 'idJadwal');
    }
    
}