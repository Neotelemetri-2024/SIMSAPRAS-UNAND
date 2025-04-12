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
    
        if ($request->has('ruangan_id')) {
            $ruangan = Ruangan::with('sarana')->findOrFail($request->ruangan_id);
            $sarana = $ruangan->sarana;
    
            if ($ruangan->kelas) {
                session()->flash('warning', 'Ruangan ini merupakan ruangan kelas yang hanya dapat dipinjam pada hari Sabtu dan Minggu.');
            }
    
            return view('peminjaman', compact('sarana', 'ruangan', 'selectedDates', 'jadwals', 'bookedJadwals'));
        }
    
        $sarana = Sarana::findOrFail($request->sarana_id);

        $user = User::find(auth()->id());

        if ($sarana->requiresFaculty && (!$user || !$user->isFacultyUser())) {
            return redirect()->route('home')->with('error', 'Sarana ini hanya dapat diakses oleh pengguna dari fakultas.');
        }

        return view('peminjaman', compact('sarana', 'selectedDates', 'jadwals', 'bookedJadwals'));
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

            $suratPath = $request->file('suratPeminjaman')->store('peminjaman/surat', 'public');
            $rundownPath = $request->file('rundown')->store('peminjaman/rundown', 'public');

            $sarana = Sarana::find($validated['idSarana']);
            $ruangan = isset($validated['idRuangan']) ? Ruangan::find($validated['idRuangan']) : null;
            $targetSarana = $ruangan ? $ruangan->sarana : $sarana;
            
            $totalHours = 0;
            $hasChargeableHours = false; 

            foreach ($validated['jadwal_dates'] as $booking) {
                $jadwal = Jadwal::findOrFail($booking['jadwal_id']);
                $date = Carbon::parse($booking['date']);
                $start = Carbon::createFromFormat('H:i:s', $jadwal->mulai);
                $endTime = Carbon::createFromFormat('H:i:s', $jadwal->selesai);
                $hours = $endTime->diffInHours($start);
                
                $isWeekend = $date->isWeekend();
                
                $isAfterHours = $start->hour > 16 || ($start->hour == 16 && $start->minute > 0) || $endTime->hour > 16 || ($endTime->hour == 16 && $endTime->minute > 0);
                 
                if ($isWeekend || $isAfterHours) {
                    $hasChargeableHours = true; 

                    $chargeableHours = $hours;
                    
                    if (!$isWeekend && $isAfterHours && $start->hour < 16) {
                        $cutoffTime = Carbon::createFromFormat('H:i:s', '16:00:00');
                        $chargeableHours = $endTime->diffInHours($cutoffTime);
                    }
                    
                    $totalHours += $chargeableHours;
                } 
            }

            $targetSarana = Sarana::where('id', $targetSarana->id)->lockForUpdate()->first();

            if ($hasChargeableHours && ($targetSarana->bulanan_terpakai + $totalHours) > 40) {
                DB::rollBack();
                return response()->json([
                    'success' => false,
                    'message' => "Batas penggunaan bulanan 40 jam untuk {$targetSarana->nama} telah tercapai. Saat ini telah terpakai {$targetSarana->bulanan_terpakai} jam."
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

            foreach ($validated['jadwal_dates'] as $booking) {
                $jadwal = Jadwal::findOrFail($booking['jadwal_id']);
                $date = Carbon::parse($booking['date']);
                
                $start = Carbon::createFromFormat('H:i:s', $jadwal->mulai);
                $endTime = Carbon::createFromFormat('H:i:s', $jadwal->selesai);
                $hours = $endTime->diffInHours($start);
                
                TanggalPeminjaman::create([
                    'idPeminjaman' => $peminjaman->id,
                    'idJadwal' => $booking['jadwal_id'],
                    'tanggal' => $date->format('Y-m-d')
                ]);
            
                $isWeekend = $date->isWeekend();
                
                $isAfterHours = $start->hour >= 16 || $endTime->hour >= 16;
                
                if ($isWeekend || $isAfterHours) {
                    $chargeableHours = $hours;
                    
                    if (!$isWeekend && $isAfterHours && $start->hour < 16) {
                        $cutoffTime = Carbon::createFromFormat('H:i:s', '16:00:00');
                        $chargeableHours = $endTime->diffInHours($cutoffTime);
                    }
                    
                    if ($chargeableHours > 0) {
                        FacilityUsage::create([
                            'idSarana' => $targetSarana->id,
                            'idRuangan' => $validated['idRuangan'] ?? null,
                            'tanggal' => $date->format('Y-m-d'),
                            'jam_terpakai' => $chargeableHours
                        ]);
                        
                        $targetSarana->increment('bulanan_terpakai', $chargeableHours);
                    }
                }
            }
                
            $targetSarana->refresh();
            if ($targetSarana->bulanan_terpakai >= 40) {
                $targetSarana->update(['status' => 'nonaktif']);
            }

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
    
    public function show(Peminjaman $peminjaman)
    {
        $peminjaman->load(['sarana', 'ruangan', 'jadwal', 'tanggalPeminjaman', 'user']);

        return view('peminjaman.show', compact('peminjaman'));
    }

    public function index()
    {
        $peminjamans = Peminjaman::with(['sarana', 'ruangan', 'jadwal'])
            ->where('idUser', auth()->id())
            ->latest()
            ->paginate(10);

        return view('peminjaman.index', compact('peminjamans'));
    }

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