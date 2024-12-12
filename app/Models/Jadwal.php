<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    protected $table = 'jadwal';

    protected $fillable = [
        'shift', 'mulai', 'selesai'
    ];

    protected $casts = [
        'mulai' => 'datetime',
        'selesai' => 'datetime'
    ];

    public function peminjamans()
    {
        return $this->hasMany(Peminjaman::class, 'idJadwal');
    }
}