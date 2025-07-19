<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\FiltersSaranaAccess;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class Peminjaman extends Model
{
    use FiltersSaranaAccess;
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
        'statusPeminjam',
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
        'suratDisposisi',
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
        'statusPeminjam' => ['unit', 'ormawa', 'umum'],
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
        $validStatus = in_array($this->status, ['diajukan', 'disetujui', 'diproses']);

        if (!$validStatus) {
            return false;
        }

        $earliestBookingDate = $this->tanggalPeminjaman()
            ->min('tanggal');

        if (!$earliestBookingDate) {
            return false;
        }

        $bookingDate = \Carbon\Carbon::parse($earliestBookingDate)->startOfDay();
        $today = now()->startOfDay();
        
        $daysDifference = $bookingDate->diffInDays($today);

        return $daysDifference >= 3 && $bookingDate->greaterThan($today);
    }

    public static function calculateTarif($jadwal_dates, $statusPeminjam, $sarana = null, $ruangan = null)
    {
        $totalTarif = 0;
        
        $targetEntity = $ruangan ?? $sarana;
        $totalHours = 0;
        $hasChargeableHours = false; 
        
        if ($targetEntity->is_hourly_rate) {
            foreach ($jadwal_dates as $booking) {
                $jadwal = Jadwal::find($booking['jadwal_id']);
                $date = Carbon::parse($booking['date']);
                $endTime = Carbon::createFromFormat('H:i:s', $jadwal->selesai);
                $start = Carbon::createFromFormat('H:i:s', $jadwal->mulai);
                $hours = $endTime->diffInHours($start);
                $totalHours += $hours;
                
                $isWeekend = $date->isWeekend();
                $isAfterHours = $start->hour > 16 || ($start->hour == 16 && $start->minute > 0) || $endTime->hour > 16 || ($endTime->hour == 16 && $endTime->minute > 0);
                $isChargeableTime = $isWeekend || $isAfterHours;
                
                if ($isChargeableTime) {
                    $hasChargeableHours = true;
                    
                    $chargeableHours = $hours;
                    
                    if (!$isWeekend && $isAfterHours && $start->hour < 16) {
                        $cutoffTime = Carbon::createFromFormat('H:i:s', '16:00:00');
                        $chargeableHours = $endTime->diffInHours($cutoffTime);
                    }
                }
                
                $isWeekday = !$date->isWeekend();
                $isBeforeFourPM = $start->hour <= 16 && $endTime->hour <= 16;
                $isFreeTimeSlot = $isWeekday && $isBeforeFourPM && $statusPeminjam !== 'umum';
                
                if (!$isFreeTimeSlot) {
                    $baseRate = match($statusPeminjam) {
                        'ormawa' => $targetEntity->tariformawa,
                        'unit' => $targetEntity->tarifunit,
                        default => $targetEntity->tarifumum
                    };
                    
                    $hoursPerUnit = $targetEntity->hours_per_unit ?? 1; 
                    $units = ceil($hours / $hoursPerUnit);
                    
                    $bookingTarif = $baseRate * $units;
                    $totalTarif += $bookingTarif;
                }
            }
        }
        else {
            $bookingsByDate = [];
            foreach ($jadwal_dates as $booking) {
                $date = Carbon::parse($booking['date']);
                $dateStr = $date->format('Y-m-d');
                $jadwal = Jadwal::find($booking['jadwal_id']);
                $start = Carbon::createFromFormat('H:i:s', $jadwal->mulai);
                $endTime = Carbon::createFromFormat('H:i:s', $jadwal->selesai);
                
                if (!isset($bookingsByDate[$dateStr])) {
                    $bookingsByDate[$dateStr] = [
                        'bookings' => [],
                        'date' => $date,
                        'allDuringFreeTime' => true 
                    ];
                }
                
                $isWeekday = !$date->isWeekend();
                $isBeforeFourPM = $start->hour <= 16 && $endTime->hour <= 16;
                $isFreeTimeSlot = $isWeekday && $isBeforeFourPM && $statusPeminjam !== 'umum';
                
                if (!$isFreeTimeSlot) {
                    $bookingsByDate[$dateStr]['allDuringFreeTime'] = false;
                }
                
                $bookingsByDate[$dateStr]['bookings'][] = $booking;
            }
            
            foreach ($bookingsByDate as $dateInfo) {
                if (!$dateInfo['allDuringFreeTime']) {
                    $baseRate = match($statusPeminjam) {
                        'ormawa' => $targetEntity->tariformawa,
                        'unit' => $targetEntity->tarifunit,
                        default => $targetEntity->tarifumum
                    };
                    
                    $totalTarif += $baseRate;
                }
                
                foreach ($dateInfo['bookings'] as $booking) {
                    $jadwal = Jadwal::find($booking['jadwal_id']);
                    $endTime = Carbon::createFromFormat('H:i:s', $jadwal->selesai);
                    $start = Carbon::createFromFormat('H:i:s', $jadwal->mulai);
                    $hours = $endTime->diffInHours($start);
                    $totalHours += $hours;
                }
            }
        }
        
        return $totalTarif;
    }
}