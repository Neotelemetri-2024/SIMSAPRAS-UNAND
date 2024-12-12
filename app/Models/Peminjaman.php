<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    protected $table = 'peminjaman';

    protected $fillable = [
        'idUser', 'idRuangan', 'idTanggal', 'kegiatan', 'idJadwal', 
        'suratPeminjaman', 'rundown', 'estimasiPeserta', 'tarif', 
        'feedbackPembatalan', 'feedbackPenolakan', 'status', 'evaluasi'
    ];

    protected $casts = [
        'status' => 'string'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'idUser');
    }

    public function ruangan()
    {
        return $this->belongsTo(Ruangan::class, 'idRuangan');
    }

    public function tanggal()
    {
        return $this->belongsTo(TanggalPeminjaman::class, 'idTanggal');
    }

    public function jadwal()
    {
        return $this->belongsTo(Jadwal::class, 'idJadwal');
    }
}