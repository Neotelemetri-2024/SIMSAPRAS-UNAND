<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use App\Models\Notifikasi;
use Illuminate\Http\Request;
use App\Services\NotificationService;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PeminjamanExport;
use App\Exports\PeminjamanExportAdvanced;
use Illuminate\Support\Facades\Log; // Tambahkan ini


class PeminjamanSelesaiController extends Controller
{
    protected $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    public function index(Request $request)
    {
        Peminjaman::where('status', 'disetujui')
            ->whereHas('tanggalPeminjaman', function ($query) {
                $query->where('tanggal', '<', now());
            })
            ->update([
                'status' => 'selesai'
            ]);
        $search = $request->input('search');
        $sort = $request->input('sort');
        $saranaFilter = $request->input('sarana');
        $dateFrom = $request->input('date_from');
        $dateTo = $request->input('date_to');
        $today = now();

        $query = Peminjaman::with(['user', 'sarana', 'tanggalPeminjaman.jadwal'])
            ->where('status', 'selesai');
        $query->filterByUserAccess(auth()->user());

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->whereHas('user', function ($userQuery) use ($search) {
                    $userQuery->where('name', 'like', "%{$search}%");
                })
                    ->orWhere('instansi', 'like', "%{$search}%")
                    ->orWhere('kegiatan', 'like', "%{$search}%");
            });
        }

        // Filter by sarana
        if ($saranaFilter) {
            $query->where('idSarana', $saranaFilter);
        }

        // Filter by date range
        if ($dateFrom) {
            $query->whereHas('tanggalPeminjaman', function ($q) use ($dateFrom) {
                $q->where('tanggal', '>=', $dateFrom);
            });
        }
        if ($dateTo) {
            $query->whereHas('tanggalPeminjaman', function ($q) use ($dateTo) {
                $q->where('tanggal', '<=', $dateTo);
            });
        }

        if ($sort === 'pass') {
            $query->whereHas('tanggalPeminjaman', function ($q) use ($today) {
                $q->where('tanggal', '<', $today);
            });
        } elseif (in_array($sort, ['asc', 'desc'])) {
            $query->whereHas('tanggalPeminjaman', function ($q) {
                $q->select('idPeminjaman');
            })
                ->addSelect(['earliest_date' => function ($query) {
                    $query->select('tanggal')
                        ->from('tanggalpeminjaman')
                        ->whereColumn('idPeminjaman', 'peminjaman.id')
                        ->orderBy('tanggal', 'asc')
                        ->limit(1);
                }])
                ->orderBy('earliest_date', $sort);
        }

        $peminjamanSelesai = $query
            ->paginate(10)
            ->appends(['search' => $search, 'sort' => $sort, 'sarana' => $saranaFilter, 'date_from' => $dateFrom, 'date_to' => $dateTo]);
        $title = 'Peminjaman Selesai';

        // Get sarana list for filter
        $saranas = \App\Models\Sarana::where('status', 'aktif')->get();

        return view('admin.peminjamanselesai', compact('peminjamanSelesai', 'search', 'sort', 'title', 'saranas', 'saranaFilter', 'dateFrom', 'dateTo'));
    }

    public function isiEvaluasi(Request $request, $id)
    {
        try {
            $request->validate([
                'evaluasi' => 'required|string|max:500',
            ]);

            $peminjaman = Peminjaman::findOrFail($id);
            $peminjaman->evaluasi = $request->evaluasi;
            $peminjaman->save();



            // Tulis ke database
            Notifikasi::create([
                'idPeminjaman' => $peminjaman->id,
                'penerima' => $peminjaman->user->id,
                'judul' => "Update Status Peminjaman",
                'isi' => 'Evaluasi sudah dikirimkan ke riwayat anda',
                'isRead' => false
            ]);

            // Kirim response sukses
            $response = ['success' => true, 'message' => 'Evaluasi berhasil diisi'];

            // Kirim notifikasi Pusher
            $this->notificationService->sendToUser(
                $peminjaman->user->id,
                "Peminjaman sudah selesai",
                'Evaluasi sudah dikirimkan ke riwayat anda',
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



    public function export(Request $request)
    {
        try {
            // Debug: log semua request data
            Log::info('Export request received:', [
                'all_data' => $request->all(),
                'method' => $request->method(),
                'url' => $request->url()
            ]);

            // Validasi sederhana
            if (!$request->has('start_date') || !$request->has('end_date') || !$request->has('filter_type')) {
                Log::error('Missing required parameters');
                return back()->with('error', 'Parameter yang diperlukan tidak lengkap');
            }

            $startDate = $request->start_date;
            $endDate = $request->end_date;
            $filterType = $request->filter_type;

            // Format nama file yang lebih informatif
            $startDateFormatted = \Carbon\Carbon::parse($startDate)->format('d-m-Y');
            $endDateFormatted = \Carbon\Carbon::parse($endDate)->format('d-m-Y');
            $filterTypeText = $filterType === 'created' ? 'Tanggal_Pengajuan' : 'Tanggal_Peminjaman';

            $filename = "Laporan_Peminjaman_Selesai_{$filterTypeText}_{$startDateFormatted}_sampai_{$endDateFormatted}.xlsx";

            Log::info('Starting export with params:', [
                'start_date' => $startDate,
                'end_date' => $endDate,
                'filter_type' => $filterType,
                'filename' => $filename
            ]);

            // Export dengan class sederhana (satu sheet saja)
            return Excel::download(
                new PeminjamanExport(
                    $startDate,
                    $endDate,
                    $filterType
                ),
                $filename
            );
        } catch (\Exception $e) {
            Log::error('Export error:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return back()->with('error', 'Terjadi kesalahan saat mengexport data: ' . $e->getMessage());
        }
    }
}
