<?php 

namespace App\Http\Controllers;
use App\Models\Peminjaman;

class KeuanganController extends Controller
{
    public function index()
    {
        $totalYearToDate = Peminjaman::whereYear('created_at', date('Y'))
            ->where('status', 'disetujui')
            ->where('statusPembayaran', 'lunas')
            ->sum('totalTarif');

        $totalCurrentMonth = Peminjaman::whereYear('created_at', date('Y'))
            ->whereMonth('created_at', date('m'))
            ->where('status', 'disetujui')
            ->where('statusPembayaran', 'lunas')
            ->sum('totalTarif');

        $totalTransactions = Peminjaman::where('status', 'disetujui')
            ->where('statusPembayaran', 'lunas')
            ->count();

        $averagePerTransaction = $totalTransactions > 0 ? 
            $totalYearToDate / $totalTransactions : 0;

        $monthlyData = Peminjaman::selectRaw('
                DATE_FORMAT(created_at, "%Y-%m") as month,
                SUM(totalTarif) as total
            ')
            ->where('status', 'disetujui')
            ->where('statusPembayaran', 'lunas')
            ->whereBetween('created_at', [
                now()->subMonths(11)->startOfMonth(),
                now()->endOfMonth()
            ])
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $saranaData = Peminjaman::selectRaw('
                sarana.nama as sarana_name,
                COUNT(*) as total_bookings,
                SUM(peminjaman.totalTarif) as total
            ')
            ->join('sarana', 'peminjaman.idSarana', '=', 'sarana.id')
            ->where('peminjaman.status', 'disetujui')
            ->where('peminjaman.statusPembayaran', 'lunas')
            ->whereYear('peminjaman.created_at', date('Y'))
            ->groupBy('sarana.id', 'sarana.nama')
            ->get();

        $topRooms = Peminjaman::selectRaw('
                ruangan.nama as room_name,
                COUNT(*) as total_bookings,
                SUM(peminjaman.totalTarif) as total_income,
                ruangan.kapasitas
            ')
            ->join('ruangan', 'peminjaman.idRuangan', '=', 'ruangan.id')
            ->where('peminjaman.status', 'disetujui')
            ->where('peminjaman.statusPembayaran', 'lunas')
            ->whereYear('peminjaman.created_at', date('Y'))
            ->groupBy('ruangan.id', 'ruangan.nama', 'ruangan.kapasitas')
            ->orderBy('total_income', 'desc')
            ->limit(5)
            ->get();

        $customerTypeData = Peminjaman::selectRaw('
                isUnand,
                COUNT(*) as total_bookings,
                SUM(totalTarif) as total_income
            ')
            ->where('status', 'disetujui')
            ->where('statusPembayaran', 'lunas')
            ->whereYear('created_at', date('Y'))
            ->groupBy('isUnand')
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