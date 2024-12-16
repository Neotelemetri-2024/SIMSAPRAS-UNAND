<?php

namespace App\Http\Controllers;

use App\Models\KategoriSarana;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    // Menampilkan semua kategori sarana
    public function index()
    {
        $kategori = KategoriSarana::all();

        return view('admin.kategori', compact('kategori'));
    }

    // Menyimpan kategori sarana baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'jenis' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
        ]);

        KategoriSarana::create($validated);

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil ditambahkan');
    }

    // Memperbarui kategori sarana
    public function update(Request $request, KategoriSarana $kategori)
    {
        $validated = $request->validate([
            'jenis' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
        ]);

        $kategori->update($validated);

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil diperbarui');
    }

    // Menghapus kategori sarana
    public function destroy(KategoriSarana $kategori)
    {
        try {
            $kategori->delete();

            return redirect()->route('kategori.index')->with('success', 'Kategori berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->route('kategori.index')->with('error', 'Gagal menghapus kategori: ' . $e->getMessage());
        }
    }
}