<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peminjaman;
use App\Models\Jadwal;
use App\Models\Ruangan;
use App\Models\Tanggal;
use App\Models\Sarana;

class PeminjamanController extends Controller
{
    public function create(Request $request)
    {
        // Validasi request
        if (!$request->has('sarana_id') && !$request->has('ruangan_id')) {
            return redirect()->back()->with('error', 'Data tidak lengkap');
        }

        $jadwals = Jadwal::all();
        $selectedDates = $request->selected_dates;

        // Jika peminjaman ruangan
        if ($request->has('ruangan_id')) {
            $ruangan = Ruangan::with('sarana')->findOrFail($request->ruangan_id);
            $sarana = $ruangan->sarana;
            
            return view('peminjaman', compact('sarana', 'ruangan', 'selectedDates', 'jadwals'));
        }
        
        // Jika peminjaman sarana langsung
        $sarana = Sarana::findOrFail($request->sarana_id);
        
        return view('peminjaman', compact('sarana', 'selectedDates', 'jadwals'));
    }

    public function store(Request $request)
    {
        // Validasi dasar
        $validationRules = [
            'idSarana' => 'required|exists:sarana,id',
            'idJadwal' => 'required|exists:jadwal,id',
            'kegiatan' => 'required|string|max:255',
            'suratPeminjaman' => 'required|file|mimes:pdf,doc,docx|max:2048',
            'rundown' => 'required|file|mimes:pdf,doc,docx|max:2048',
            'instansi' => 'required|string|max:255',
            'estimasiPeserta' => 'required|integer|min:1',
            'selected_dates' => 'required|string'
        ];

        // Tambahkan validasi ruangan jika ada
        if ($request->has('idRuangan')) {
            $validationRules['idRuangan'] = 'required|exists:ruangan,id';
            
            // Validasi kapasitas ruangan
            $ruangan = Ruangan::find($request->idRuangan);
            if ($request->estimasiPeserta > $ruangan->kapasitas) {
                return back()
                    ->withInput()
                    ->withErrors(['estimasiPeserta' => 'Jumlah peserta melebihi kapasitas ruangan']);
            }
        }

        $validated = $request->validate($validationRules);

        // Upload files
        $suratPath = $request->file('suratPeminjaman')
            ->store('peminjaman/surat', 'public');
        $rundownPath = $request->file('rundown')
            ->store('peminjaman/rundown', 'public');

        // Buat array data peminjaman
        $peminjamanData = [
            'idUser' => auth()->id(),
            'idSarana' => $validated['idSarana'],
            'idJadwal' => $validated['idJadwal'],
            'kegiatan' => $validated['kegiatan'],
            'suratPeminjaman' => $suratPath,
            'rundown' => $rundownPath,
            'instansi' => $validated['instansi'],
            'estimasiPeserta' => $validated['estimasiPeserta'],
            'status' => 'diajukan'
        ];

        // Tambahkan idRuangan jika ada
        if ($request->has('idRuangan')) {
            $peminjamanData['idRuangan'] = $validated['idRuangan'];
        }

        // Create peminjaman
        $peminjaman = Peminjaman::create($peminjamanData);

        // Create tanggal peminjaman
        $selectedDates = json_decode($validated['selected_dates']);
        foreach ($selectedDates as $date) {
            $peminjaman->tanggalPeminjaman()->create([
                'tanggal' => $date
            ]);
        }

        return redirect()->route('peminjaman.index')
            ->with('success', 'Pengajuan peminjaman berhasil dikirim');
    }

    public function show(Peminjaman $peminjaman)
    {
        // Load relationships
        $peminjaman->load([
            'sarana', 
            'ruangan', 
            'jadwal', 
            'tanggalPeminjaman',
            'user'
        ]);

        return view('peminjaman.show', compact('peminjaman'));
    }

    public function index()
    {
        $peminjamans = Peminjaman::with(['sarana', 'ruangan', 'jadwal'])
            ->where('idUser', auth()->id())
            ->latest()
            ->paginate(10);

        return view('peminjaman.index', compact('peminjamans'));
    }

    public function cancel(Peminjaman $peminjaman, Request $request)
    {
        // Validasi bahwa peminjaman milik user yang login
        if ($peminjaman->idUser !== auth()->id()) {
            return back()->with('error', 'Anda tidak memiliki akses untuk membatalkan peminjaman ini');
        }

        // Validasi status peminjaman
        if (!in_array($peminjaman->status, ['diajukan', 'disetujui'])) {
            return back()->with('error', 'Peminjaman tidak dapat dibatalkan');
        }

        $request->validate([
            'alasan_pembatalan' => 'required|string|min:10'
        ]);

        $peminjaman->update([
            'status' => 'dibatalkan',
            'feedbackPembatalan' => $request->alasan_pembatalan
        ]);

        return redirect()->route('peminjaman.index')
            ->with('success', 'Peminjaman berhasil dibatalkan');
    }
}