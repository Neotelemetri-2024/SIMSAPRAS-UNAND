<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\Notifikasi;
use Illuminate\Http\Request;
use App\Services\NotificationService;


class PeminjamanAdminController extends Controller
{
    protected $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }



    private function getPeminjaman(Request $request, $status, $title)
    {
        $search = $request->input('search');
        $sort = $request->input('sort');
    
        $query = Peminjaman::with([
            'user', 
            'sarana', 
            'tanggalPeminjaman.jadwal' // Update relationship loading
        ])
            ->where('status', $status);
    
        if ($search) {
            $query->whereHas('user', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            });
        }
    
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
        try {
            $request->validate([
                'status' => 'required|in:disetujui,diproses,ditolak',
                'feedbackPenolakan' => 'nullable|required_if:status,ditolak|string|max:500',
                'suratPeminjaman' => 'nullable|file|mimes:pdf|max:2048',
                'rundown' => 'nullable|file|mimes:pdf|max:2048',
                'estimasiPeserta' => 'nullable|integer|min:0',
                'tarif' => 'nullable|integer|min:0',
            ]);
    
            $peminjaman = Peminjaman::with('user')->findOrFail($id);
            $oldStatus = $peminjaman->status;
    
            // Update file uploads dan data lainnya
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
    
            // Update status
            $peminjaman->status = $request->status;
            if ($request->status === 'ditolak') {
                $peminjaman->feedbackPenolakan = $request->feedbackPenolakan;
            }
    
            // Auto-update status jika ada tarif
            if ($request->status === 'disetujui' && $peminjaman->tarif > 0) {
                $peminjaman->status = 'diproses';
            }
    
            $peminjaman->save();
    
            // Siapkan pesan notifikasi untuk user
            $userMessage = match($peminjaman->status) {
                'ditolak' => "Peminjaman Anda ditolak dengan alasan: " . $request->feedbackPenolakan,
                'diproses' => "Peminjaman Anda sedang diproses. Silakan melakukan pembayaran sebesar Rp " . number_format($peminjaman->tarif, 0, ',', '.'),
                'disetujui' => "Selamat! Peminjaman Anda telah disetujui.",
                default => "Status peminjaman Anda telah diubah menjadi " . $peminjaman->status
            };
    
            // Kirim notifikasi ke user
            $notificationSent = $this->notificationService->sendToUser(
                $peminjaman->user->id,  // Langsung kirim userId
                "Update Status Peminjaman",
                $userMessage,
                $peminjaman->id
            );
            //
    
            $response = [
                'success' => true,
                'message' => 'Status peminjaman berhasil diperbarui'
            ];
    
            if (!$notificationSent) {
                $response['notification_status'] = 'Notification might have failed to send';
            }
    
            return response()->json($response);
    
        } catch (\Exception $e) {
            \Log::error('Update status error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
}