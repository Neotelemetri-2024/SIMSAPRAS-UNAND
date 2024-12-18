<?php

namespace App\Http\Controllers;

use App\Models\Sarana;
use App\Models\KategoriSarana;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

DB::enableQueryLog();

class SaranaController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input("search");
        $filterKategori = $request->input("kategori");

        $sarana = Sarana::with('kategoriSarana')
        ->when($search, function ($query, $search) {
            $query->where('nama', 'like', "%{$search}%")
                  ->orWhere('deskripsi', 'like', "%{$search}%")
                  ->orWhere('fasilitas', 'like', "%{$search}%");
        })
        ->when($filterKategori, function ($query, $filterKategori) {
            $query->where('IdKategori', $filterKategori);
        })
        ->paginate(5);

        //

        $kategori = KategoriSarana::all();

        return view('admin.sarana', compact('sarana', 'kategori', 'search', 'filterKategori'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'IdKategori' => 'required|exists:kategori_sarana,id',
            'nama' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'fasilitas' => 'required|string',
            'gambar' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $validated['gambar'] = $request->hasFile('gambar')
            ? $request->file('gambar')->store('sarana', 'public')
            : null;

        Sarana::create($validated);

        return redirect()->route('sarana.index')->with('success', 'Data berhasil ditambahkan');
    }

    public function update(Request $request, Sarana $sarana)
    {
        $validated = $request->validate([
            'IdKategori' => 'required|exists:kategori_sarana,id',
            'nama' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'fasilitas' => 'required|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('gambar')) {
            if ($sarana->gambar) {
                Storage::disk('public')->delete($sarana->gambar);
            }
            $validated['gambar'] = $request->file('gambar')->store('sarana', 'public');
        }

        $sarana->update($validated);

        return redirect()->route('sarana.index')->with('success', 'Data berhasil diperbarui');
    }

    public function destroy(Sarana $sarana)
    {
        try {
            if ($sarana->gambar) {
                Storage::disk('public')->delete($sarana->gambar);
            }
            $sarana->delete();

            return redirect()->route('sarana.index')->with('success', 'Data berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->route('sarana.index')->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }

}
