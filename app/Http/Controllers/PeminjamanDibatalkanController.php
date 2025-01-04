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
        $today = now();

        $query = Peminjaman::with(['user', 'sarana', 'tanggalPeminjaman.jadwal'])
            ->where('status', 'dibatalkan');
        $query->filterByUserAccess(auth()->user());

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

        $peminjamanDibatalkan = $query->paginate(10);
        $title = 'Peminjaman Dibatalkan';

        return view('admin.peminjamandibatalkan', compact('peminjamanDibatalkan', 'search', 'sort', 'title'));
    }

}