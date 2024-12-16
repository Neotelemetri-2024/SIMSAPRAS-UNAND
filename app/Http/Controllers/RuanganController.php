<?php

namespace App\Http\Controllers;

use App\Models\Ruangan;
use App\Models\GambarRuangan;
use App\Models\Sarana;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RuanganController extends Controller
{
   public function index($idSarana)
{
    $ruangan = Ruangan::with(['sarana', 'gambarRuangan'])
                     ->where('idSarana', $idSarana)
                     ->get();
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
        'additional_images.*' => 'image|mimes:jpeg,png,jpg|max:2048'
    ]);

    // Upload main image
    $mainImagePath = $request->file('gambar')->store('public/ruangan');

    // Create ruangan
    $ruangan = Ruangan::create([
        'idSarana' => $idSarana,
        'nama' => $request->nama,
        'gambar' => $mainImagePath,
        'deskripsi' => $request->deskripsi,
        'kapasitas' => $request->kapasitas,
        'fasilitas' => $request->fasilitas
    ]);

    // Handle additional images
    if ($request->hasFile('additional_images')) {
        foreach ($request->file('additional_images') as $image) {
            $path = $image->store('public/ruangan');
            GambarRuangan::create([
                'idRuangan' => $ruangan->id,
                'gambar' => $path
            ]);
        }
    }

    return redirect()->route('ruangan.index', $idSarana)
                    ->with('success', 'Ruangan berhasil ditambahkan');
}

    // Update method tetap sama tapi perlu dimodifikasi redirect
    public function update(Request $request, $idSarana, $ruangan)
{
    $ruangan = Ruangan::findOrFail($ruangan);
    
    $request->validate([
        'nama' => 'required|string|max:255',
        'deskripsi' => 'required|string',
        'kapasitas' => 'required|integer',
        'fasilitas' => 'required|string',
        'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        'additional_images.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
    ]);

    $data = $request->except(['gambar', 'additional_images']);

    if ($request->hasFile('gambar')) {
        Storage::delete($ruangan->gambar);
        $data['gambar'] = $request->file('gambar')->store('public/ruangan');
    }

    $ruangan->update($data);

    if ($request->hasFile('additional_images')) {
        foreach ($request->file('additional_images') as $image) {
            $path = $image->store('public/ruangan');
            GambarRuangan::create([
                'idRuangan' => $ruangan->id,
                'gambar' => $path
            ]);
        }
    }

    return redirect()->route('ruangan.index', $idSarana)
                    ->with('success', 'Ruangan berhasil diperbarui');
}
    public function destroy($idSarana, $ruangan)
{
    $ruangan = Ruangan::findOrFail($ruangan);
    Storage::delete($ruangan->gambar);

    foreach ($ruangan->gambarRuangan as $gambar) {
        Storage::delete($gambar->gambar);
        $gambar->delete();
    }

    $ruangan->delete();
    return redirect()->route('ruangan.index', $idSarana)
                    ->with('success', 'Ruangan berhasil dihapus');
}

   public function deleteImage($idSarana, $id)
{
    try {
        $gambar = GambarRuangan::findOrFail($id);
        
        // Verifikasi bahwa gambar ini memang milik ruangan yang benar
        if ($gambar->ruangan->idSarana != $idSarana) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }
        
        // Hapus file
        if (Storage::exists($gambar->gambar)) {
            Storage::delete($gambar->gambar);
        }
        
        // Hapus record
        $gambar->delete();
        
        return response()->json(['success' => true]);
    } catch (\Exception $e) {
        return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
    }
}
}