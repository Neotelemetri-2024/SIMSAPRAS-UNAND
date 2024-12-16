<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    use HasFactory;
     protected $table = 'jadwal';
     protected $fillable = [
        'shift',
        'mulai',
        'selesai',
    ];

    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class, 'idJadwal');
    }
}