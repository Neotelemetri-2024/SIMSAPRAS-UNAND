<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peminjaman;

class BuktiController extends Controller
{
    public function index(Request $request)
    {
        $query = Peminjaman::with(['user', 'sarana', 'ruangan'])
            ->whereNotNull('buktiPembayaran')
            ->where('buktiPembayaran', '!=', '');

        // Filter berdasarkan status pembayaran
        if ($request->filled('status_pembayaran')) {
            if ($request->status_pembayaran == 'lunas') {
                $query->where('statusPembayaran', 'lunas');
            } elseif ($request->status_pembayaran == 'belum_lunas') {
                $query->where(function($q) {
                    $q->whereNull('statusPembayaran')
                      ->orWhere('statusPembayaran', '!=', 'lunas');
                });
            }
        }

        // Filter berdasarkan status peminjam
        if ($request->filled('status_peminjam')) {
            $query->where('statusPeminjam', $request->status_peminjam);
        }

        // Search berdasarkan nama peminjam atau kegiatan
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('kegiatan', 'like', '%' . $request->search . '%')
                  ->orWhereHas('user', function($userQuery) use ($request) {
                      $userQuery->where('name', 'like', '%' . $request->search . '%');
                  });
            });
        }

        $buktiPembayaran = $query->orderBy('created_at', 'desc')
            ->paginate(15)
            ->appends($request->all());

        return view('admin.bukti-bayar', compact('buktiPembayaran'));
    }
}