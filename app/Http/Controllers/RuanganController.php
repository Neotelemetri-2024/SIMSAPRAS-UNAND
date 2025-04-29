<?php

namespace App\Http\Controllers;

use App\Models\Ruangan;
use App\Models\GambarRuangan;
use App\Models\Peminjaman;
use App\Models\Sarana;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class RuanganController extends Controller
{
    public function index($idSarana)
    {
        $search = request('search');
        $status = request('status');
        
        $ruangan = Ruangan::with(['gambarRuangan'])
            ->where('idSarana', $idSarana)
            ->when($search, function($query, $search) {
                return $query->where(function($q) use ($search) {
                    $q->where('nama', 'like', "%{$search}%")
                      ->orWhere('deskripsi', 'like', "%{$search}%")
                      ->orWhere('fasilitas', 'like', "%{$search}%");
                });
            })
            ->when($status, function ($query, $status) {
                $query->where('status', $status);
            })
            ->latest()
            ->paginate(5);
            
        $sarana = Sarana::findOrFail($idSarana);
        
        return view('admin.ruangan', compact('ruangan', 'sarana'));
    }

    public function store(Request $request, $idSarana)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'kapasitas' => 'required|integer',
            'fasilitas' => 'required|string',
            'tariformawa' => 'required|integer',
            'tarifunit' => 'required|integer',
            'tarifumum' => 'required|integer',
            'kelas' => 'required|boolean',
            'gambar' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'additional_images.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        DB::beginTransaction();

        try {
            // Upload and store main image
            $mainImagePath = $request->file('gambar')->store('public/ruangan');

            // Create ruangan
            $ruangan = Ruangan::create([
                'idSarana' => $idSarana,
                'nama' => $request->nama,
                'deskripsi' => $request->deskripsi,
                'kapasitas' => $request->kapasitas,
                'fasilitas' => $request->fasilitas,
                'tariformawa' => $request->tariformawa,
                'tarifunit' => $request->tarifunit,
                'tarifumum' => $request->tarifumum,
                'kelas' => $request->kelas,
                'gambar' => $mainImagePath
            ]);

            // Handle additional images
            if ($request->hasFile('additional_images')) {
                foreach ($request->file('additional_images') as $image) {
                    $path = $image->store('public/ruangan/tambahan');
                    GambarRuangan::create([
                        'idRuangan' => $ruangan->id,
                        'gambar' => $path
                    ]);
                }
            }

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Ruangan berhasil ditambahkan',
                'redirect' => route('ruangan.index', $idSarana)
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menambahkan ruangan: ' . $e->getMessage(),
                'redirect' => route('ruangan.index', $idSarana)
            ]);
        }
    }

    public function update(Request $request, $idSarana, $id)
    {
        $ruangan = Ruangan::findOrFail($id);
        
        $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'kapasitas' => 'required|integer',
            'fasilitas' => 'required|string',
            'tariformawa' => 'required|integer',
            'tarifunit' => 'required|integer',
            'tarifumum' => 'required|integer',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'additional_images.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'delete_images.*' => 'nullable|exists:gambar_ruangan,id'
        ]);

        DB::beginTransaction();

        try {
            // Update basic information
            $ruangan->nama = $request->nama;
            $ruangan->deskripsi = $request->deskripsi;
            $ruangan->kapasitas = $request->kapasitas;
            $ruangan->fasilitas = $request->fasilitas;
            $ruangan->tariformawa = $request->tariformawa;
            $ruangan->tarifunit = $request->tarifunit;
            $ruangan->tarifumum = $request->tarifumum;
            
            // Handle main image update
            if ($request->hasFile('gambar')) {
                // Delete old image
                if ($ruangan->gambar) {
                    Storage::delete($ruangan->gambar);
                }
                // Store new image
                $ruangan->gambar = $request->file('gambar')->store('public/ruangan');
            }

            $ruangan->save();

            // Handle image deletions
            if ($request->has('delete_images')) {
                $deleteImages = is_array($request->delete_images) ? $request->delete_images : [$request->delete_images];
                foreach ($deleteImages as $imageId) {
                    $gambar = GambarRuangan::find($imageId);
                    if ($gambar && $gambar->idRuangan == $id) {
                        Storage::delete($gambar->gambar);
                        $gambar->delete();
                    }
                }
            }

            // Handle additional images
            if ($request->hasFile('additional_images')) {
                foreach ($request->file('additional_images') as $image) {
                    $path = $image->store('public/ruangan/tambahan');
                    GambarRuangan::create([
                        'idRuangan' => $ruangan->id,
                        'gambar' => $path
                    ]);
                }
            }

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Ruangan berhasil diperbarui',
                'redirect' => route('ruangan.index', $idSarana)
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
                'redirect' => route('ruangan.index', $idSarana)
            ]);
        }
    }

    public function destroy($idSarana, $id)
    {
        $ruangan = Ruangan::findOrFail($id);
        
        DB::beginTransaction();
        try {
            $ruangan->update(['status' => 'nonaktif']);
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Ruangan berhasil dinonaktifkan',
                'redirect' => route('ruangan.index', $idSarana)
            ]);
                
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
                'redirect' => route('ruangan.index', $idSarana)
            ]);
        }
    }

    public function deleteImage($idSarana, $id)
    {
        try {
            $gambar = GambarRuangan::findOrFail($id);
            
            if ($gambar->ruangan->idSarana != $idSarana) {
                return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
            }
            
            Storage::delete($gambar->gambar);
            $gambar->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Gambar berhasil dihapus',
                'redirect' => route('ruangan.index', $idSarana)
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
                'redirect' => route('ruangan.index', $idSarana)
            ]);
        }
    }
    
    public function show(Ruangan $ruangan)
    {
        $ruangan->load(['sarana', 'gambarRuangan']);
        $admin = User::whereHas('saranaAccess', function($query) use ($ruangan) {
            $query->where('sarana_id', $ruangan->idSarana);
        })->where('role', 'admin')->first();
        $peminjaman = Peminjaman::with(['tanggalPeminjaman.jadwal'])
            ->where('idRuangan', $ruangan->id)
            ->whereIn('status', ['diajukan', 'disetujui', 'diajukanbatal', 'diproses'])
            ->get();
        $events = [];
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
        
        return view('detailruangan', compact('ruangan', 'events', 'admin'));
    }

    public function activate($idSarana, $id)
    {
        $ruangan = Ruangan::findOrFail($id);
        
        DB::beginTransaction();
        try {
            $ruangan->update(['status' => 'aktif']);
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Ruangan berhasil diaktifkan',
                'redirect' => route('ruangan.index', $idSarana)
            ]);
                
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
                'redirect' => route('ruangan.index', $idSarana)
            ]);
        }
    }
}