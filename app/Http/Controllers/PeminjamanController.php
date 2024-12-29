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
        $jadwals = Jadwal::all();
        $bookedJadwals = $this->getBookedJadwals($request->selected_dates, $request->ruangan_id ?? null, $request->sarana_id ?? null);
    
        if ($request->has('ruangan_id')) {
            $ruangan = Ruangan::with('sarana')->findOrFail($request->ruangan_id);
            $sarana = $ruangan->sarana;
    
            // Add warning message for classroom
            if ($ruangan->kelas) {
                session()->flash('warning', 'Ruangan ini merupakan ruangan kelas yang hanya dapat dipinjam pada hari Sabtu dan Minggu.');
            }
    
            return view('peminjaman', compact('sarana', 'ruangan', 'selectedDates', 'jadwals', 'bookedJadwals'));
        }
    
        $sarana = Sarana::findOrFail($request->sarana_id);
        return view('peminjaman', compact('sarana', 'selectedDates', 'jadwals', 'bookedJadwals'));
    }

    private function getBookedJadwals($selectedDates, $ruanganId = null, $saranaId = null)
    {
        $dates = json_decode($selectedDates);
        $bookedJadwals = [];

        foreach ($dates as $date) {
            $query = TanggalPeminjaman::whereDate('tanggal', $date)
                ->whereHas('peminjaman', function ($q) use ($ruanganId, $saranaId) {
                    $q->whereIn('status', ['diajukan', 'diproses', 'disetujui']);
                    
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
                'isUnand' => 'required|boolean',
            ];
    
            if ($request->has('idRuangan')) {
                $validationRules['idRuangan'] = 'required|exists:ruangan,id';
                $ruangan = Ruangan::find($request->idRuangan);
                
                // Validate room capacity
                if ($request->estimasiPeserta > $ruangan->kapasitas) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Jumlah peserta melebihi kapasitas ruangan'
                    ], 422);
                }
    
                // Validate classroom booking dates
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
    
            // Upload files
            $suratPath = $request->file('suratPeminjaman')->store('peminjaman/surat', 'public');
            $rundownPath = $request->file('rundown')->store('peminjaman/rundown', 'public');
    
            // Calculate tariff
            $sarana = Sarana::find($validated['idSarana']);
            $ruangan = isset($validated['idRuangan']) ? Ruangan::find($validated['idRuangan']) : null;
            $totalTarif = Peminjaman::calculateTarif(
                $validated['jadwal_dates'],
                $validated['isUnand'],
                $sarana,
                $ruangan
            );
    
            // Create peminjaman data array
            $peminjamanData = [
                'idUser' => auth()->id(),
                'idSarana' => $validated['idSarana'],
                'kegiatan' => $validated['kegiatan'],
                'suratPeminjaman' => $suratPath,
                'rundown' => $rundownPath,
                'instansi' => $validated['instansi'],
                'estimasiPeserta' => $validated['estimasiPeserta'],
                'status' => 'diajukan',
                'isUnand' => $validated['isUnand'],
                'totalTarif' => $totalTarif
            ];
    
            if ($request->has('idRuangan')) {
                $peminjamanData['idRuangan'] = $validated['idRuangan'];
            }
    
            // Create peminjaman
            $peminjaman = Peminjaman::create($peminjamanData);
    
            // Create tanggal peminjaman records
            foreach ($validated['jadwal_dates'] as $jadwalDate) {
                $peminjaman->tanggalPeminjaman()->create([
                    'tanggal' => $jadwalDate['date'],
                    'idJadwal' => $jadwalDate['jadwal_id'],
                ]);
            }
    
            // Single insert untuk notifikasi admin
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

            // Bulk insert notifikasi
            Notifikasi::insert($adminNotifications);

            // Kirim notifikasi Pusher
            $this->notificationService->sendToAll(
                'Peminjaman Baru',
                "Peminjaman " . ($peminjaman->ruangan ? $peminjaman->ruangan->nama : $peminjaman->sarana->nama) . " dari " . auth()->user()->name . " untuk kegiatan " . $peminjaman->kegiatan
            );

            // Kirim response terakhir
            return response()->json([
                'success' => true,
                'message' => 'Pengajuan peminjaman berhasil dikirim',
                'redirect' => route('riwayat.index'),
            ]);
        } catch (\Exception $e) {
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
        // Load relationships
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
        // Validasi bahwa peminjaman milik user yang login
        if ($peminjaman->idUser !== auth()->id()) {
            return back()->with('error', 'Anda tidak memiliki akses untuk membatalkan peminjaman ini');
        }

        // Validasi status peminjaman
        if (!in_array($peminjaman->status, ['diajukan', 'disetujui'])) {
            return back()->with('error', 'Status peminjaman tidak dapat dibatalkan');
        }

        // Cek apakah masih lebih dari 3 hari sebelum tanggal peminjaman
        $earliestBookingDate = $peminjaman->tanggalPeminjaman->min('tanggal');
        if ($earliestBookingDate <= now()->addDays(3)->format('Y-m-d')) {
            return back()->with('error', 'Peminjaman hanya dapat dibatalkan maksimal 3 hari sebelum tanggal peminjaman');
        }

        // Validasi input alasan pembatalan
        $request->validate([
            'alasan_pembatalan' => 'required|string|min:10',
        ], [
            'alasan_pembatalan.required' => 'Alasan pembatalan wajib diisi',
            'alasan_pembatalan.min' => 'Alasan pembatalan minimal 10 karakter'
        ]);

        try {
            $peminjaman->statusSebelumBatal = $peminjaman->status;
            $peminjaman->update([
                'status' => 'diajukanbatal',
                'alasanPembatalan' => $request->alasan_pembatalan
            ]);

            // Kirim notifikasi ke admin
            $adminNotifications = User::whereIn('role', ['admin', 'superadmin', 'pimpinan'])
                ->get()
                ->map(function ($admin) use ($peminjaman) {
                    return [
                        'idPeminjaman' => $peminjaman->id,
                        'penerima' => $admin->id,
                        'judul' => 'Pengajuan Pembatalan',
                        'isi' => "Pengajuan pembatalan " . ($peminjaman->ruangan ? $peminjaman->ruangan->nama : $peminjaman->sarana->nama) . " dari " . auth()->user()->name . " untuk kegiatan " . $peminjaman->kegiatan,
                        'isRead' => false,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                })
                ->toArray();

            // Bulk insert notifikasi
            Notifikasi::insert($adminNotifications);

            return redirect()
                ->route('riwayat.index')
                ->with('success', 'Pengajuan Pembatalan berhasil dilakukan');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat membatalkan peminjaman');
        }
    }
}