<?php

namespace App\Http\Controllers;

use App\Models\KategoriSarana;
use App\Models\Sarana;
use App\Models\GambarSarana;
use App\Models\Ruangan;
use App\Models\GambarRuangan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

use Illuminate\Http\Request;

class KategoriController extends Controller
{
    // Menampilkan semua kategori sarana
    public function index(Request $request)
    {
        $search = $request->input('search');
        $status = $request->input('status');

        $kategori = KategoriSarana::query()
            ->when($search, function ($query, $search) {
                $query->where('jenis', 'like', "%{$search}%");
            })
            ->when($status, function ($query, $status) {
                $query->where('status', $status);
            })
            ->latest()
            ->paginate(5);

        return view('admin.kategori', compact('kategori'));
    }

    // Menyimpan kategori sarana baru
    public function store(Request $request)
    {
        // Validasi dasar
        $validated = $request->validate([
            'jenis' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
        ]);

        // Validasi tambahan: Cek apakah nama jenis sudah ada dengan status aktif
        $existingActiveCategory = KategoriSarana::where('jenis', $validated['jenis'])
            ->where('status', 'aktif')
            ->exists();

        if ($existingActiveCategory) {
            return redirect()->route('kategori.index')->with('error', 'Kategori sudah ada dan masih aktif');
        }

        // Simpan data
        KategoriSarana::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil disimpan',
            'redirect' => route('kategori.index')
        ]);
    }


    public function update(Request $request, KategoriSarana $kategori)
    {
        $validated = $request->validate([
            'jenis' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
        ]);

        $kategori->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil diperbarui',
            'redirect' => route('kategori.index')
        ]);
    }

    public function destroy(KategoriSarana $kategori)
    {
        try {
            DB::beginTransaction();
            
            $kategori->update(['status' => 'nonaktif']);
            
            $saranas = Sarana::where('IdKategori', $kategori->id)->get();
            
            foreach ($saranas as $sarana) {
                $sarana->update(['status' => 'nonaktif']);
                
                if ($sarana->gambar) {
                    Storage::disk('public')->delete($sarana->gambar);
                }
                
                $gambarSaranas = GambarSarana::where('idSarana', $sarana->id)->get();
                foreach ($gambarSaranas as $gambar) {
                    Storage::disk('public')->delete($gambar->gambar);
                    $gambar->delete();
                }
                
                $ruangans = Ruangan::where('IdSarana', $sarana->id)->get();
                
                foreach ($ruangans as $ruangan) {
                    $ruangan->update(['status' => 'nonaktif']);
                    
                    if ($ruangan->gambar) {
                        Storage::disk()->delete($ruangan->gambar);
                    }
                    
                    $gambarRuangans = GambarRuangan::where('idRuangan', $ruangan->id)->get();
                    foreach ($gambarRuangans as $gambar) {
                        Storage::disk('public')->delete($gambar->gambar);
                        $gambar->delete();
                    }
                }
            }
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Kategori berhasil dinonaktifkan',
                'redirect' => route('kategori.index')
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
            ]);
        }
    }
}