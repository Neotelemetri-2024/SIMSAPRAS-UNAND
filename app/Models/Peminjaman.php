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
        'totalTarif',
        'isUnand',
        'feedbackPenolakan',
        'evaluasi',
        'status',
        'disetujui_oleh',
        'diproses_oleh',
        'ditolak_oleh',
        'dibatalkan_oleh',
        'statusPembayaran',
        'statusPengembalian',
        'feedbackPembatalan',
        'alasanPembatalan',
        'alasanTolakBatal',
        'buktiPembayaran',
        'statusSebelumBatal',
        'buktifRefund',
        'disetujui_at',
        'diproses_at',
        'ditolak_at',
        'dibatalkan_at'
    ];
     protected $dates = [
        'disetujui_at',
        'diproses_at',
        'ditolak_at',
        'dibatalkan_at'
    ];

    protected $enums = [
        'status' => ['diajukan', 'ditolak', 'diproses', 'disetujui', 'dibatalkan', 'diajukanbatal', 'selesai'],
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

    // Tambahkan relasi untuk user yang melakukan aksi
    public function disetujuiOleh()
    {
        return $this->belongsTo(User::class, 'disetujui_oleh');
    }
    
    public function ditolakOleh()
    {
        return $this->belongsTo(User::class, 'ditolak_oleh');
    }
    
    public function dibatalkanOleh()
    {
        return $this->belongsTo(User::class, 'dibatalkan_oleh');
    }
       public function diprosesOleh()
    {
        return $this->belongsTo(User::class, 'diproses_oleh');
    }

    public function canBeCancelled()
    {
        // 1. Cek status peminjaman
        $validStatus = in_array($this->status, ['diajukan', 'disetujui', 'diproses']);

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
    public static function calculateTarif($jadwal_dates, $isUnand, $sarana = null, $ruangan = null)
    {
        $totalTarif = 0;
        
        foreach ($jadwal_dates as $booking) {
            $date = $booking['date'];
            $jadwalId = $booking['jadwal_id'];
            
            $jadwal = Jadwal::find($jadwalId);
            $jamSelesai = (int)explode(':', $jadwal->selesai)[0];
            
            // Check if weekend
            $isWeekend = in_array(date('N', strtotime($date)), [6, 7]);
            
            // Check if extends beyond 4 PM (16:00)
            $isAfterHours = $jamSelesai >= 16;
            
            if ($isWeekend || $isAfterHours) {
                // Get appropriate tariff based on facility type and user type
                if ($ruangan) {
                    $tarif = $isUnand ? $ruangan->tarifunand : $ruangan->tarifumum;
                } else {
                    $tarif = $isUnand ? $sarana->tarifunand : $sarana->tarifumum;
                }
                
                $totalTarif += $tarif;
            }
        }
        
        return $totalTarif;
    }
}