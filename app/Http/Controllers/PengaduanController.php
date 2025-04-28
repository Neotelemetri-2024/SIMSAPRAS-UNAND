<?php

namespace App\Http\Controllers;

use App\Models\Pengaduan;
use Illuminate\Http\Request;
use App\Models\Sarana;

class PengaduanController extends Controller
{
    public function userShow()
    {
        $sarana = Sarana::all();
        return view('pengaduan', compact('sarana'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'judul' => 'required',
                'deskripsi' => 'required',
                'id_sarana' => 'required',
                'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            ]);

            $data = [
                'judul' => $request->judul,
                'deskripsi' => $request->deskripsi,
                'id_sarana' => $request->id_sarana,
                'user_id' => auth()->id(),
            ];

            if ($request->hasFile('foto')) {
                $foto = $request->file('foto');
                $filename = time() . '.' . $foto->getClientOriginalExtension();
                $poto = $foto->storeAs('public/pengaduan', $filename);
                $data['foto'] = $poto;
            }

            Pengaduan::create($data);

            return response()->json([
                'success' => true,
                'message' => 'Pengaduan berhasil dikirim!',
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan! ' . $e->getMessage(),
            ], 500);
        }
    }

    public function adminShow(Request $request)
    {
        $pengaduan = Pengaduan::with(['user', 'sarana'])
            ->whereHas('sarana', function($query) {
                $query->filterByUserAccess(auth()->user());
            })
            ->when(request('search'), function($query) {
                $query->where('judul', 'like', '%' . request('search') . '%')
                    ->orWhere('deskripsi', 'like', '%' . request('search') . '%');
            })
            ->when(request('filter'), function($query) {
                $query->where('id_sarana', request('filter'));
            })
            ->latest()
            ->paginate(5)
            ->appends($request->except('page'));

        $sarana = Sarana::query()
            ->filterByUserAccess(auth()->user())
            ->get();
            
        return view('admin.pengaduan', compact('pengaduan', 'sarana'));
    }
}