<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use Illuminate\Http\Request;

class PeminjamanAdminController extends Controller
{
    private function getPeminjaman(Request $request, $status, $title)
    {
        $search = $request->input('search');
        $sort = $request->input('sort');

        $query = Peminjaman::with(['user', 'sarana', 'jadwal', 'tanggalPeminjaman'])
            ->where('status', $status);

        // Pencarian
        if ($search) {
            $query->whereHas('user', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            });
        }

        // Sorting berdasarkan tanggal
        if ($sort && in_array($sort, ['asc', 'desc'])) {
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

        // Gunakan appends untuk menambahkan query string ke pagination
        $peminjamanMasuk = $query->paginate(10);
        if ($search) {
            $peminjamanMasuk->appends('search', $search);
        }
        if ($sort) {
            $peminjamanMasuk->appends('sort', $sort);
        }

        return view('admin.peminjaman', compact('peminjamanMasuk', 'search', 'title'));
    }

    public function PeminjamanMasuk(Request $request)
    {
        return $this->getPeminjaman($request, 'diajukan', 'Peminjaman Masuk');
    }

    public function PeminjamanDiproses(Request $request)
    {
        return $this->getPeminjaman($request, 'diproses', 'Peminjaman Diproses');
    }

    public function PeminjamanDisetujui(Request $request)
    {
        return $this->getPeminjaman($request, 'disetujui', 'Peminjaman Disetujui');
    }

    public function PeminjamanDitolak(Request $request)
    {
        return $this->getPeminjaman($request, 'ditolak', 'Peminjaman Ditolak');
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:disetujui,diproses,ditolak',
            'feedbackPenolakan' => 'nullable|required_if:status,ditolak|string|max:500',
            'suratPeminjaman' => 'nullable|file|mimes:pdf|max:2048',
            'rundown' => 'nullable|file|mimes:pdf|max:2048',
            'estimasiPeserta' => 'nullable|integer|min:0',
            'tarif' => 'nullable|integer|min:0',
        ]);

        $peminjaman = Peminjaman::findOrFail($id);

        // Update status
        $peminjaman->status = $request->status;

        // Handle feedback for rejection
        if ($request->status === 'ditolak') {
            $peminjaman->feedbackPenolakan = $request->feedbackPenolakan;
        }

        if ($request->hasFile('suratPeminjaman')) {
            $peminjaman->suratPeminjaman = $request->file('suratPeminjaman')->store('peminjaman/lampiran');
        }
        if ($request->hasFile('rundown')) {
            $peminjaman->rundown = $request->file('rundown')->store('peminjaman/lampiran');
        }
        if ($request->has('estimasiPeserta')) {
            $peminjaman->estimasiPeserta = $request->estimasiPeserta;
        }
        if ($request->has('tarif')) {
            $peminjaman->tarif = $request->tarif;
        }

        // Auto-update status based on tarif
        if ($request->status === 'disetujui' && $peminjaman->tarif > 0) {
            $peminjaman->status = 'diproses';
        }

        $peminjaman->save();

        return redirect()->back()->with('success', 'Status peminjaman berhasil diperbarui.');
    }
}