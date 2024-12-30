<?php

namespace App\Http\Controllers;

use App\Models\KategoriSarana;
use App\Models\Peminjaman;
use App\Models\Sarana;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index () {
        $kategori = KategoriSarana::all();
        $sarana = Sarana::all();
        $totalUser = User::where('role', 'user')->count();
        $totalInstansi = Peminjaman::distinct('instansi')->count('instansi');
        $totalPeminjamanData = Peminjaman::selectRaw("
            COUNT(*) as total,
            SUM(CASE WHEN status = 'diajukan' THEN 1 ELSE 0 END) as totalMasuk,
            SUM(CASE WHEN status = 'disetujui' THEN 1 ELSE 0 END) as totalDisetujui,
            SUM(CASE WHEN status = 'diproses' THEN 1 ELSE 0 END) as totalDiproses,
            SUM(CASE WHEN status = 'ditolak' THEN 1 ELSE 0 END) as totalDitolak,
            SUM(CASE WHEN status = 'dibatalkan' THEN 1 ELSE 0 END) as totalDibatalkan,
            SUM(CASE WHEN status = 'diajukanbatal' THEN 1 ELSE 0 END) as totalDiajukanBatal
        ")->first();
        $instansi = DB::table('peminjaman')
            ->select('instansi', DB::raw('COUNT(*) as jumlah'))
            ->groupBy('instansi')
            ->orderByDesc('jumlah')
            ->limit(5)
            ->get();
        $grafikSarana = DB::table('peminjaman as p')
            ->join('sarana as s', 'p.idSarana', '=', 's.id')
            ->select('s.nama', DB::raw('COUNT(p.idSarana) as jumlah'))
            ->groupBy('s.nama')
            ->orderByDesc('jumlah')
            ->limit(5)
            ->get();
        $weeklyPerformance = DB::table('peminjaman')
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('COUNT(*) as total')
            )
            ->whereBetween('created_at', [now()->subDays(7), now()])
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $monthlyStatusTrend = DB::table('peminjaman')
            ->select(
                DB::raw('MONTH(created_at) as bulan'),
                DB::raw('YEAR(created_at) as tahun'),
                DB::raw("SUM(CASE WHEN status = 'diajukan' THEN 1 ELSE 0 END) as diajukan"),
                DB::raw("SUM(CASE WHEN status = 'diproses' THEN 1 ELSE 0 END) as diproses"),
                DB::raw("SUM(CASE WHEN status = 'disetujui' THEN 1 ELSE 0 END) as disetujui"),
                DB::raw("SUM(CASE WHEN status = 'ditolak' THEN 1 ELSE 0 END) as ditolak"),
                DB::raw("SUM(CASE WHEN status = 'dibatalkan' THEN 1 ELSE 0 END) as dibatalkan"),
                DB::raw("SUM(CASE WHEN status = 'diajukanbatal' THEN 1 ELSE 0 END) as diajukanbatal")
            )
            ->whereYear('created_at', date('Y'))
            ->groupBy('tahun', 'bulan')
            ->orderBy('tahun')
            ->orderBy('bulan')
            ->get();
        $statusDistribution = DB::table('peminjaman')
            ->select('status', DB::raw('COUNT(*) as total'))
            ->groupBy('status')
            ->get();
        $trendSarana = DB::table('peminjaman as p')
            ->join('sarana as s', 'p.idSarana', '=', 's.id')
            ->select(
                's.nama as nama_sarana',
                DB::raw('MONTH(p.created_at) as bulan'),
                DB::raw('COUNT(*) as total')
            )
            ->whereYear('p.created_at', date('Y'))
            ->groupBy('s.nama', 'bulan')
            ->orderBy('bulan')
            ->get();

        $trendSaranaData = $trendSarana->groupBy('nama_sarana');



            return view('admin.dashboard', [
                'kategori' => $kategori,
                'sarana' => $sarana,
                'totalUser' => $totalUser,
                'totalInstansi' => $totalInstansi,
                'totalPeminjaman' => $totalPeminjamanData->total,
                'totalPeminjamanMasuk' => $totalPeminjamanData->totalMasuk,
                'totalPeminjamanDisetujui' => $totalPeminjamanData->totalDisetujui,
                'totalPeminjamanDiproses' => $totalPeminjamanData->totalDiproses,
                'totalPeminjamanDitolak' => $totalPeminjamanData->totalDitolak,
                'totalPeminjamanDibatalkan' => $totalPeminjamanData->totalDibatalkan,
                'totalPeminjamanDiajukanBatal' => $totalPeminjamanData->totalDiajukanBatal,
                'instansi' => $instansi,
                'grafikSarana' => $grafikSarana,
                'weeklyPerformance' => $weeklyPerformance,
                'monthlyStatusTrend' => $monthlyStatusTrend,
                'statusDistribution' => $statusDistribution,
                'statusDistribution' => $statusDistribution,
                'trendSarana' => $trendSarana,
                'trendSaranaData' => $trendSaranaData,
            ]);
    }
}