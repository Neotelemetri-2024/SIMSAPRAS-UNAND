<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use Illuminate\Http\Request;

class JadwalController extends Controller
{
    public function index()
    {
        $jadwal = Jadwal::all();

        return view('admin.jadwal', compact('jadwal'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'shift' => 'required|string|max:255',
            'mulai' => 'required|date_format:H:i',
            'selesai' => 'required|date_format:H:i|after:mulai',
        ]);

        $conflict = Jadwal::where(function ($query) use ($request) {
            $query->whereBetween('mulai', [$request->mulai, $request->selesai])
                ->orWhereBetween('selesai', [$request->mulai, $request->selesai])
                ->orWhere(function ($query) use ($request) {
                    $query->where('mulai', '<=', $request->mulai)
                            ->where('selesai', '>=', $request->selesai);
                });
        })->exists();

        if ($conflict) {
            return redirect()->route('jadwal.index')->with('error', 'Jadwal bentrok dengan yang sudah ada');
        }

        Jadwal::create($validated);

        return redirect()->route('jadwal.index')->with('success', 'Jadwal berhasil ditambahkan');
    }

    public function update(Request $request, Jadwal $jadwal)
    {
        try {
            $validated = $request->validate([
                'shift' => 'required|string|max:255',
                'mulai' => 'required',
                'selesai' => 'required',
            ]);

            $validated['mulai'] = date('H:i', strtotime($request->mulai));
            $validated['selesai'] = date('H:i', strtotime($request->selesai));

            $conflict = Jadwal::where(function ($query) use ($validated) {
                $query->whereBetween('mulai', [$validated['mulai'], $validated['selesai']])
                    ->orWhereBetween('selesai', [$validated['mulai'], $validated['selesai']])
                    ->orWhere(function ($query) use ($validated) {
                        $query->where('mulai', '<=', $validated['mulai'])
                                ->where('selesai', '>=', $validated['selesai']);
                    });
            })
            ->where('id', '!=', $jadwal->id) 
            ->exists();

            if ($conflict) {
                return redirect()->route('jadwal.index')->with('error', 'Jadwal bentrok dengan yang sudah ada');
            }

            $jadwal->update($validated);

            return redirect()->route('jadwal.index')->with('success', 'Jadwal berhasil diperbarui');
        } catch (\Exception $e) {
            return redirect()->route('jadwal.index')
                ->with('error', 'Gagal memperbarui jadwal: ' . $e->getMessage());
        }
    }

    public function destroy(Jadwal $jadwal)
    {
        try {
            $jadwal->delete();

            return redirect()->route('jadwal.index')->with('success', 'Jadwal berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->route('jadwal.index')->with('error', 'Gagal menghapus jadwal: ' . $e->getMessage());
        }
    }
}