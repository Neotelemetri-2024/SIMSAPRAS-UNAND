<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peminjaman;
use App\Models\Jadwal;
use App\Models\Ruangan;
use App\Models\User;
use App\Models\Notifikasi;
use App\Models\Tanggal;
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
        // Validasi request
        if (!$request->has('sarana_id') && !$request->has('ruangan_id')) {
            return redirect()
                ->back()
                ->with('error', 'Data tidak lengkap');
        }

        $jadwals = Jadwal::all();
        $selectedDates = $request->selected_dates;

        // Jika peminjaman ruangan
        if ($request->has('ruangan_id')) {
            $ruangan = Ruangan::with('sarana')->findOrFail($request->ruangan_id);
            $sarana = $ruangan->sarana;

            return view('peminjaman', compact('sarana', 'ruangan', 'selectedDates', 'jadwals'));
        }

        // Jika peminjaman sarana langsung
        $sarana = Sarana::findOrFail($request->sarana_id);

        return view('peminjaman', compact('sarana', 'selectedDates', 'jadwals'));
    }

    public function store(Request $request)
    {
        try {
            // Validasi dasar
            $validationRules = [
                'idSarana' => 'required|exists:sarana,id',
                'jadwal_dates' => 'required|array', // Changed from idJadwal
                'jadwal_dates.*.date' => 'required|date', // Validate each date
                'jadwal_dates.*.jadwal_id' => 'required|exists:jadwal,id', // Validate each jadwal_id
                'kegiatan' => 'required|string|max:255',
                'suratPeminjaman' => 'required|file|mimes:pdf,doc,docx|max:2048',
                'rundown' => 'required|file|mimes:pdf,doc,docx|max:2048',
                'instansi' => 'required|string|max:255',
                'estimasiPeserta' => 'required|integer|min:1',
            ];

            // Tambahkan validasi ruangan jika ada
            if ($request->has('idRuangan')) {
                $validationRules['idRuangan'] = 'required|exists:ruangan,id';

                // Validasi kapasitas ruangan
                $ruangan = Ruangan::find($request->idRuangan);
                if ($request->estimasiPeserta > $ruangan->kapasitas) {
                    return response()->json(
                        [
                            'success' => false,
                            'message' => 'Jumlah peserta melebihi kapasitas ruangan',
                        ],
                        422
                    );
                }
            }

            $validated = $request->validate($validationRules);

            // Upload files
            $suratPath = $request->file('suratPeminjaman')->store('peminjaman/surat', 'public');
            $rundownPath = $request->file('rundown')->store('peminjaman/rundown', 'public');

            // Buat array data peminjaman
            $peminjamanData = [
                'idUser' => auth()->id(),
                'idSarana' => $validated['idSarana'],
                'kegiatan' => $validated['kegiatan'],
                'suratPeminjaman' => $suratPath,
                'rundown' => $rundownPath,
                'instansi' => $validated['instansi'],
                'estimasiPeserta' => $validated['estimasiPeserta'],
                'status' => 'diajukan',
            ];

            if ($request->has('idRuangan')) {
                $peminjamanData['idRuangan'] = $validated['idRuangan'];
            }

            // Create peminjaman
            $peminjaman = Peminjaman::create($peminjamanData);

            // Create tanggal peminjaman with respective jadwal
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
            return back()->with('error', 'Peminjaman tidak dapat dibatalkan');
        }

        $request->validate([
            'alasan_pembatalan' => 'required|string|min:10',
        ]);

        $peminjaman->update([
            'status' => 'dibatalkan',
            'feedbackPembatalan' => $request->alasan_pembatalan,
        ]);

        return redirect()
            ->route('peminjaman.index')
            ->with('success', 'Peminjaman berhasil dibatalkan');
    }
}