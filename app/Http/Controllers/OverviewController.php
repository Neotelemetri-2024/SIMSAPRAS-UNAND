<?php
namespace App\Http\Controllers;
use App\Models\Sarana;
use App\Models\Jadwal;
use App\Models\Peminjaman;
use Illuminate\Http\Request;

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
                    'selesai' => '#D4A373',
                    default => '#6b7280'
                },
                'borderColor' => match($peminjaman->status) {
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
                    'jadwal' => optional($tanggal->jadwal)->mulai . ' - ' . optional($tanggal->jadwal)->selesai,
                    'estimasiPeserta' => $peminjaman->estimasiPeserta
                ]
            ];
        })->filter(function ($event) {
            return !empty($event['start']);
        })->values();

        return view('admin.overview', compact('events', 'saranas', 'jadwals'));
    }
}