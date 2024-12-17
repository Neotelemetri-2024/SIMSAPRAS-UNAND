<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    use HasFactory;
    protected $table = 'peminjaman';
    protected $fillable = [
        'idUser',
        'idRuangan',
        'idTanggal',
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
        'feedbackPembatalan',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'idUser');
    }

    public function ruangan()
    {
        return $this->belongsTo(Ruangan::class, 'idRuangan');
    }

    public function tanggalPeminjaman()
    {
        return $this->belongsTo(TanggalPeminjaman::class, 'idTanggal');
    }

    public function jadwal()
    {
        return $this->belongsTo(Jadwal::class, 'idJadwal');
    }

    public function sarana()
    {
        return $this->belongsTo(Sarana::class, 'idSarana');
    }
}
