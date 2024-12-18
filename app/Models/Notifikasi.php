<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notifikasi extends Model
{
    protected $fillable = [
        'idPeminjaman',
        'judul',
        'isi',
        'isRead'
    ];
    protected $table = 'notifikasi';

    public function peminjaman()
    {
        return $this->belongsTo(Peminjaman::class, 'idPeminjaman');
    }
}