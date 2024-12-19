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

        $penjaga = Penjaga::with('sarana')
            ->when($search, function ($query, $search) {
                $query->where('nama', 'like', "%{$search}%")
                      ->orWhere('kontak', 'like', "%{$search}%");
            })
            ->paginate(5);

        $sarana = Sarana::all();

        return view('admin.penjaga', compact('penjaga', 'sarana', 'search'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'idSarana' => 'required|exists:sarana,id',
            'nama' => 'required|string|max:255',
            'kontak' => 'required|string|max:255',
        ]);

        Penjaga::create($validated);

        return redirect()->route('penjaga.index')->with('success', 'Data penjaga berhasil ditambahkan');
    }

    public function update(Request $request, Penjaga $penjaga)
    {
        $validated = $request->validate([
            'idSarana' => 'required|exists:sarana,id',
            'nama' => 'required|string|max:255',
            'kontak' => 'required|string|max:255',
        ]);

        $penjaga->update($validated);

        return redirect()->route('penjaga.index')->with('success', 'Data penjaga berhasil diperbarui');
    }

    public function destroy(Penjaga $penjaga)
    {
        $penjaga->delete();

        return redirect()->route('penjaga.index')->with('success', 'Data penjaga berhasil dihapus');
    }

    public function show(Penjaga $penjaga)
    {
        $penjaga->load('sarana');

        return view('admin.detailsPenjaga', compact('penjaga'));
    }
}