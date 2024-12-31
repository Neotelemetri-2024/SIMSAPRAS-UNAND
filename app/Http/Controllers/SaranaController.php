<?php

namespace App\Http\Controllers;

use App\Models\Sarana;
use App\Models\KategoriSarana;
use Illuminate\Http\Request;
use App\Models\Peminjaman;
use App\Models\Pengumuman;
use App\Models\Ruangan;
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
        
        $sarana = $query->latest()->paginate(5);
        $kategori = KategoriSarana::where('status', 'aktif')->get();
                
        return view('admin.sarana', compact('sarana', 'kategori', 'search', 'filter'));
    }

    public function store(Request $request)
    {
        try {
            // Check main image size first
            if ($request->hasFile('gambar')) {
                $mainImage = $request->file('gambar');
                if ($mainImage->getSize() > 2048 * 1024) { // 2MB in bytes
                    return response()->json([
                        'success' => false,
                        'message' => 'Gambar utama tidak boleh lebih dari 2MB'
                    ]);
                }
            }

            // Check additional images size
            if ($request->hasFile('gambar_tambahan')) {
                foreach ($request->file('gambar_tambahan') as $index => $image) {
                    if ($image->getSize() > 2048 * 1024) { // 2MB in bytes
                        return response()->json([
                            'success' => false,
                            'message' => 'Gambar tambahan ke-' . ($index + 1) . ' tidak boleh lebih dari 2MB'
                        ]);
                    }
                }
            }

            // Validasi input
            $validated = $request->validate([
                'IdKategori' => 'required|exists:kategori_sarana,id',
                'nama' => 'required|string|max:255',
                'deskripsi' => 'required|string',
                'fasilitas' => 'required|string',
                'kapasitas' => 'nullable|integer|min:0',
                'tarifunand' => 'nullable|integer|min:0',
                'tarifumum' => 'nullable|integer|min:0',
                'gambar' => 'required|image|mimes:jpeg,png,jpg|max:2048',
                'gambar_tambahan.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            ], [
                'gambar.max' => 'Gambar utama tidak boleh lebih dari 2MB',
                'gambar_tambahan.*.max' => 'Gambar tambahan tidak boleh lebih dari 2MB'
            ]);

            // Cek sarana dengan nama yang sama dan status aktif
            $existingSarana = Sarana::where('nama', $validated['nama'])
                ->where('status', 'aktif')
                ->exists();

            if ($existingSarana) {
                return response()->json([
                    'success' => false,
                    'message' => 'Sarana dengan nama tersebut sudah ada dan masih aktif'
                ]);
            }

            // Handle upload gambar utama
            if ($request->hasFile('gambar')) {
                $validated['gambar'] = $request->file('gambar')->store('sarana', 'public');
            }

            // Buat record sarana baru
            $sarana = Sarana::create($validated);

            // Handle upload gambar tambahan
            if ($request->hasFile('gambar_tambahan')) {
                foreach ($request->file('gambar_tambahan') as $image) {
                    $path = $image->store('sarana/tambahan', 'public');
                    $sarana->gambarSarana()->create([
                        'gambar' => $path,
                    ]);
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'Data berhasil disimpan',
                'redirect' => route('sarana.index')
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ]);
        }
    }


    public function update(Request $request, Sarana $sarana)
    {
        try {
            // Check main image size first
            if ($request->hasFile('gambar')) {
                $mainImage = $request->file('gambar');
                if ($mainImage->getSize() > 2048 * 1024) { // 2MB in bytes
                    return response()->json([
                        'success' => false,
                        'message' => 'Gambar utama tidak boleh lebih dari 2MB'
                    ]);
                }
            }

            // Check additional images size
            if ($request->hasFile('gambar_tambahan')) {
                foreach ($request->file('gambar_tambahan') as $index => $image) {
                    if ($image->getSize() > 2048 * 1024) { // 2MB in bytes
                        return response()->json([
                            'success' => false,
                            'message' => 'Gambar tambahan ke-' . ($index + 1) . ' tidak boleh lebih dari 2MB'
                        ]);
                    }
                }
            }

            // Validasi input
            $validated = $request->validate([
                'IdKategori' => 'required|exists:kategori_sarana,id',
                'nama' => 'required|string|max:255|unique:sarana,nama,'.$sarana->id,
                'deskripsi' => 'required|string',
                'fasilitas' => 'required|string',
                'kapasitas' => 'nullable|integer|min:0',
                'tarifunand' => 'nullable|integer|min:0',
                'tarifumum' => 'nullable|integer|min:0',
                'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
                'gambar_tambahan.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            ], [
                'gambar.max' => 'Gambar utama tidak boleh lebih dari 2MB',
                'gambar_tambahan.*.max' => 'Gambar tambahan tidak boleh lebih dari 2MB'
            ]);

            // Handle deletion of existing additional images
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
                foreach ($request->file('gambar_tambahan') as $image) {
                    $path = $image->store('sarana/tambahan', 'public');
                    $sarana->gambarSarana()->create([
                        'gambar' => $path
                    ]);
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'Data Sarana berhasil diperbarui'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ]);
        }
    }
    
    public function daftarSarana(Request $request)
    {
        $search = $request->input("search");
        $filterKategori = $request->input("kategori");

        // Query untuk sarana
        $sarana = Sarana::withCount('peminjaman')
            ->with('kategoriSarana')
            ->when($search, function ($query, $search) {
                $query->where('nama', 'like', "%{$search}%")
                    ->orWhere('deskripsi', 'like', "%{$search}%")
                    ->orWhere('fasilitas', 'like', "%{$search}%");
            })
            ->when($filterKategori, function ($query, $filterKategori) {
                $query->where('IdKategori', $filterKategori);
            })
            ->orderBy('peminjaman_count', 'desc')
            ->where('status', 'aktif')
            ->paginate(6);

        // Data untuk trend chart (6 bulan terakhir)
        $trendData = Peminjaman::selectRaw('DATE_FORMAT(created_at, "%b %Y") as month, YEAR(created_at) as year, MONTH(created_at) as month_num, COUNT(*) as total')
            ->whereRaw('created_at >= DATE_SUB(NOW(), INTERVAL 6 MONTH)')
            ->groupBy('year', 'month_num', 'month')
            ->orderBy('year')
            ->orderBy('month_num')
            ->get();

        $topBorrowed = Sarana::withCount('peminjaman')
            ->where('status', 'aktif')  // Tambahkan ini jika perlu
            ->orderBy('peminjaman_count', 'desc')
            ->limit(5)
            ->get();

        $pengumuman = Pengumuman::latest()->limit(3)->get();

        // Get categories for filter
        $kategori = KategoriSarana::where('status', 'aktif')->get();

        return view('sarana', compact(
            'sarana',
            'search',
            'filterKategori',
            'kategori', 
            'trendData',
            'topBorrowed',
            'pengumuman'
        ));
    }

    public function userShow(Sarana $sarana, Request $request)
    {
        $search = $request->input('search');
        
        // Load relationships
        $sarana->load(['kategoriSarana', 'gambarSarana', 'penjaga']);
        
        // Initialize $ruangan and $events as empty collections by default
        $ruangan = collect();
        $events = []; 
        
        // Query ruangan if kategori is Gedung Beruangan
        if ($sarana->kategoriSarana->jenis === 'Gedung Beruangan') {
            $ruangan = $sarana->ruangan()
                ->when($search, function ($query, $search) {
                    $query->where('nama', 'like', "%{$search}%")
                        ->orWhere('deskripsi', 'like', "%{$search}%");
                })
                ->latest()
                ->where('status', 'aktif')
                ->paginate(6);
        } else {
            // Get peminjaman data for non-Gedung Beruangan
            $peminjaman = Peminjaman::with(['tanggalPeminjaman.jadwal']) // Changed this line
                ->where('idSarana', $sarana->id)
                ->whereIn('status', ['diajukan', 'disetujui', 'diproses', 'diajukanbatal'])
                ->get();
                
            // Create events array
            foreach($peminjaman as $item) {
                foreach($item->tanggalPeminjaman as $tanggal) {
                    $events[] = [
                        'id' => $item->id,
                        'title' => $item->kegiatan,
                        'start' => date('Y-m-d', strtotime($tanggal->tanggal)) . 'T' . $tanggal->jadwal->mulai,
                        'end' => date('Y-m-d', strtotime($tanggal->tanggal)) . 'T' . $tanggal->jadwal->selesai,
                        'status' => $item->status
                    ];
                }
            }
        }
        
        return view('detailsarana', compact('sarana', 'ruangan', 'search', 'events'));
    }
    
    public function destroy(Sarana $sarana)
    {
        try {
            DB::beginTransaction();

            $sarana->update(['status' => 'nonaktif']);
            foreach ($sarana->ruangan as $ruangan) {
                $ruangan->update(['status' => 'nonaktif']);
            }
            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Sarana berhasil dinonaktifkan',
                'redirect' => route('sarana.index')
            ]);
                
        } catch (\Exception $e) {
            DB::rollBack();
            
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
                'redirect' => route('sarana.index')
            ]);
        }
    }

    public function activate(Sarana $sarana)
    {
        try {
            DB::beginTransaction();
            
            $sarana->update(['status' => 'aktif']);
            
            $ruangans = Ruangan::where('IdSarana', $sarana->id)->get();
            
            foreach ($ruangans as $ruangan) {
                $ruangan->update(['status' => 'aktif']);
            }
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Sarana berhasil diaktifkan',
                'redirect' => route('sarana.index')
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
                'redirect' => route('sarana.index')
            ]);
        }
    }
}