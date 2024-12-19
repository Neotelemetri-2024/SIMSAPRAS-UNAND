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
            SUM(CASE WHEN status = 'ditolak' THEN 1 ELSE 0 END) as totalDitolak
        ")->first();
        // $totalPeminjaman = Peminjaman::all();
        // $totalPeminjamanMasuk = Peminjaman::where('status', 'diajukan')->count();
        // $totalPeminjamanDisetujui = Peminjaman::where('status', 'disetujui')->count();
        // $totalPeminjamanDiproses = Peminjaman::where('status', 'diproses')->count();
        // $totalPeminjamanDitolak = Peminjaman::where('status', 'ditolak')->count();
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
                'instansi' => $instansi,
                'grafikSarana' => $grafikSarana,
            ]);
    }
}