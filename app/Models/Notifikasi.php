<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notifikasi extends Model
{
    protected $fillable = [
        'idPeminjaman',
        'penerima',
        'judul',
        'isi',
        'isRead'
    ];
    protected $table = 'notifikasi';

    public function peminjaman()
    {
        return $this->belongsTo(Peminjaman::class, 'idPeminjaman');
    }

    public function penerima()
    {
        return $this->belongsTo(User::class, 'penerima');
    }
}