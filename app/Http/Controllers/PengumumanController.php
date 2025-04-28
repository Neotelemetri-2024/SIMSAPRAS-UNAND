<?php

namespace App\Http\Controllers;

use App\Models\Pengumuman;
use Illuminate\Http\Request;

class PengumumanController extends Controller
{
    public function index(Request $request)
    {
        $query = Pengumuman::with('user');
        
        if (auth()->user()->role === 'admin') {
            $query->where('penulis', auth()->id());
        }

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('judul', 'LIKE', "%{$search}%")
                ->orWhere('isi', 'LIKE', "%{$search}%");
            });
        }

        $pengumuman = $query->latest()
            ->paginate(10)
            ->appends($request->all());
        return view('admin.pengumuman', compact('pengumuman'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required',
            'isi' => 'required'
        ]);

        try {
            Pengumuman::create([
                'judul' => $request->judul,
                'isi' => $request->isi,
                'penulis' => auth()->id()
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Pengumuman berhasil ditambahkan',
                'redirect' => route('pengumuman.index')
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'judul' => 'required',
            'isi' => 'required'
        ]);

        try {
            $pengumuman = Pengumuman::findOrFail($id);
            $pengumuman->update([
                'judul' => $request->judul,
                'isi' => $request->isi,
                'penulis' => auth()->id()
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Pengumuman berhasil diperbarui',
                'redirect' => route('pengumuman.index')
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $pengumuman = Pengumuman::findOrFail($id);
            $pengumuman->delete();

            return response()->json([
                'success' => true,
                'message' => 'Pengumuman berhasil dihapus',
                'redirect' => route('pengumuman.index')
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function indexUser(Request $request)
    {
        $query = Pengumuman::query();

        if ($request->has('search')) {
            $search = $request->search;
            $query->where('judul', 'LIKE', "%{$search}%")
                ->orWhere('isi', 'LIKE', "%{$search}%");
        }

        $pengumuman = $query->latest()->paginate(10);
        return view('pengumuman', compact('pengumuman'));
    }
}