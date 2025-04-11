<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use App\Models\Notifikasi;
use Illuminate\Http\Request;
use App\Services\NotificationService;

class PeminjamanDiprosesController extends Controller
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
            ->where('status', 'diproses');
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

        $peminjamanDiproses = $query->paginate(10);
        $title = 'Peminjaman Diproses';

        return view('admin.peminjamandiproses', compact('peminjamanDiproses', 'search', 'sort', 'title'));
    }

    public function updateStatusDiproses(Request $request, $id)
    {
        try {
            $request->validate([
                'status' => 'required|in:disetujui,diproses,ditolak,dibatalkan,diajukan',
                'feedbackPenolakan' => 'nullable|required_if:status,ditolak|string|max:500',
                'suratDisposisi' => 'required_if:status,disetujui|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048',
            ]);
    
            $peminjaman = Peminjaman::with('user')->findOrFail($id);
            $oldStatus = $peminjaman->status;
    
            if ($request->status === 'disetujui' && !$peminjaman->buktiPembayaran) {
                return response()->json([
                    'success' => false,
                    'message' => 'Peminjaman tidak dapat disetujui karena belum ada bukti pembayaran.'
                ], 422);
            }
    
            if ($request->status === 'disetujui') {
                $peminjaman->disetujui_oleh = auth()->id();
                $peminjaman->disetujui_at = now();
                $peminjaman->suratDisposisi = $request->file('suratDisposisi')->store('peminjaman/disposisi', 'public');
                $peminjaman->statusPembayaran = 'lunas';
            }

        if ($request->status === 'disetujui') {
                $peminjaman->disetujui_oleh = auth()->id();
                $peminjaman->disetujui_at = now();
                $peminjaman->suratDisposisi = $request->file('suratDisposisi')->store('peminjaman/disposisi', 'public');
                $peminjaman->statusPembayaran = 'lunas';
            } elseif ($request->status === 'ditolak') {
                $peminjaman->ditolak_oleh = auth()->id();
                $peminjaman->ditolak_at = now();
            } elseif ($request->status === 'diproses') {
                $peminjaman->diproses_oleh = auth()->id();
                $peminjaman->diproses_at = now();
            } elseif ($request->status === 'dibatalkan') {
                $peminjaman->dibatalkan_oleh = auth()->id();
                $peminjaman->dibatalkan_at = now();
            }
    
            if ($request->status === 'diajukan') {
                $peminjaman->status = $peminjaman->statusSebelumBatal;
                $peminjaman->alasanTolakBatal = $request->alasanTolakBatal;
                $peminjaman->statusSebelumBatal = null;
            } elseif ($request->status === 'dibatalkan') {
                $peminjaman->status = 'dibatalkan';
            } else {
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
    
                if ($request->status === 'disetujui') {
                    $peminjaman->status = 'disetujui';
                } elseif ($request->status === 'ditolak') {
                    $peminjaman->feedbackPenolakan = $request->feedbackPenolakan;
                    $peminjaman->status = 'ditolak';
                } 
    
            }
    
            $peminjaman->save();
    
            $userMessage = match($peminjaman->status) {
                'ditolak' => "Peminjaman Anda ditolak dengan alasan " . $request->feedbackPenolakan,
                'diproses' => "Peminjaman Anda sedang diproses. Silakan melakukan pembayaran sebesar Rp " . number_format($peminjaman->totalTarif, 0, ',', '.'),
                'disetujui' => "Selamat! Peminjaman Anda telah disetujui. Silakan print surat disposisi dan berikan kepada penjaga gedung.",
                'dibatalkan' => "Pembatalan peminjaman Anda telah disetujui.",
                'diajukan' => "Pembatalan peminjaman Anda ditolak dengan alasan " . $request->alasanTolakBatal,
                default => "Status peminjaman Anda telah diubah menjadi " . $peminjaman->status
            };
    
            // Tulis ke database
            Notifikasi::create([
                'idPeminjaman' => $peminjaman->id,
                'penerima' => $peminjaman->user->id,
                'judul' => "Update Status Peminjaman",
                'isi' => $userMessage,
                'isRead' => false
            ]);
    
            // Kirim response sukses
            $response = ['success' => true, 'message' => 'Status peminjaman berhasil diperbarui'];
    
            // Kirim notifikasi Pusher
            $this->notificationService->sendToUser(
                $peminjaman->user->id,
                "Update Status Peminjaman",
                $userMessage,
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

}