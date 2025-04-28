<?php

namespace App\Http\Controllers;

use App\Models\KategoriSarana;
use App\Models\Sarana;
use App\Models\Ruangan;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class KategoriController extends Controller
{
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
            ->paginate(5)
            ->appends(['search' => $search, 'status' => $status]);

        return view('admin.kategori', compact('kategori'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'jenis' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
        ]);

        $existingActiveCategory = KategoriSarana::where('jenis', $validated['jenis'])
            ->where('status', 'aktif')
            ->exists();

        if ($existingActiveCategory) {
            return redirect()->route('kategori.index')->with('error', 'Kategori sudah ada dan masih aktif');
        }

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
                $ruangans = Ruangan::where('IdSarana', $sarana->id)->get();
                foreach ($ruangans as $ruangan) {
                    $ruangan->update(['status' => 'nonaktif']);
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

    public function activate(KategoriSarana $kategori)
    {
        try {
            DB::beginTransaction();
            
            $kategori->update(['status' => 'aktif']);
            
            $saranas = Sarana::where('IdKategori', $kategori->id)->get();
            
            foreach ($saranas as $sarana) {
                $sarana->update(['status' => 'aktif']);
                $ruangans = Ruangan::where('IdSarana', $sarana->id)->get();
                foreach ($ruangans as $ruangan) {
                    $ruangan->update(['status' => 'aktif']);
                }
            }
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Kategori berhasil diaktifkan',
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