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
        'idJadwal',
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
        'feedbackPembatalan'
    ];

    protected $enums = [
        'status' => ['diajukan', 'ditolak', 'diproses', 'disetujui']
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'idUser');
    }

    public function ruangan()
    {
        return $this->belongsTo(Ruangan::class, 'idRuangan');
    }

    public function jadwal()
    {
        return $this->belongsTo(Jadwal::class, 'idJadwal');
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

