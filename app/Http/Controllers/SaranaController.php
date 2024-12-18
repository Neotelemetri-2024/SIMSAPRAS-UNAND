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
    
    $sarana = Sarana::with(['kategoriSarana', 'gambarSarana'])
        ->when($search, function ($query, $search) {
            $query->where('nama', 'like', "%{$search}%")
                  ->orWhere('deskripsi', 'like', "%{$search}%")
                  ->orWhere('fasilitas', 'like', "%{$search}%");
        })
        ->when($filterKategori, function ($query, $filterKategori) {
            $query->where('IdKategori', $filterKategori);
        })
        ->paginate(5);

    $kategori = KategoriSarana::all();

    return view('admin.sarana', compact('sarana', 'kategori', 'search', 'filterKategori'));
}

    public function store(Request $request)
{
    $validated = $request->validate([
        'IdKategori' => 'required|exists:kategori_sarana,id',
        'nama' => 'required|string|max:255|unique:sarana,nama',
        'deskripsi' => 'required|string',
        'fasilitas' => 'required|string',
        'gambar' => 'required|image|mimes:jpeg,png,jpg|max:2048', // Gambar utama
        'gambar_tambahan.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Gambar tambahan
    ]);

    // Handle gambar utama
    if ($request->hasFile('gambar')) {
        $validated['gambar'] = $request->file('gambar')->store('sarana', 'public');
    }

    // Create sarana
    $sarana = Sarana::create($validated);

    // Handle gambar tambahan
    if ($request->hasFile('gambar_tambahan')) {
        foreach($request->file('gambar_tambahan') as $image) {
            $path = $image->store('sarana/tambahan', 'public');
            $sarana->gambarSarana()->create([
                'gambar' => $path
            ]);
        }
    }

    return redirect()->route('sarana.index')->with('success', 'Data berhasil ditambahkan');
}

public function update(Request $request, Sarana $sarana)
{
    \Log::info('Request Data:', $request->all());

    $validated = $request->validate([
        'IdKategori' => 'required|exists:kategori_sarana,id',
        'nama' => 'required|string|max:255|unique:sarana,nama,'.$sarana->id,
        'deskripsi' => 'required|string',
        'fasilitas' => 'required|string',
        'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        'gambar_tambahan.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
    ]);

    if ($request->has('delete_images')) {
        $deleteImages = is_array($request->delete_images) ? $request->delete_images : [$request->delete_images];
        
        foreach ($deleteImages as $imageId) {
            \Log::info('Processing image ID: ' . $imageId);
            
            $gambar = DB::table('gambar_sarana')->where('id', $imageId)->first();
            if ($gambar) {
                \Log::info('Found image to delete: ' . $gambar->gambar);
                Storage::disk('public')->delete($gambar->gambar);
                DB::table('gambar_sarana')->where('id', $imageId)->delete();
            }
        }
    }

    // Update data sarana
    $sarana->update($validated);

    // Handle gambar utama jika ada
    if ($request->hasFile('gambar')) {
        if ($sarana->gambar) {
            Storage::disk('public')->delete($sarana->gambar);
        }
        $validated['gambar'] = $request->file('gambar')->store('sarana', 'public');
        $sarana->update(['gambar' => $validated['gambar']]);
    }

    // Handle upload gambar tambahan baru
    if ($request->hasFile('gambar_tambahan')) {
        foreach($request->file('gambar_tambahan') as $image) {
            $path = $image->store('sarana/tambahan', 'public');
            $sarana->gambarSarana()->create([
                'gambar' => $path
            ]);
        }
    }

    return redirect()->route('sarana.index')->with('success', 'Data berhasil diperbarui');
}
    public function daftarSarana(Request $request)
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
        ->paginate(6); // Mengubah jumlah item per halaman menjadi 6 agar sesuai dengan grid

    return view('sarana', compact('sarana', 'search', 'filterKategori'));
}
public function userShow(Sarana $sarana, Request $request)
{
    $search = $request->input('search');
    
    // Load relationships
    $sarana->load(['kategoriSarana', 'gambarSarana', 'penjaga']);
    
    // Initialize $ruangan as empty collection by default
    $ruangan = collect();
    
    // Query ruangan jika kategori adalah Gedung Beruangan
    if ($sarana->kategoriSarana->jenis === 'Gedung Beruangan') {
        $ruangan = $sarana->ruangan()
            ->when($search, function ($query, $search) {
                $query->where('nama', 'like', "%{$search}%")
                      ->orWhere('deskripsi', 'like', "%{$search}%");
            })
            ->paginate(6);
    }
    
    return view('detailsarana', compact('sarana', 'ruangan', 'search'));
}

}
