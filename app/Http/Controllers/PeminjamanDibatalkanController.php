<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use App\Models\Notifikasi;
use Illuminate\Http\Request;
use App\Services\NotificationService;

class PeminjamanDibatalkanController extends Controller
{
    protected $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    public function index(Request $request)
    {
        $search = $request->input('search');
        $sort = $request->input('sort');
        $saranaFilter = $request->input('sarana');
        $dateFrom = $request->input('date_from');
        $dateTo = $request->input('date_to');
        $today = now();

        $query = Peminjaman::with(['user', 'sarana', 'tanggalPeminjaman.jadwal', 'dibatalkanOleh'])
            ->where('status', 'dibatalkan');
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

        $peminjamanDibatalkan = $query
            ->paginate(10)
            ->appends(['search' => $search, 'sort' => $sort, 'sarana' => $saranaFilter, 'date_from' => $dateFrom, 'date_to' => $dateTo]);
        $title = 'Peminjaman Dibatalkan';

        // Get sarana list for filter
        $saranas = \App\Models\Sarana::where('status', 'aktif')->get();

        return view('admin.peminjamandibatalkan', compact('peminjamanDibatalkan', 'search', 'sort', 'title', 'saranas', 'saranaFilter', 'dateFrom', 'dateTo'));
    }
}
