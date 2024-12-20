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
        $filter = $request->input("filter");
        
        $query = Sarana::with(['kategoriSarana', 'gambarSarana']);
        
        // Handle pencarian
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('deskripsi', 'like', "%{$search}%")
                  ->orWhere('fasilitas', 'like', "%{$search}%");
            });
        }
        
        // Handle filter
        if ($filter) {
            if (str_starts_with($filter, 'kategori_')) {
                $kategoriId = substr($filter, 9); // Mengambil ID setelah 'kategori_'
                $query->where('IdKategori', $kategoriId);
            } elseif (str_starts_with($filter, 'status_')) {
                $status = substr($filter, 7); // Mengambil status setelah 'status_'
                $query->where('status', $status);
            }
        }
        
        $sarana = $query->paginate(5);
        $kategori = KategoriSarana::all();
        
        return view('admin.sarana', compact('sarana', 'kategori', 'search', 'filter'));
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
                      ->orWhere('deskripsi', 'like', "%{$search}%");
            })
            ->paginate(6);
    } else {
        // Get peminjaman data for non-Gedung Beruangan
        $peminjaman = Peminjaman::with(['tanggalPeminjaman', 'jadwal'])
            ->where('idSarana', $sarana->id)
            ->whereIn('status', ['diajukan', 'disetujui'])
            ->get();
            
        // Create events array
        foreach($peminjaman as $item) {
            foreach($item->tanggalPeminjaman as $tanggal) {
                $events[] = [
                    'id' => $item->id,
                    'title' => $item->kegiatan,
                    'start' => date('Y-m-d', strtotime($tanggal->tanggal)) . 'T' . $item->jadwal->mulai,
                    'end' => date('Y-m-d', strtotime($tanggal->tanggal)) . 'T' . $item->jadwal->selesai,
                    'status' => $item->status
                ];
            }
        }
    }
    
    return view('detailsarana', compact('sarana', 'ruangan', 'search', 'events'));
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