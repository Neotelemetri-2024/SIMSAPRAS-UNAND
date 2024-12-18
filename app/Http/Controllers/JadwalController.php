<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use Illuminate\Http\Request;

class JadwalController extends Controller
{
    // Menampilkan semua jadwal
    public function index()
    {
        $jadwal = Jadwal::all();

        return view('admin.jadwal', compact('jadwal'));
    }

    // Menyimpan jadwal baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'shift' => 'required|string|max:255',
            'mulai' => 'required|date_format:H:i',
            'selesai' => 'required|date_format:H:i',
        ]);

        Jadwal::create($validated);

        return redirect()->route('jadwal.index')->with('success', 'Jadwal berhasil ditambahkan');
    }

    // Memperbarui jadwal
    public function update(Request $request, Jadwal $jadwal)
    {
        try {
            $validated = $request->validate([
                'shift' => 'required|string|max:255',
                'mulai' => 'required',
                'selesai' => 'required',
            ]);
            // Format waktu sebelum update
            $validated['mulai'] = date('H:i', strtotime($request->mulai));
            $validated['selesai'] = date('H:i', strtotime($request->selesai));
            $jadwal->update($validated);
            return redirect()->route('jadwal.index')->with('success', 'Jadwal berhasil diperbarui');
        } catch (\Exception $e) {
            return redirect()->route('jadwal.index')
                ->with('error', 'Gagal memperbarui jadwal: ' . $e->getMessage());
        }
    }

    // Menghapus jadwal
    public function destroy(Jadwal $jadwal)
    {
        try {
            $jadwal->delete();

            return redirect()->route('jadwal.index')->with('success', 'Jadwal berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->route('jadwal.index')->with('error', 'Gagal menghapus jadwal: ' . $e->getMessage());
        }
    }
}