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

    public function jadwal()
    {
        return $this->hasMany(Peminjaman::class);
    }
    
}