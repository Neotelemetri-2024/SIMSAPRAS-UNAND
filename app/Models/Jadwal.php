<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    protected $fillable = [
        'shift',
        'mulai',
        'selesai'
    ];
    protected $table = 'jadwal';

    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class);
    }
}