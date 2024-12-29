<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\Notifikasi;
use App\Models\Sarana;
use App\Models\TanggalPeminjaman;
use App\Models\Jadwal;
use Illuminate\Http\Request;
use App\Services\NotificationService;
use Illuminate\Validation\ValidationException;


class PeminjamanAdminController extends Controller
{
    protected $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }
    public function batalkanPeminjaman(Request $request, $id)
    {
        try {
            $request->validate([
                'feedbackPembatalan' => 'required|string|max:500',
            ]);
    
            $peminjaman = Peminjaman::with('user')->findOrFail($id);
            $peminjaman->status = 'dibatalkan';
            $peminjaman->feedbackPembatalan = $request->feedbackPembatalan;
            $peminjaman->save();
    
            // Buat notifikasi untuk user
            Notifikasi::create([
                'idPeminjaman' => $peminjaman->id,
                'penerima' => $peminjaman->user->id,
                'judul' => "Pembatalan Peminjaman",
                'isi' => "Peminjaman Anda telah dibatalkan dengan alasan: " . $request->feedbackPembatalan,
                'isRead' => false
            ]);
    
            // Kirim notifikasi realtime
            $this->notificationService->sendToUser(
                $peminjaman->user->id,
                "Pembatalan Peminjaman",
                "Peminjaman Anda telah dibatalkan dengan alasan: " . $request->feedbackPembatalan,
                $peminjaman->id
            );
    
            return response()->json([
                'success' => true,
                'message' => 'Peminjaman berhasil dibatalkan'
            ]);
    
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function PeminjamanDibatalkan(Request $request)
    {
        return $this->getPeminjaman($request, 'dibatalkan', 'Peminjaman Dibatalkan');
    }

    private function getPeminjaman(Request $request, $status, $title)
    {
        $search = $request->input('search');
        $sort = $request->input('sort');
        $today = now(); 

        $query = Peminjaman::with([
            'user', 
            'sarana', 
            'tanggalPeminjaman.jadwal'
        ])
        ->where('status', $status);

        if ($search) {
            $query->whereHas('user', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            });
        }

        if ($sort === 'pass') {
            $query->whereHas('tanggalPeminjaman', function($q) use ($today) {
                $q->where('tanggal', '<', $today);
            });
        } elseif (in_array($sort, ['asc', 'desc'])) {
            $query->whereHas('tanggalPeminjaman', function($q) {
                $q->select('idPeminjaman');
            })
            ->addSelect(['earliest_date' => function($query) {
                $query->select('tanggal')
                    ->from('tanggalpeminjaman')
                    ->whereColumn('idPeminjaman', 'peminjaman.id')
                    ->orderBy('tanggal', 'asc')
                    ->limit(1);
            }])
            ->orderBy('earliest_date', $sort);
        }

        $peminjamanMasuk = $query->paginate(10);

        if ($search) {
            $peminjamanMasuk->appends('search', $search);
        }
        if ($sort) {
            $peminjamanMasuk->appends('sort', $sort);
        }

        return view('admin.peminjaman', compact('peminjamanMasuk', 'search', 'title'));
    }


    public function PeminjamanMasuk(Request $request)
    {
        return $this->getPeminjaman($request, 'diajukan', 'Peminjaman Masuk');
    }

    public function PeminjamanDiproses(Request $request)
    {
        return $this->getPeminjaman($request, 'diproses', 'Peminjaman Diproses');
    }

    public function PeminjamanDisetujui(Request $request)
    {
        return $this->getPeminjaman($request, 'disetujui', 'Peminjaman Disetujui');
    }

    public function PeminjamanDitolak(Request $request)
    {
        return $this->getPeminjaman($request, 'ditolak', 'Peminjaman Ditolak');
    }

    public function PeminjamanDiajukanBatal(Request $request)
    {
        return $this->getPeminjaman($request, 'diajukanbatal', 'Pengajuan Pembatalan');
    }

    public function updateStatus(Request $request, $id)
    {
        try {
            $request->validate([
                'status' => 'required|in:disetujui,diproses,ditolak,dibatalkan,diajukan',
                'feedbackPenolakan' => 'nullable|required_if:status,ditolak|string|max:500',
                'alasanTolakBatal' => 'nullable|required_if:status,diajukan|string|max:500',
                'suratPeminjaman' => 'nullable|file|mimes:pdf|max:2048',
                'rundown' => 'nullable|file|mimes:pdf|max:2048',
                'estimasiPeserta' => 'nullable|integer|min:0',
                'tarif' => 'nullable|integer|min:0',
            ]);
    
            $peminjaman = Peminjaman::with('user')->findOrFail($id);
            $oldStatus = $peminjaman->status;
    
            // Handle pembatalan
            if ($request->status === 'diajukan') {
                $peminjaman->status = $peminjaman->statusSebelumBatal;
                $peminjaman->alasanTolakBatal = $request->alasanTolakBatal;
                $peminjaman->statusSebelumBatal = null;
            } elseif ($request->status === 'dibatalkan') {
                $peminjaman->status = 'dibatalkan';
            } else {
                // Update file uploads dan data lainnya
                if ($request->hasFile('suratPeminjaman')) {
                    $peminjaman->suratPeminjaman = $request->file('suratPeminjaman')->store('peminjaman/lampiran');
                }
                if ($request->hasFile('rundown')) {
                    $peminjaman->rundown = $request->file('rundown')->store('peminjaman/lampiran');
                }
                if ($request->has('estimasiPeserta')) {
                    $peminjaman->estimasiPeserta = $request->estimasiPeserta;
                }
                if ($request->has('tarif')) {
                    $peminjaman->tarif = $request->tarif;
                }
    
                // Jika status disetujui dan ada tarif, ubah status menjadi diproses
                if ($request->status === 'disetujui' && $peminjaman->totalTarif > 0) {
                    $peminjaman->status = 'diproses';
                } else {
                    $peminjaman->status = $request->status;
                }
    
                if ($request->status === 'ditolak') {
                    $peminjaman->feedbackPenolakan = $request->feedbackPenolakan;
                }
            }
    
            $peminjaman->save();
    
            // Siapkan pesan notifikasi
            $userMessage = match($peminjaman->status) {
                'ditolak' => "Peminjaman Anda ditolak dengan alasan " . $request->feedbackPenolakan,
                'diproses' => "Peminjaman Anda sedang diproses. Silakan melakukan pembayaran sebesar Rp " . number_format($peminjaman->totalTarif, 0, ',', '.'),
                'disetujui' => "Selamat! Peminjaman Anda telah disetujui.",
                'dibatalkan' => "Pembatalan peminjaman Anda telah disetujui.",
                'diajukan' => "Pembatalan peminjaman Anda ditolak dengan alasan " . $request->alasanTolakBatal,
                default => "Status peminjaman Anda telah diubah menjadi " . $peminjaman->status
            };
    
            // Tulis ke database
            Notifikasi::create([
                'idPeminjaman' => $peminjaman->id,
                'penerima' => $peminjaman->user->id,
                'judul' => "Update Status Peminjaman",
                'isi' => $userMessage,
                'isRead' => false
            ]);
    
            // Kirim response sukses
            $response = ['success' => true, 'message' => 'Status peminjaman berhasil diperbarui'];
    
            // Kirim notifikasi Pusher
            $this->notificationService->sendToUser(
                $peminjaman->user->id,
                "Update Status Peminjaman",
                $userMessage,
                $peminjaman->id
            );
    
            return response()->json($response);
    
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
    
    public function overview()
    {
       // Load data with relationships
       $saranas = Sarana::with(['ruangan', 'kategoriSarana'])->get();
       $jadwals = Jadwal::all();
       $peminjamans = Peminjaman::with([
           'user', 
           'sarana',
           'ruangan',
           'tanggalPeminjaman.jadwal'
       ])->get();
    
       $events = $peminjamans->map(function($peminjaman) {
           $tanggal = $peminjaman->tanggalPeminjaman->first();
           
           return [
               'saranaName' => $peminjaman->sarana->nama,
               'kegiatan' => $peminjaman->kegiatan,
               'start' => optional($tanggal)->tanggal,
               'jadwal' => optional($tanggal)->jadwal,
               'status' => $peminjaman->status,
               'peminjam' => $peminjaman->user->name ?? 'Anonim',
               'instansi' => $peminjaman->instansi ?? '-',
               'sarana' => $peminjaman->sarana->nama ?? '-', 
               'ruangan' => $peminjaman->ruangan->nama ?? '-',
               'saranaId' => $peminjaman->sarana->id,
               'estimasiPeserta' => $peminjaman->estimasiPeserta,
               'backgroundColor' => match($peminjaman->status) {
                   'disetujui' => '#059669',
                   'diproses' => '#f97316',
                   'ditolak' => '#dc2626', 
                   'diajukan' => '#3b82f6',
                   default => '#6b7280'
               },
               'borderColor' => match($peminjaman->status) {
                   'disetujui' => '#047857',
                   'diproses' => '#ea580c',
                   'ditolak' => '#b91c1c',
                   'diajukan' => '#2563eb', 
                   default => '#4b5563'
               },
               'extendedProps' => [
                   'status' => $peminjaman->status,
                   'peminjam' => $peminjaman->user->name ?? 'Anonim',
                   'instansi' => $peminjaman->instansi ?? '-',
                   'kegiatan' => $peminjaman->kegiatan ?? '-',
                   'sarana' => $peminjaman->sarana->nama ?? '-',
                   'ruangan' => $peminjaman->ruangan->nama ?? '-',
                   'jadwal' => optional($tanggal->jadwal)->mulai . ' - ' . optional($tanggal->jadwal)->selesai,
                   'estimasiPeserta' => $peminjaman->estimasiPeserta
               ]
           ];
       })->filter(function ($event) {
           return !empty($event['start']);
       })->values();
    
       return view('admin.overview', compact('events', 'saranas', 'jadwals'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'idSarana' => 'required|exists:sarana,id',
                'idRuangan' => 'nullable|exists:ruangan,id',
                'kegiatan' => 'required|string|max:255',
                'jadwal_dates' => 'required|array',
                'jadwal_dates.*.date' => 'required|date',
                'jadwal_dates.*.jadwal_id' => 'required|exists:jadwal,id'
            ]);
    
            // Check for scheduling conflicts
            foreach ($request->jadwal_dates as $jadwalDate) {
                $existingBooking = TanggalPeminjaman::where('tanggal', $jadwalDate['date'])
                    ->where('idJadwal', $jadwalDate['jadwal_id'])
                    ->whereHas('peminjaman', function($query) use ($request) {
                        $query->where('idSarana', $request->idSarana)
                            ->whereIn('status', ['diajukan', 'diproses', 'disetujui']);
                        
                        if ($request->idRuangan) {
                            $query->where('idRuangan', $request->idRuangan);
                        }
                    })
                    ->exists();
    
                if ($existingBooking) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Jadwal sudah dibooking untuk tanggal ' . $jadwalDate['date']
                    ], 422);
                }
            }
    
            // Create peminjaman
            $peminjaman = Peminjaman::create([
                'idUser' => auth()->id(),
                'idSarana' => $request->idSarana,
                'idRuangan' => $request->idRuangan,
                'kegiatan' => $request->kegiatan,
                'status' => 'disetujui',
                'instansi' => 'Internal'
            ]);
    
            // Create tanggal peminjaman entries
            foreach ($request->jadwal_dates as $jadwalDate) {
                $peminjaman->tanggalPeminjaman()->create([
                    'tanggal' => $jadwalDate['date'],
                    'idJadwal' => $jadwalDate['jadwal_id']
                ]);
            }
    
            return response()->json([
                'success' => true,
                'message' => 'Peminjaman berhasil ditambahkan'
            ]);
    
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function evaluasi(Request $request, $id)
    {
        try {
            $request->validate([
                'evaluasi' => 'required|string|max:255'
            ]);
    
            $peminjaman = Peminjaman::findOrFail($id);
            $peminjaman->evaluasi = $request->evaluasi;
            $peminjaman->save();
    
            return response()->json([
                'success' => true,
                'message' => 'Evaluasi berhasil ditambahkan',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
                
            ], 500);
        }
    }
}