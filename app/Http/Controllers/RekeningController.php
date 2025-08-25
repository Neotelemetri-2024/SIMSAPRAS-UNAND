<?php

namespace App\Http\Controllers;

use App\Models\Rekening;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RekeningController extends Controller
{
    public function index()
    {
        $rekening = Rekening::orderBy('created_at', 'desc')->get();
        return view('admin.rekening.index', compact('rekening'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_bank' => 'required|string|max:255',
            'nomor_rekening' => 'required|string|max:255',
            'nama_pemilik' => 'required|string|max:255',
        ]);

        $totalRekening = Rekening::count();
        $isFirstRekening = $totalRekening === 0;

        Rekening::create([
            'nama_bank' => $request->nama_bank,
            'nomor_rekening' => $request->nomor_rekening,
            'nama_pemilik' => $request->nama_pemilik,
            'is_aktif' => $isFirstRekening,
        ]);

        $message = $isFirstRekening 
            ? 'Rekening berhasil ditambahkan dan diaktifkan sebagai rekening utama'
            : 'Rekening berhasil ditambahkan';

        return redirect()->route('admin.rekening.index')->with('success', $message);
    }

    public function update(Request $request, Rekening $rekening)
    {
        $request->validate([
            'nama_bank' => 'required|string|max:255',
            'nomor_rekening' => 'required|string|max:255',
            'nama_pemilik' => 'required|string|max:255',
        ]);

        $rekening->update([
            'nama_bank' => $request->nama_bank,
            'nomor_rekening' => $request->nomor_rekening,
            'nama_pemilik' => $request->nama_pemilik,
        ]);

        return redirect()->route('admin.rekening.index')->with('success', 'Rekening berhasil diperbarui');
    }

    public function destroy(Rekening $rekening)
    {
        if ($rekening->is_aktif) {
            return redirect()->route('admin.rekening.index')->with('error', 'Tidak dapat menghapus rekening yang sedang aktif');
        }

        $rekening->delete();
        return redirect()->route('admin.rekening.index')->with('success', 'Rekening berhasil dihapus');
    }

    public function activate(Rekening $rekening)
    {
        DB::transaction(function () use ($rekening) {
            Rekening::where('is_aktif', true)->update(['is_aktif' => false]);
            $rekening->update(['is_aktif' => true]);
        });

        return redirect()->route('admin.rekening.index')->with('success', 'Rekening berhasil diaktifkan');
    }
}