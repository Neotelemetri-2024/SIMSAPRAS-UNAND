<?php

namespace App\Http\Controllers;

use App\Models\Ruangan;
use App\Models\GambarRuangan;
use App\Models\Peminjaman;
use App\Models\Sarana;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

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
            return redirect()->route('ruangan.index', $idSarana)
                           ->with('success', 'Ruangan berhasil ditambahkan');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Terjadi kesalahan saat menambahkan ruangan');
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
            return redirect()->route('ruangan.index', $idSarana)
                           ->with('success', 'Ruangan berhasil diperbarui');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Terjadi kesalahan saat memperbarui ruangan');
        }
    }

    public function destroy($idSarana, $id)
    {
        $ruangan = Ruangan::findOrFail($id);

        DB::beginTransaction();

        try {
            // Delete main image
            if ($ruangan->gambar) {
                Storage::delete($ruangan->gambar);
            }

            // Delete additional images
            foreach ($ruangan->gambarRuangan as $gambar) {
                Storage::delete($gambar->gambar);
                $gambar->delete();
            }

            // Delete ruangan
            $ruangan->delete();

            DB::commit();
            return redirect()->route('ruangan.index', $idSarana)
                           ->with('success', 'Ruangan berhasil dihapus');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Terjadi kesalahan saat menghapus ruangan');
        }
    }

    public function deleteImage($idSarana, $id)
    {
        try {
            $gambar = GambarRuangan::findOrFail($id);
            
            // Verify that this image belongs to a room in the correct sarana
            if ($gambar->ruangan->idSarana != $idSarana) {
                return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
            }
            
            // Delete file
            Storage::delete($gambar->gambar);
            
            // Delete record
            $gambar->delete();
            
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
    public function show(Ruangan $ruangan)
    {
        // Load relationships
        $ruangan->load(['sarana', 'gambarRuangan']);
        
        // Get peminjaman data
        $peminjaman = Peminjaman::with(['tanggalPeminjaman', 'jadwal'])
            ->where('idRuangan', $ruangan->id)
            ->whereIn('status', ['diajukan', 'disetujui'])
            ->get();
            
        // Format events for calendar
        $events = [];
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
        
        return view('detailruangan', compact('ruangan', 'events'));
    }
}