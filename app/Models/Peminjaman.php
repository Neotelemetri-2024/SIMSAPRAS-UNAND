<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    protected $table = 'peminjaman';

    protected $fillable = [
        'idUser',
        'idRuangan', 
        'idSarana',
        'kegiatan',
        'suratPeminjaman',
        'rundown',
        'instansi',
        'estimasiPeserta',
        'tarif',
        'feedbackPenolakan',
        'evaluasi',
        'status',
        'statusPembayaran',
        'statusPengembalian',
        'feedbackPembatalan',
        'buktiPembayaran'
    ];

    protected $enums = [
        'status' => ['diajukan', 'ditolak', 'diproses', 'disetujui', 'dibatalkan', 'diajukanbatal'],
        'statusPembayaran' => ['lunas', 'tidak'],
        'statusPengembalian' => ['sudah', 'belum']
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'idUser');
    }

    public function ruangan()
    {
        return $this->belongsTo(Ruangan::class, 'idRuangan');
    }

    public function sarana()
    {
        return $this->belongsTo(Sarana::class, 'idSarana');
    }

 public function tanggalPeminjaman()
    {
        return $this->hasMany(TanggalPeminjaman::class, 'idPeminjaman');
    }

    public function notifikasi()
    {
        return $this->hasMany(Notifikasi::class, 'idPeminjaman');
    }
}