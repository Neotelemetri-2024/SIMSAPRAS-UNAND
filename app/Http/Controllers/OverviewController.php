<?php

namespace App\Http\Controllers;

use App\Models\Sarana;
use App\Models\Jadwal;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use App\Models\TanggalPeminjaman;
use Illuminate\Support\Facades\DB;

class OverviewController extends Controller
{
    public function overview()
    {
        $user = auth()->user();
        $query = Sarana::with(['ruangan', 'kategoriSarana']);
        $query->filterByUserAccess($user);
        $saranas = $query->get();

        $jadwals = Jadwal::all();

        $query = Peminjaman::with([
            'user',
            'sarana',
            'ruangan',
            'tanggalPeminjaman.jadwal'
        ]);
        $query->filterByUserAccess($user);
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

        $booked = TanggalPeminjaman::with(['jadwal', 'peminjaman'])
            ->whereHas('peminjaman', function ($q) {
                $q->whereIn('status', ['diajukan', 'diproses', 'disetujui']);
            })
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

    public function store(Request $request)
    {
        $request->validate([
            'idSarana' => 'required|exists:sarana,id',
            'kegiatan' => 'required|string|max:255',
            'jadwal_dates' => 'required|array|min:1',
            'jadwal_dates.*.date' => 'required|date',
            'jadwal_dates.*.jadwal_id' => 'required|exists:jadwal,id',
            'idRuangan' => 'nullable|exists:ruangan,id',
            'totalTarif' => 'nullable|integer|min:0',
        ]);

        DB::beginTransaction();
        try {
            $data = [
                'idUser' => auth()->id(),
                'idSarana' => $request->idSarana,
                'kegiatan' => $request->kegiatan,
                'status' => 'disetujui',
                'instansi' => 'Superadmin SIMSAPRAS',
                'statusPeminjam' => 'unit',
                'totalTarif' => $request->totalTarif ?? 0,
                'statusPembayaran' => 'lunas',
            ];

            if ($request->filled('idRuangan')) {
                $data['idRuangan'] = $request->idRuangan;
            }

            $peminjaman = Peminjaman::create($data);

            foreach ($request->jadwal_dates as $jadwal) {
                TanggalPeminjaman::create([
                    'idPeminjaman' => $peminjaman->id,
                    'tanggal' => $jadwal['date'],
                    'idJadwal' => $jadwal['jadwal_id'],
                ]);
            }

            DB::commit();
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
