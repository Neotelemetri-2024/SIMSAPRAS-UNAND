<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RiwayatController extends Controller
{
    public function index(Request $request) {
        $user = auth()->user();
        $sort = $request->input('sort', 'newest'); // Default to newest
        $status = $request->input('status'); // Get status filter
    
        $peminjaman = Peminjaman::with([
            'user', 
            'sarana', 
            'tanggalPeminjaman.jadwal'
        ])
            ->where('idUser', $user->id)
            // Add status filter
            ->when($status, function($query) use ($status) {
                return $query->where('status', $status);
            })
            // Sorting
            ->when($sort == 'newest', function ($query) {
                return $query->orderBy('created_at', 'desc');
            })
            ->when($sort == 'oldest', function ($query) {
                return $query->orderBy('created_at', 'asc');
            })
            ->paginate(5);
    
        // Pass status to view for maintaining filter state
        return view('riwayat', compact('peminjaman', 'sort', 'status'));
    }


    public function uploadBuktiPembayaran(Request $request, $id)
    {
        // Validasi request
        $request->validate([
            'buktiPembayaran' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $peminjaman = Peminjaman::where('idUser', auth()->user()->id)
            ->findOrFail($id);

        try {
            if ($request->hasFile('buktiPembayaran')) {
                // Hapus file lama jika ada
                if ($peminjaman->buktiPembayaran) {
                    Storage::disk('public')->delete($peminjaman->buktiPembayaran);
                }

                // Upload file baru
                $file = $request->file('buktiPembayaran');
                $filename = 'bukti_pembayaran_' . time() . '_' . $peminjaman->id . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('bukti_pembayaran', $filename, 'public');

                // Update database
                $peminjaman->update([
                    'buktiPembayaran' => $path,
                ]);

                return redirect()->back()->with('success', 'Bukti pembayaran berhasil diupload');
            }

            return redirect()->back()->with('error', 'Terjadi kesalahan saat upload file');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
