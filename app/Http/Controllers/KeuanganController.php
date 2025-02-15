<?php

namespace App\Http\Controllers;
use App\Models\Peminjaman;

class KeuanganController extends Controller
{
    public function index()
    {
        $validStatuses = ['disetujui', 'selesai'];

        $totalYearToDate = Peminjaman::whereYear('created_at', date('Y'))
            ->whereIn('status', $validStatuses)
            ->where('statusPembayaran', 'lunas')
            ->sum('totalTarif');

        $totalCurrentMonth = Peminjaman::whereYear('created_at', date('Y'))
            ->whereMonth('created_at', date('m'))
            ->whereIn('status', $validStatuses)
            ->where('statusPembayaran', 'lunas')
            ->sum('totalTarif');

        $totalTransactions = Peminjaman::whereIn('status', $validStatuses)
            ->where('statusPembayaran', 'lunas')
            ->count();

        $averagePerTransaction = $totalTransactions > 0 ?
            $totalYearToDate / $totalTransactions : 0;

        $monthlyData = Peminjaman::selectRaw('
            DATE_FORMAT(created_at, "%Y-%m") as month,
            SUM(totalTarif) as total
            ')
            ->whereIn('status', $validStatuses)
            ->where('statusPembayaran', 'lunas')
            ->whereBetween('created_at', [
                now()->subMonths(11)->startOfMonth(),
                now()->endOfMonth()
            ])
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $saranaData = Peminjaman::join('tanggalpeminjaman', 'peminjaman.id', '=', 'tanggalpeminjaman.idPeminjaman')
            ->selectRaw('
                sarana.nama as sarana_name,
                COUNT(DISTINCT peminjaman.id) as total_bookings,
                SUM(peminjaman.totalTarif) as total
            ')
            ->join('sarana', 'peminjaman.idSarana', '=', 'sarana.id')
            ->whereIn('peminjaman.status', $validStatuses)
            ->where('peminjaman.statusPembayaran', 'lunas')
            ->whereYear('tanggalpeminjaman.tanggal', date('Y'))
            ->groupBy('sarana.id', 'sarana.nama')
            ->get();

        $topRooms = Peminjaman::join('tanggalpeminjaman', 'peminjaman.id', '=', 'tanggalpeminjaman.idPeminjaman')
            ->selectRaw('
                ruangan.nama as room_name,
                COUNT(DISTINCT peminjaman.id) as total_bookings,
                SUM(peminjaman.totalTarif) as total_income,
                ruangan.kapasitas
            ')
            ->join('ruangan', 'peminjaman.idRuangan', '=', 'ruangan.id')
            ->whereIn('peminjaman.status', $validStatuses)
            ->where('peminjaman.statusPembayaran', 'lunas')
            ->whereYear('tanggalpeminjaman.tanggal', date('Y'))
            ->groupBy('ruangan.id', 'ruangan.nama', 'ruangan.kapasitas')
            ->orderBy('total_income', 'desc')
            ->limit(5)
            ->get();

        $customerTypeData = Peminjaman::join('tanggalpeminjaman', 'peminjaman.id', '=', 'tanggalpeminjaman.idPeminjaman')
            ->selectRaw('
                statusPeminjam,
                COUNT(DISTINCT peminjaman.id) as total_bookings,
                SUM(totalTarif) as total_income
            ')
            ->whereIn('status', $validStatuses)
            ->where('statusPembayaran', 'lunas')
            ->whereYear('tanggalpeminjaman.tanggal', date('Y'))
            ->groupBy('statusPeminjam')
            ->get();

        return view('admin.keuangan', compact(
            'totalYearToDate',
            'totalCurrentMonth',
            'totalTransactions',
            'averagePerTransaction',
            'monthlyData',
            'saranaData',
            'topRooms',
            'customerTypeData',
        ));
    }
}