<?php

namespace App\Http\Controllers;

use App\Models\Sarana;
use App\Models\Jadwal;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use App\Models\TanggalPeminjaman;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class OverviewController extends Controller
{
    public function overview()
    {
        $user = auth()->user();
        $query = Sarana::with(['ruangan', 'kategoriSarana']);
        $query->filterByUserAccess($user);
        $saranas = $query->get();

        $jadwals = Jadwal::all();

        // Hanya load data untuk bulan saat ini saat pertama kali load
        $startOfMonth = now()->startOfMonth()->format('Y-m-d');
        $endOfMonth = now()->endOfMonth()->format('Y-m-d');

        $query = Peminjaman::with([
            'user',
            'sarana',
            'ruangan',
            'tanggalPeminjaman' => function ($q) use ($startOfMonth, $endOfMonth) {
                $q->whereBetween('tanggal', [$startOfMonth, $endOfMonth]);
            },
            'tanggalPeminjaman.jadwal'
        ]);
        $query->filterByUserAccess($user);
        $query->whereHas('tanggalPeminjaman', function ($q) use ($startOfMonth, $endOfMonth) {
            $q->whereBetween('tanggal', [$startOfMonth, $endOfMonth]);
        });
        $peminjamans = $query->get();

        $events = collect();

        foreach ($peminjamans as $peminjaman) {
            // Loop melalui semua tanggal peminjaman, bukan hanya yang pertama
            foreach ($peminjaman->tanggalPeminjaman as $tanggal) {
                $events->push([
                    'saranaName' => $peminjaman->sarana->nama,
                    'kegiatan' => $peminjaman->kegiatan,
                    'start' => $tanggal->tanggal,
                    // Jadwal HARUS string, bukan object!
                    'jadwal' => $tanggal->jadwal ? $tanggal->jadwal->mulai . ' - ' . $tanggal->jadwal->selesai : '-',
                    'status' => $peminjaman->status,
                    'peminjam' => $peminjaman->user->name ?? 'Anonim',
                    'instansi' => $peminjaman->instansi ?? '-',
                    'sarana' => $peminjaman->sarana->nama ?? '-',
                    'ruangan' => $peminjaman->ruangan->nama ?? '-',
                    'saranaId' => $peminjaman->sarana->id,
                    'peminjamanId' => $peminjaman->id,
                    'estimasiPeserta' => $peminjaman->estimasiPeserta,
                    'backgroundColor' => match ($peminjaman->status) {
                        'disetujui' => '#059669',
                        'diproses' => '#f97316',
                        'ditolak' => '#dc2626',
                        'diajukan' => '#3b82f6',
                        'selesai' => '#D4A373',
                        default => '#6b7280'
                    },
                    'borderColor' => match ($peminjaman->status) {
                        'disetujui' => '#047857',
                        'diproses' => '#ea580c',
                        'ditolak' => '#b91c1c',
                        'diajukan' => '#2563eb',
                        'selesai' => '#A47551',
                        default => '#4b5563'
                    },
                    'extendedProps' => [
                        'status' => $peminjaman->status,
                        'peminjam' => $peminjaman->user->name ?? 'Anonim',
                        'instansi' => $peminjaman->instansi ?? '-',
                        'kegiatan' => $peminjaman->kegiatan ?? '-',
                        'sarana' => $peminjaman->sarana->nama ?? '-',
                        'ruangan' => $peminjaman->ruangan->nama ?? '-',
                        'jadwal' => $tanggal->jadwal ? $tanggal->jadwal->mulai . ' - ' . $tanggal->jadwal->selesai : '-',
                        'estimasiPeserta' => $peminjaman->estimasiPeserta,
                        'peminjamanId' => $peminjaman->id
                    ]
                ]);
            }
        }

        $events = $events->filter(function ($event) {
            return !empty($event['start']);
        })->values();

        // Hanya load booked dates untuk bulan saat ini
        $booked = TanggalPeminjaman::with(['jadwal', 'peminjaman'])
            ->whereHas('peminjaman', function ($q) {
                $q->whereIn('status', ['diajukan', 'diproses', 'disetujui']);
            })
            ->whereBetween('tanggal', [$startOfMonth, $endOfMonth])
            ->get()
            ->map(function ($item) {
                // Pastikan relasi peminjaman dan jadwal ada untuk menghindari error
                if (!$item->peminjaman || !$item->jadwal) {
                    return null;
                }

                return [
                    'tanggal'    => $item->tanggal,
                    'jadwal_id'  => $item->idJadwal,
                    'sarana_id'  => $item->peminjaman->idSarana,
                    'ruangan_id' => $item->peminjaman->idRuangan,
                    'mulai'      => $item->jadwal->mulai,  // Tambahkan ini
                    'selesai'    => $item->jadwal->selesai, // Tambahkan ini
                ];
            })
            ->filter() // Hapus item yang null
            ->values(); // Reset key array

        return view('admin.overview', compact('events', 'saranas', 'jadwals', 'booked'));
    }

    /**
     * Fetch events berdasarkan rentang tanggal untuk lazy loading
     */
    public function fetchEvents(Request $request)
    {
        try {
            // Parse tanggal ISO dari FullCalendar dan convert ke format Y-m-d
            $start = $request->input('start');
            $end = $request->input('end');

            // Extract hanya bagian tanggal (Y-m-d) dari format ISO
            // Handle berbagai format: 2025-10-26T00:00:00+07:00, 2025-10-26T00:00:00 07:00, atau 2025-10-26
            if (strpos($start, 'T') !== false) {
                $startDate = substr($start, 0, strpos($start, 'T'));
            } else {
                $startDate = substr($start, 0, 10);
            }

            if (strpos($end, 'T') !== false) {
                $endDate = substr($end, 0, strpos($end, 'T'));
            } else {
                $endDate = substr($end, 0, 10);
            }

            $user = auth()->user();

            $query = Peminjaman::with([
                'user',
                'sarana',
                'ruangan',
                'tanggalPeminjaman' => function ($q) use ($startDate, $endDate) {
                    $q->whereBetween('tanggal', [$startDate, $endDate]);
                },
                'tanggalPeminjaman.jadwal'
            ]);
            $query->filterByUserAccess($user);
            $query->whereHas('tanggalPeminjaman', function ($q) use ($startDate, $endDate) {
                $q->whereBetween('tanggal', [$startDate, $endDate]);
            });
            $peminjamans = $query->get();

            $events = collect();

            foreach ($peminjamans as $peminjaman) {
                foreach ($peminjaman->tanggalPeminjaman as $tanggal) {
                    $events->push([
                        'saranaName' => $peminjaman->sarana->nama,
                        'kegiatan' => $peminjaman->kegiatan,
                        'start' => $tanggal->tanggal,
                        'jadwal' => $tanggal->jadwal ? $tanggal->jadwal->mulai . ' - ' . $tanggal->jadwal->selesai : '-',
                        'status' => $peminjaman->status,
                        'peminjam' => $peminjaman->user->name ?? 'Anonim',
                        'instansi' => $peminjaman->instansi ?? '-',
                        'sarana' => $peminjaman->sarana->nama ?? '-',
                        'ruangan' => $peminjaman->ruangan->nama ?? '-',
                        'saranaId' => $peminjaman->sarana->id,
                        'peminjamanId' => $peminjaman->id,
                        'estimasiPeserta' => $peminjaman->estimasiPeserta,
                        'backgroundColor' => match ($peminjaman->status) {
                            'disetujui' => '#059669',
                            'diproses' => '#f97316',
                            'ditolak' => '#dc2626',
                            'diajukan' => '#3b82f6',
                            'selesai' => '#D4A373',
                            default => '#6b7280'
                        },
                        'borderColor' => match ($peminjaman->status) {
                            'disetujui' => '#047857',
                            'diproses' => '#ea580c',
                            'ditolak' => '#b91c1c',
                            'diajukan' => '#2563eb',
                            'selesai' => '#A47551',
                            default => '#4b5563'
                        },
                        'extendedProps' => [
                            'status' => $peminjaman->status,
                            'peminjam' => $peminjaman->user->name ?? 'Anonim',
                            'instansi' => $peminjaman->instansi ?? '-',
                            'kegiatan' => $peminjaman->kegiatan ?? '-',
                            'sarana' => $peminjaman->sarana->nama ?? '-',
                            'ruangan' => $peminjaman->ruangan->nama ?? '-',
                            'jadwal' => $tanggal->jadwal ? $tanggal->jadwal->mulai . ' - ' . $tanggal->jadwal->selesai : '-',
                            'estimasiPeserta' => $peminjaman->estimasiPeserta,
                            'peminjamanId' => $peminjaman->id
                        ]
                    ]);
                }
            }

            $events = $events->filter(function ($event) {
                return !empty($event['start']);
            })->values();

            return response()->json($events);
        } catch (\Exception $e) {
            Log::error('Error fetching events: ' . $e->getMessage());
            return response()->json([], 200);
        }
    }

    /**
     * Fetch booked dates berdasarkan rentang tanggal untuk lazy loading
     */
    public function fetchBookedDates(Request $request)
    {
        try {
            // Parse tanggal ISO dari FullCalendar dan convert ke format Y-m-d
            $start = $request->input('start');
            $end = $request->input('end');

            // Extract hanya bagian tanggal (Y-m-d) dari format ISO
            // Handle berbagai format: 2025-10-26T00:00:00+07:00, 2025-10-26T00:00:00 07:00, atau 2025-10-26
            if (strpos($start, 'T') !== false) {
                $startDate = substr($start, 0, strpos($start, 'T'));
            } else {
                $startDate = substr($start, 0, 10);
            }

            if (strpos($end, 'T') !== false) {
                $endDate = substr($end, 0, strpos($end, 'T'));
            } else {
                $endDate = substr($end, 0, 10);
            }

            $booked = TanggalPeminjaman::with(['jadwal', 'peminjaman'])
                ->whereHas('peminjaman', function ($q) {
                    $q->whereIn('status', ['diajukan', 'diproses', 'disetujui']);
                })
                ->whereBetween('tanggal', [$startDate, $endDate])
                ->get()
                ->map(function ($item) {
                    if (!$item->peminjaman || !$item->jadwal) {
                        return null;
                    }

                    return [
                        'tanggal'    => $item->tanggal,
                        'jadwal_id'  => $item->idJadwal,
                        'sarana_id'  => $item->peminjaman->idSarana,
                        'ruangan_id' => $item->peminjaman->idRuangan,
                        'mulai'      => $item->jadwal->mulai,
                        'selesai'    => $item->jadwal->selesai,
                    ];
                })
                ->filter()
                ->values();

            return response()->json($booked);
        } catch (\Exception $e) {
            Log::error('Error fetching booked dates: ' . $e->getMessage());
            return response()->json([], 200);
        }
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'idSarana' => 'required|exists:sarana,id',
                'kegiatan' => 'required|string|max:255',
                'jadwal_dates' => 'required|array|min:1',
                'jadwal_dates.*.date' => 'required|date',
                'jadwal_dates.*.jadwal_id' => 'required|exists:jadwal,id',
                'idRuangan' => 'nullable|exists:ruangan,id',
                'totalTarif' => 'nullable|integer|min:0',
                'buktiPembayaran' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            ], [
                'idSarana.required' => 'Sarana harus dipilih',
                'idSarana.exists' => 'Sarana yang dipilih tidak valid',
                'kegiatan.required' => 'Kegiatan harus diisi',
                'kegiatan.max' => 'Kegiatan maksimal 255 karakter',
                'jadwal_dates.required' => 'Minimal harus ada satu tanggal dan jadwal',
                'jadwal_dates.array' => 'Format tanggal dan jadwal tidak valid',
                'jadwal_dates.min' => 'Minimal harus ada satu tanggal dan jadwal',
                'jadwal_dates.*.date.required' => 'Tanggal harus diisi',
                'jadwal_dates.*.date.date' => 'Format tanggal tidak valid',
                'jadwal_dates.*.jadwal_id.required' => 'Jadwal harus dipilih',
                'jadwal_dates.*.jadwal_id.exists' => 'Jadwal yang dipilih tidak valid',
                'idRuangan.exists' => 'Ruangan yang dipilih tidak valid',
                'totalTarif.integer' => 'Tarif harus berupa angka',
                'totalTarif.min' => 'Tarif tidak boleh negatif',
                'buktiPembayaran.image' => 'File harus berupa gambar',
                'buktiPembayaran.mimes' => 'Format file harus JPG, JPEG, atau PNG',
                'buktiPembayaran.max' => 'Ukuran file maksimal 2MB',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $e->errors()
            ], 422);
        }

        DB::beginTransaction();
        try {
            $data = [
                'idUser' => auth()->id(),
                'idSarana' => $validated['idSarana'],
                'kegiatan' => $validated['kegiatan'],
                'status' => 'disetujui',
                'instansi' => 'Superadmin SIMSAPRAS',
                'statusPeminjam' => 'unit',
                'totalTarif' => $validated['totalTarif'] ?? 0,
                'statusPembayaran' => 'lunas',
            ];

            if ($request->filled('idRuangan')) {
                $data['idRuangan'] = $validated['idRuangan'];
            }

            $peminjaman = Peminjaman::create($data);

            // Handle upload bukti pembayaran jika ada
            if ($request->hasFile('buktiPembayaran')) {
                $file = $request->file('buktiPembayaran');
                $filename = 'bukti_pembayaran_' . time() . '_' . $peminjaman->id . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('bukti_pembayaran', $filename, 'public');

                $peminjaman->update([
                    'buktiPembayaran' => $path,
                ]);
            }

            foreach ($validated['jadwal_dates'] as $jadwal) {
                TanggalPeminjaman::create([
                    'idPeminjaman' => $peminjaman->id,
                    'tanggal' => $jadwal['date'],
                    'idJadwal' => $jadwal['jadwal_id'],
                ]);
            }

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Peminjaman berhasil ditambahkan']);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error storing peminjaman: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage()
            ], 500);
        }
    }
}
