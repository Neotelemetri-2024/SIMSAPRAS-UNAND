<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peminjaman;
use App\Models\Jadwal;
use App\Models\Ruangan;
use App\Models\User;
use App\Models\Notifikasi;
use App\Models\TanggalPeminjaman;
use App\Models\Sarana;
use App\Services\NotificationService;
use Carbon\Carbon;
use App\Models\FacilityUsage;
use App\Services\HolidayService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;


class PeminjamanController extends Controller
{
    protected $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    public function create(Request $request)
    {
        if (!$request->has('sarana_id') && !$request->has('ruangan_id')) {
            return redirect()
                ->back()
                ->with('error', 'Data tidak lengkap');
        }
    
        $selectedDates = $request->selected_dates;
        $jadwals = Jadwal::where('status', 'aktif')->get();
        $bookedJadwals = $this->getBookedJadwals($request->selected_dates, $request->ruangan_id ?? null, $request->sarana_id ?? null);
        
        // Ambil data tanggal merah
        $holidayService = new HolidayService();
        $holidayDates = $holidayService->getHolidayDates();
        
        // Hitung jam lembur berdasarkan bulan dari tanggal yang dipilih
        $dates = json_decode($selectedDates);
        $uniqueMonths = collect($dates)->map(function($date) {
            return Carbon::parse($date)->format('Y-m');
        })->unique()->values();
        
        $jamLemburPerBulan = [];
        foreach ($uniqueMonths as $month) {
            $monthName = Carbon::createFromFormat('Y-m', $month)->translatedFormat('F Y');
            $jamLemburPerBulan[$month] = [
                'month_name' => $monthName,
                'hours' => 0
            ];
        }
        
        if ($request->has('ruangan_id')) {
            $ruangan = Ruangan::with('sarana')->findOrFail($request->ruangan_id);
            $sarana = $ruangan->sarana;
            
            // Hitung jam lembur untuk setiap bulan yang dipilih
            foreach ($uniqueMonths as $month) {
                $jamLemburPerBulan[$month]['hours'] = $this->calculateOvertimeHours($sarana->id, $month, $ruangan->id);
            }
            
            if ($ruangan->kelas) {
                session()->flash('warning', 'Ruangan ini merupakan ruangan kelas yang hanya dapat dipinjam pada hari Sabtu dan Minggu.');
            }
            return view('peminjaman', compact('sarana', 'ruangan', 'selectedDates', 'jadwals', 'bookedJadwals', 'jamLemburPerBulan', 'holidayDates'));
        }
    
        $sarana = Sarana::findOrFail($request->sarana_id);
        
        // Hitung jam lembur untuk setiap bulan yang dipilih
        foreach ($uniqueMonths as $month) {
            $jamLemburPerBulan[$month]['hours'] = $this->calculateOvertimeHours($sarana->id, $month);
        }

        $user = User::find(auth()->id());

        if ($sarana->requiresFaculty && (!$user || !$user->isFacultyUser())) {
            return redirect()->route('home')->with('error', 'Sarana ini hanya dapat diakses oleh pengguna dari fakultas.');
        }

        return view('peminjaman', compact('sarana', 'selectedDates', 'jadwals', 'bookedJadwals', 'jamLemburPerBulan', 'holidayDates'));
    }

    private function getBookedJadwals($selectedDates, $ruanganId = null, $saranaId = null)
    {
        $dates = json_decode($selectedDates);
        $bookedJadwals = [];

        foreach ($dates as $date) {
            $query = TanggalPeminjaman::whereDate('tanggal', $date)
                ->whereHas('peminjaman', function ($q) use ($ruanganId, $saranaId) {
                    $q->whereIn('status', ['diajukan', 'diproses', 'disetujui', 'diajukanbatal']);
                    
                    if ($ruanganId) {
                        $q->where('idRuangan', $ruanganId);
                    }
                    if ($saranaId) {
                        $q->where('idSarana', $saranaId);
                    }
                });

            $bookedJadwals[$date] = $query->pluck('idJadwal')->toArray();
        }

        return $bookedJadwals;
    }

