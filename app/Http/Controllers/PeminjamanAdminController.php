<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use Illuminate\Http\Request;

class PeminjamanAdminController extends Controller
{
    public function PeminjamanMasuk(Request $request) {
        $search = $request->input('search');

            $peminjamanMasuk = Peminjaman::with(['user', 'sarana', 'jadwal', 'tanggalPeminjaman'])
            ->where('status', 'diajukan')
            ->when($search, function ($query, $search) {
                return $query->where('nama', 'like', '%' . $search . '%');
            })
            ->paginate(10);

        // Kembalikan data ke view
        return view('admin.peminjaman', compact('peminjamanMasuk', 'search'));
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