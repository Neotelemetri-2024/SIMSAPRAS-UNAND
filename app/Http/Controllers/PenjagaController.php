<?php

namespace App\Http\Controllers;

use App\Models\Penjaga;
use App\Models\Sarana;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PenjagaController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input("search");
        $selectedSarana = $request->input("sarana"); // Ubah default menjadi string kosong

        $penjaga = Penjaga::with('sarana')
            ->when($search, function ($query, $search) {
                $query->where('nama', 'like', "%{$search}%")
                    ->orWhere('kontak', 'like', "%{$search}%");
            })
            ->when($selectedSarana, function ($query) use ($selectedSarana) {
                $query->where('idSarana', $selectedSarana);
            })
            ->paginate(5);
        
        $sarana = Sarana::where('status', 'aktif')->get();
        
        return view('admin.penjaga', compact('penjaga', 'sarana', 'search', 'selectedSarana'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'idSarana' => 'required|exists:sarana,id',
            'nama' => 'required|string|max:255',
            'kontak' => 'required|string|max:255',
        ]);

        Penjaga::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Data Penjaga berhasil ditambahkan',
            'redirect' => route('penjaga.index')
        ]);
    }

    public function update(Request $request, Penjaga $penjaga)
    {
        $validated = $request->validate([
            'idSarana' => 'required|exists:sarana,id',
            'nama' => 'required|string|max:255',
            'kontak' => 'required|string|max:255',
        ]);

        $penjaga->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Data Penjaga berhasil diperbarui',
            'redirect' => route('penjaga.index')
        ]);
    }

    public function destroy(Penjaga $penjaga)
    {
        $penjaga->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data Penjaga berhasil dihapus',
            'redirect' => route('penjaga.index')
        ]);
    }

    public function show(Penjaga $penjaga)
    {
        $penjaga->load('sarana');

        return view('admin.detailsPenjaga', compact('penjaga'));
    }
}