    /**
     * Hitung jam lembur berdasarkan peminjaman aktif
     */
    private function calculateOvertimeHours($saranaId, $bulanFilter = null, $ruanganId = null)
    {
        $query = Peminjaman::with(['tanggalPeminjaman.jadwal'])
            ->where('idSarana', $saranaId)
            ->whereIn('status', ['diajukan', 'diproses', 'disetujui', 'diajukanbatal'])
            ->where('instansi', '!=', 'Superadmin SIMSAPRAS');
            
        if ($ruanganId) {
            $query->where('idRuangan', $ruanganId);
        }
        
        if ($bulanFilter) {
            $query->whereHas('tanggalPeminjaman', function($q) use ($bulanFilter) {
                $q->whereRaw("DATE_FORMAT(tanggal, '%Y-%m') = ?", [$bulanFilter]);
            });
        }
        
        $peminjamans = $query->get();
        $totalJamLembur = 0;
        $holidayService = new HolidayService();
        
        foreach ($peminjamans as $peminjaman) {
            foreach ($peminjaman->tanggalPeminjaman as $tanggalPeminjaman) {
                if ($bulanFilter && Carbon::parse($tanggalPeminjaman->tanggal)->format('Y-m') !== $bulanFilter) {
                    continue;
                }
                
                $jadwal = $tanggalPeminjaman->jadwal;
                if (!$jadwal) continue;
                
                $date = Carbon::parse($tanggalPeminjaman->tanggal);
                $start = Carbon::createFromFormat('H:i:s', $jadwal->mulai);
                $endTime = Carbon::createFromFormat('H:i:s', $jadwal->selesai);
                $hours = $endTime->diffInHours($start);
                
                $isWeekendOrHoliday = $holidayService->isWeekendOrHoliday($date);
                $isAfterHours = $start->hour >= 16 || $endTime->hour >= 16;
                
                // Hanya hitung jam lembur (weekend/tanggal merah atau after hours)
                if ($isWeekendOrHoliday || $isAfterHours) {
                    $chargeableHours = $hours;
                    
                    // Jika bukan weekend/tanggal merah tapi after hours, hitung hanya bagian setelah jam 16:00
                    if (!$isWeekendOrHoliday && $isAfterHours && $start->hour < 16) {
                        $cutoffTime = Carbon::createFromFormat('H:i:s', '16:00:00');
                        $chargeableHours = $endTime->diffInHours($cutoffTime);
                    }
                    
                    $totalJamLembur += $chargeableHours;
                }
            }
        }
        
        return $totalJamLembur;
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $validationRules = [
                'idSarana' => 'required|exists:sarana,id',
                'jadwal_dates' => 'required|array',
                'jadwal_dates.*.date' => 'required|date',
                'jadwal_dates.*.jadwal_id' => 'required|exists:jadwal,id',
                'kegiatan' => 'required|string|max:255',
                'suratPeminjaman' => 'required|file|mimes:pdf,doc,docx|max:2048',
                'rundown' => 'required|file|mimes:pdf,doc,docx|max:2048',
                'instansi' => 'required|string|max:255',
                'estimasiPeserta' => 'required|integer|min:1',
                'statusPeminjam' => 'required|in:unit,ormawa,umum',
            ];

            if ($request->has('idRuangan')) {
                $validationRules['idRuangan'] = 'required|exists:ruangan,id';
                $ruangan = Ruangan::find($request->idRuangan);
                
                if ($request->estimasiPeserta > $ruangan->kapasitas) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Jumlah peserta melebihi kapasitas ruangan'
                    ], 422);
                }

                if ($ruangan->kelas) {
                    $nonWeekendDates = collect($request->jadwal_dates)->filter(function ($booking) {
                        $date = new \Carbon\Carbon($booking['date']);
                        return !$date->isWeekend();
                    });

                    if ($nonWeekendDates->isNotEmpty()) {
                        return response()->json([
                            'success' => false,
                            'message' => 'Ruangan kelas hanya dapat dipinjam pada hari Sabtu dan Minggu'
                        ], 422);
                    }
                }
            }

            $validated = $request->validate($validationRules);

            // Validasi status peminjam berdasarkan role user
            $user = auth()->user();
            if ($validated['statusPeminjam'] === 'unit' && !$user->isFakultas) {
                return response()->json([
                    'success' => false,
                    'message' => 'Status peminjam "Fakultas/Unit" hanya dapat dipilih oleh akun fakultas/unit. Silakan gunakan akun fakultas/unit yang sesuai atau pilih status peminjam lainnya.'
                ], 422);
            }

            // CEK OVERLAP JADWAL
            foreach ($validated['jadwal_dates'] as $booking) {
                $date = $booking['date'];
                $jadwalBaru = Jadwal::findOrFail($booking['jadwal_id']);
                $mulaiBaru = $jadwalBaru->mulai;
                $selesaiBaru = $jadwalBaru->selesai;

                $query = TanggalPeminjaman::where('tanggal', $date)
                    ->whereHas('peminjaman', function ($q) use ($request) {
                        $q->whereIn('status', ['diajukan', 'diproses', 'disetujui', 'diajukanbatal']);
                        if ($request->has('idRuangan')) {
                            $q->where('idRuangan', $request->idRuangan);
                        } else {
                            $q->where('idSarana', $request->idSarana);
                        }
                    })
                    ->with('jadwal');

                $tanggalBentrok = $query->get();
                foreach ($tanggalBentrok as $tb) {
                    $jadwalLama = $tb->jadwal;
                    if (!$jadwalLama) continue;
                    // Cek overlap waktu
                    if ($mulaiBaru < $jadwalLama->selesai && $selesaiBaru > $jadwalLama->mulai) {
                        return response()->json([
                            'success' => false,
                            'message' => 'Terdapat jadwal yang bentrok/overlap pada tanggal ' . $date . ' (' . $jadwalBaru->mulai . ' - ' . $jadwalBaru->selesai . '). Silakan pilih jadwal lain.'
                        ], 422);
                    }
                }
            }

            // Validasi akses fakultas
            $saranaId = $validated['idSarana'] ?? null;
            $user = User::find(auth()->id());
    
            if ($saranaId) {
                $sarana = Sarana::findOrFail($saranaId);
                
                if ($sarana->requiresFaculty && (!$user || !$user->isFacultyUser())) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Sarana ini hanya dapat diakses oleh pengguna dari fakultas.'
                    ], 403);
                }
            }

            // Upload file
            $suratPath = $request->file('suratPeminjaman')->store('peminjaman/surat', 'public');
            $rundownPath = $request->file('rundown')->store('peminjaman/rundown', 'public');

            $sarana = Sarana::find($validated['idSarana']);
            $ruangan = isset($validated['idRuangan']) ? Ruangan::find($validated['idRuangan']) : null;
            $targetSarana = $ruangan ? $ruangan->sarana : $sarana;
            
            // Ambil bulan dari tanggal peminjaman yang diajukan
            $bookingMonths = collect($validated['jadwal_dates'])->map(function($booking) {
                return Carbon::parse($booking['date'])->format('Y-m');
            })->unique();

            // Hitung jam terpakai per bulan berdasarkan peminjaman aktif
            $monthlyUsage = [];
            foreach ($bookingMonths as $yearMonth) {
                // Hitung jam yang sudah terpakai di bulan tersebut dari peminjaman aktif
                $usedHours = $this->calculateOvertimeHours($targetSarana->id, $yearMonth);
                
                // Hitung jam yang akan digunakan di bulan tersebut dari peminjaman saat ini
                $requestedHours = 0;
                $holidayService = new HolidayService();
                foreach ($validated['jadwal_dates'] as $booking) {
                    $date = Carbon::parse($booking['date']);
                    if ($date->format('Y-m') == $yearMonth) {
                        $jadwal = Jadwal::findOrFail($booking['jadwal_id']);
                        $start = Carbon::createFromFormat('H:i:s', $jadwal->mulai);
                        $endTime = Carbon::createFromFormat('H:i:s', $jadwal->selesai);
                        $hours = $endTime->diffInHours($start);
                        
                        $isWeekendOrHoliday = $holidayService->isWeekendOrHoliday($date);
                        $isAfterHours = $start->hour > 16 || ($start->hour == 16 && $start->minute > 0) || 
                                    $endTime->hour > 16 || ($endTime->hour == 16 && $endTime->minute > 0);
                        
                        if ($isWeekendOrHoliday || $isAfterHours) {
                            $chargeableHours = $hours;
                            
                            if (!$isWeekendOrHoliday && $isAfterHours && $start->hour < 16) {
                                $cutoffTime = Carbon::createFromFormat('H:i:s', '16:00:00');
                                $chargeableHours = $endTime->diffInHours($cutoffTime);
                            }
                            
                            $requestedHours += $chargeableHours;
                        }
                    }
                }
                
                $monthlyUsage[$yearMonth] = [
                    'used' => $usedHours,
                    'requested' => $requestedHours,
                    'total' => $usedHours + $requestedHours
                ];
            }

            // Periksa apakah ada bulan yang melebihi batas 40 jam
            $overLimitMonth = null;
            foreach ($monthlyUsage as $yearMonth => $usage) {
                if ($usage['total'] > 40) {
                    $overLimitMonth = $yearMonth;
                    break;
                }
            }

            if ($overLimitMonth) {
                $month = Carbon::createFromFormat('Y-m', $overLimitMonth)->format('F Y');
                DB::rollBack();
                return response()->json([
                    'success' => false,
                    'message' => "Batas penggunaan 40 jam untuk bulan {$month} akan terlampaui. Saat ini telah terpakai {$monthlyUsage[$overLimitMonth]['used']} jam, dan Anda meminta tambahan {$monthlyUsage[$overLimitMonth]['requested']} jam."
                ], 422);
            }
            
            $totalTarif = Peminjaman::calculateTarif(
                $validated['jadwal_dates'],
                $validated['statusPeminjam'],
                $sarana,
                $ruangan
            );

            $peminjamanData = [
                'idUser' => auth()->id(),
                'idSarana' => $validated['idSarana'],
                'kegiatan' => $validated['kegiatan'],
                'suratPeminjaman' => $suratPath,
                'rundown' => $rundownPath,
                'instansi' => $validated['instansi'],
                'estimasiPeserta' => $validated['estimasiPeserta'],
                'status' => 'diajukan',
                'statusPeminjam' => $validated['statusPeminjam'],
                'totalTarif' => $totalTarif
            ];

            if ($request->has('idRuangan')) {
                $peminjamanData['idRuangan'] = $validated['idRuangan'];
            }

            $peminjaman = Peminjaman::create($peminjamanData);

            // Buat record tanggal peminjaman
            foreach ($validated['jadwal_dates'] as $booking) {
                $date = Carbon::parse($booking['date']);
                
                TanggalPeminjaman::create([
                    'idPeminjaman' => $peminjaman->id,
                    'idJadwal' => $booking['jadwal_id'],
                    'tanggal' => $date->format('Y-m-d')
                ]);
            }
                
            // Buat notifikasi untuk admin
            $adminNotifications = User::whereIn('role', ['admin', 'superadmin', 'pimpinan'])
                ->get()
                ->map(function ($admin) use ($peminjaman) {
                    return [
                        'idPeminjaman' => $peminjaman->id,
                        'penerima' => $admin->id,
                        'judul' => 'Peminjaman Baru',
                        'isi' => "Peminjaman " . ($peminjaman->ruangan ? $peminjaman->ruangan->nama : $peminjaman->sarana->nama) . " dari " . auth()->user()->name . " untuk kegiatan " . $peminjaman->kegiatan,
                        'isRead' => false,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                })
                ->toArray();

            Notifikasi::insert($adminNotifications);

            $this->notificationService->sendToAll(
                'Peminjaman Baru',
                "Peminjaman " . ($peminjaman->ruangan ? $peminjaman->ruangan->nama : $peminjaman->sarana->nama) . " dari " . auth()->user()->name . " untuk kegiatan " . $peminjaman->kegiatan
            );

            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Pengajuan peminjaman berhasil dikirim',
                'redirect' => route('riwayat.index'),
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Tangkap error validasi dan kirim response JSON agar bisa ditangkap SweetAlert
            return response()->json([
                'success' => false,
                'message' => $e->validator->errors()->first(),
                'errors' => $e->validator->errors(),
            ], 422);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(
                [
                    'success' => false,
                    'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
                ],
                500
            );
        }
    }
    
    // public function show(Peminjaman $peminjaman)
    // {
    //     $peminjaman->load(['sarana', 'ruangan', 'jadwal', 'tanggalPeminjaman', 'user']);

    //     return view('peminjaman.show', compact('peminjaman'));
    // }

    // public function index()
    // {
    //     $peminjamans = Peminjaman::with(['sarana', 'ruangan', 'jadwal'])
    //         ->where('idUser', auth()->id())
    //         ->latest()
    //         ->paginate(10);

    //     return view('peminjaman.index', compact('peminjamans'));
    // }

    public function cancel(Peminjaman $peminjaman, Request $request)
    {
        if ($peminjaman->idUser !== auth()->id()) {
            return back()->with('error', 'Anda tidak memiliki akses untuk membatalkan peminjaman ini');
        }
        
        if (!in_array($peminjaman->status, ['diajukan', 'diproses', 'disetujui'])) {
            return back()->with('error', 'Status peminjaman tidak dapat dibatalkan');
        }
        
        $earliestBookingDate = $peminjaman->tanggalPeminjaman->min('tanggal');
        if ($earliestBookingDate <= now()->addDays(3)->format('Y-m-d')) {
            return back()->with('error', 'Peminjaman hanya dapat dibatalkan maksimal 3 hari sebelum tanggal peminjaman');
        }
        
        $validator = Validator::make($request->all(), [
            'alasan_pembatalan' => 'required|string|min:10',
        ], [
            'alasan_pembatalan.required' => 'Alasan pembatalan wajib diisi',
            'alasan_pembatalan.min' => 'Alasan pembatalan minimal 10 karakter'
        ]);
        
        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput()
                ->with('modal_open', $peminjaman->id);
        }
        
        try {
            $peminjaman->statusSebelumBatal = $peminjaman->status;
            $peminjaman->update([
                'status' => 'diajukanbatal',
                'alasanPembatalan' => $request->alasan_pembatalan
            ]);
            
            $fasilitasNama = $peminjaman->ruangan ? $peminjaman->ruangan->nama : $peminjaman->sarana->nama;
            
            $adminNotifications = User::whereIn('role', ['admin', 'superadmin', 'pimpinan'])
                ->get()
                ->map(function ($admin) use ($peminjaman, $fasilitasNama) {
                    return [
                        'idPeminjaman' => $peminjaman->id,
                        'penerima' => $admin->id,
                        'judul' => 'Pengajuan Pembatalan',
                        'isi' => "Pengajuan pembatalan {$fasilitasNama} dari " . auth()->user()->name . " untuk kegiatan " . $peminjaman->kegiatan,
                        'isRead' => false,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                })
                ->toArray();
                
            Notifikasi::insert($adminNotifications);
            
            return redirect()
                ->route('riwayat.index')
                ->with('success', "Pengajuan pembatalan {$fasilitasNama} berhasil dilakukan");
        } catch (\Exception $e) {
                       
            return back()
                ->with('error', 'Terjadi kesalahan saat membatalkan peminjaman')
                ->with('modal_open', $peminjaman->id);
        }
    }
}