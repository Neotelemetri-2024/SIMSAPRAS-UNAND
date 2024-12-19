<?php

namespace App\Http\Controllers;

use App\Models\Sarana;
use App\Models\KategoriSarana;
use Illuminate\Http\Request;
use App\Models\Peminjaman;
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
                
                $gambar = DB::table('gambar_sarana')->where('id', $imageId)->first();
                if ($gambar) {
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
        $filterKategori = $request->input('kategori');
        
        // Load relationships
        $sarana->load(['kategoriSarana', 'gambarSarana', 'penjaga']);
        
        // Initialize $ruangan and $events as empty collections by default
        $ruangan = collect();
        $events = [];  // Change to array instead of collection
        
        // Query ruangan if kategori is Gedung Beruangan
        if ($sarana->kategoriSarana->jenis === 'Gedung Beruangan') {
            $ruangan = $sarana->ruangan()
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
    }
    public function destroy(Sarana $sarana)
    {
        // Hapus file gambar
        if ($sarana->gambar) {
            Storage::disk('public')->delete($sarana->gambar);
        }

        // Hapus gambar sarana
        $sarana->gambarSarana->each(function ($gambar) {
            Storage::disk('public')->delete($gambar->gambar);
        });

        // Hapus gambar ruangan
        $sarana->ruangan->each(function ($ruangan) {
            $ruangan->gambarRuangan->each(function ($gambar) {
                Storage::disk('public')->delete($gambar->gambar);
            });
            $ruangan->gambarRuangan()->delete();
            // Hapus peminjaman terkait ruangan
            $ruangan->peminjaman()->delete();
        });

        // Lanjutkan dengan penghapusan lainnya
        $sarana->gambarSarana()->delete();
        $sarana->ruangan()->delete();
        $sarana->penjaga()->delete();
        $sarana->delete();

        return redirect()->route('sarana.index')->with('success', 'Data berhasil dihapus');
    }
}