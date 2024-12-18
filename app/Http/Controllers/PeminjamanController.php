<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peminjaman;
use App\Models\Jadwal;
use App\Models\Ruangan;
use App\Models\Tanggal;

class PeminjamanController extends Controller
{
    public function kalenderRuangan($idRuangan)
    {
        // Filter peminjaman berdasarkan ruangan dan status
        $peminjaman = Peminjaman::with(['tanggalPeminjaman', 'jadwal', 'ruangan'])
            ->where('idRuangan', $idRuangan)
            ->whereIn('status', ['diajukan', 'disetujui']) // Filter status
            ->get();
    
        // Ambil data ruangan untuk ditampilkan
        $ruangan = Ruangan::find($idRuangan);
    
        // Format data untuk kalender
        $events = $peminjaman->map(function ($item) {
            return [
                'id'    => $item->id,
                'title' => $item->kegiatan . ' - ' . $item->ruangan->nama,
                'start' => $item->tanggalPeminjaman->tanggal . 'T' . $item->jadwal->mulai,
                'end'   => $item->tanggalPeminjaman->tanggal . 'T' . $item->jadwal->selesai,
                'status' => $item->status,
            ];
        });
    
        // Kirim data ke view
        return view('kalender', [
            'events' => $events,
            'ruangan' => $ruangan->nama, // Mengirim nama ruangan ke view
        ]);
    }
    
    
}
