<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use Illuminate\Http\Request;

class JadwalController extends Controller
{
    public function index()
    {
        $jadwal = Jadwal::all();

        return view('admin.jadwal', compact('jadwal'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'shift' => 'required|string|max:255',
            'mulai' => 'required|date_format:H:i',
            'selesai' => 'required|date_format:H:i',
        ]);

        Jadwal::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Data Jadwal berhasil ditambahkan',
            'redirect' => route('jadwal.index')
        ]);
    }

    public function update(Request $request, Jadwal $jadwal)
    {
        try {
            $validated = $request->validate([
                'shift' => 'required|string|max:255',
                'mulai' => 'required',
                'selesai' => 'required',
            ]);
            $validated['mulai'] = date('H:i', strtotime($request->mulai));
            $validated['selesai'] = date('H:i', strtotime($request->selesai));
            $jadwal->update($validated);
            return response()->json([
                'success' => true,
                'message' => 'Data Jadwal berhasil diperbarui',
                'redirect' => route('jadwal.index')
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => true,
                'message' => 'Gagal memperbarui jadwal: ' . $e->getMessage(),
                'redirect' => route('jadwal.index')
            ]);
        }
    }

    public function destroy(Jadwal $jadwal)
    {
        try {
            $jadwal->delete();

            return response()->json([
                'success' => true,
                'message' => 'Data Jadwal berhasil dihapus',
                'redirect' => route('jadwal.index')
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => true,
                'message' => 'Gagal menghapus jadwal: ' . $e->getMessage(),
                'redirect' => route('jadwal.index')
            ]);
        }
    }
}