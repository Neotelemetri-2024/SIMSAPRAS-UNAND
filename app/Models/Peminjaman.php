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
        'alasanPembatalan',
        'alasanTolakBatal',
        'buktiPembayaran',
        'statusSebelumBatal'
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

    public function canBeCancelled()
    {
        // 1. Cek status peminjaman
        $validStatus = in_array($this->status, ['diajukan', 'disetujui']);

        if (!$validStatus) {
            return false;
        }

        // 2. Ambil tanggal peminjaman paling awal
        $earliestBookingDate = $this->tanggalPeminjaman()
            ->min('tanggal');

        if (!$earliestBookingDate) {
            return false;
        }

        // 3. Convert ke Carbon untuk manipulasi tanggal
        $bookingDate = \Carbon\Carbon::parse($earliestBookingDate)->startOfDay();
        $today = now()->startOfDay();
        
        // 4. Hitung selisih hari
        $daysDifference = $bookingDate->diffInDays($today);

        // 5. Pembatalan hanya bisa dilakukan jika masih ada waktu >= 3 hari sebelum tanggal booking
        return $daysDifference >= 3 && $bookingDate->greaterThan($today);
    }
}