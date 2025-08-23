<?php

namespace App\Http\Controllers;

use App\Models\Sarana;
use App\Models\KategoriSarana;
use Illuminate\Http\Request;
use App\Models\Peminjaman;
use App\Models\Pengumuman;
use App\Models\Ruangan;
use App\Models\User;
use App\Models\FacilityUsage;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Models\TanggalPeminjaman;
use Carbon\Carbon;

DB::enableQueryLog();

class SaranaController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input("search");
        $filter = $request->input("filter");
        
        $query = Sarana::with(['kategoriSarana', 'gambarSarana']);
        $query->filterByUserAccess(auth()->user());
        
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('deskripsi', 'like', "%{$search}%")
                  ->orWhere('fasilitas', 'like', "%{$search}%");
            });
        }
        
        if ($filter) {
            if (str_starts_with($filter, 'kategori_')) {
                $kategoriId = substr($filter, 9); 
                $query->where('IdKategori', $kategoriId);
            } elseif (str_starts_with($filter, 'status_')) {
                $status = substr($filter, 7); 
                $query->where('status', $status);
            }
        }
        
        $sarana = $query->latest()
        ->paginate(5)
        ->appends($request->except('page'));
        $kategori = KategoriSarana::where('status', 'aktif')->get();
                
        return view('admin.sarana', compact('sarana', 'kategori', 'search', 'filter'));
    }

    public function store(Request $request)
    {
        try {
            if ($request->hasFile('gambar')) {
                $mainImage = $request->file('gambar');
                if ($mainImage->getSize() > 2048 * 1024) { 
                    return response()->json([
                        'success' => false,
                        'message' => 'Gambar utama tidak boleh lebih dari 2MB'
                    ]);
                }
            }

            if ($request->hasFile('gambar_tambahan')) {
                foreach ($request->file('gambar_tambahan') as $index => $image) {
                    if ($image->getSize() > 2048 * 1024) { 
                        return response()->json([
                            'success' => false,
                            'message' => 'Gambar tambahan ke-' . ($index + 1) . ' tidak boleh lebih dari 2MB'
                        ]);
                    }
                }
            }

            $validationRules = [
                "IdKategori" => "required|string|required",
                'nama' => 'required|string|max:255',
                'isRoom' => 'required|boolean',
                'deskripsi' => 'required|string',
                'fasilitas' => 'required|string',
                'kapasitas' => 'nullable|integer|min:0',
                'tariformawa' => 'nullable|integer|min:0',
                'tarifunit' => 'nullable|integer|min:0',
                'tarifumum' => 'nullable|integer|min:0',
                'is_hourly_rate' => 'boolean',
                'requiresFaculty' => 'boolean',
                'hours_per_unit' => 'nullable|integer|min:0',
                'gambar' => 'required|image|mimes:jpeg,png,jpg|max:2048',
                'gambar_tambahan.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            ];
            
            // Adjust hours_per_unit validation based on is_hourly_rate
            if ($request->boolean('is_hourly_rate')) {
                $validationRules['hours_per_unit'] = 'required|integer|min:1|max:24';
            }
            
            // Now validate with the complete rules
            $validated = $request->validate($validationRules, [
                'gambar.max' => 'Gambar utama tidak boleh lebih dari 2MB',
                'gambar_tambahan.*.max' => 'Gambar tambahan tidak boleh lebih dari 2MB',
                'hours_per_unit.required' => 'Jam per unit harus diisi jika tarif per jam diaktifkan'
            ]);

            $existingSarana = Sarana::where('nama', $validated['nama'])
                ->where('status', 'aktif')
                ->exists();

            if ($existingSarana) {
                return response()->json([
                    'success' => false,
                    'message' => 'Sarana dengan nama tersebut sudah ada dan masih aktif'
                ]);
            }
            
            if ($request->hasFile('gambar')) {
                $validated['gambar'] = $request->file('gambar')->store('sarana', 'public');
            }

            $sarana = Sarana::create($validated);

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
            if ($request->hasFile('gambar')) {
                $mainImage = $request->file('gambar');
                if ($mainImage->getSize() > 2048 * 1024) { 
                    return response()->json([
                        'success' => false,
                        'message' => 'Gambar utama tidak boleh lebih dari 2MB'
                    ]);
                }
            }

            if ($request->hasFile('gambar_tambahan')) {
                foreach ($request->file('gambar_tambahan') as $index => $image) {
                    if ($image->getSize() > 2048 * 1024) { 
                        return response()->json([
                            'success' => false,
                            'message' => 'Gambar tambahan ke-' . ($index + 1) . ' tidak boleh lebih dari 2MB'
                        ]);
                    }
                }
            }

            $validationRules = [
                "IdKategori" => "required|string|required",
                'nama' => 'required|string|max:255|unique:sarana,nama,'.$sarana->id,
                'isRoom' => 'required|boolean',
                'deskripsi' => 'required|string',
                'fasilitas' => 'required|string',
                'kapasitas' => 'nullable|integer|min:0',
                'tariformawa' => 'nullable|integer|min:0',
                'tarifunit' => 'nullable|integer|min:0',
                'tarifumum' => 'nullable|integer|min:0',
                'is_hourly_rate' =>'boolean',
                'requiresFaculty' => 'boolean',
                'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
                'gambar_tambahan.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            ];
            
            // Only require hours_per_unit if is_hourly_rate is true
            if ($request->boolean('is_hourly_rate')) {
                $validationRules['hours_per_unit'] = 'required|integer|min:1|max:24';
            } else {
                $validationRules['hours_per_unit'] = 'nullable|integer|min:0';
            }
    
            $validated = $request->validate($validationRules, [
                'gambar.max' => 'Gambar utama tidak boleh lebih dari 2MB',
                'gambar_tambahan.*.max' => 'Gambar tambahan tidak boleh lebih dari 2MB',
                'hours_per_unit.required' => 'Jam per unit harus diisi jika tarif per jam diaktifkan'
            ]);

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

            $sarana->update($validated);

            if ($request->hasFile('gambar')) {
                if ($sarana->gambar) {
                    Storage::disk('public')->delete($sarana->gambar);
                }
                $validated['gambar'] = $request->file('gambar')->store('sarana', 'public');
                $sarana->update(['gambar' => $validated['gambar']]);
            }

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

        $user = auth()->check() ? User::find(auth()->id()) : null;
        $isFacultyUser = $user && $user->isFacultyUser();

        $sarana = Sarana::withCount('peminjaman')
            ->with('kategoriSarana')
            ->when($search, function ($query, $search) {
                $query->where(function($q) use ($search) {
                    $q->where('nama', 'like', "%{$search}%")
                      ->orWhere('deskripsi', 'like', "%{$search}%")
                      ->orWhere('fasilitas', 'like', "%{$search}%");
                });
            })
            ->when($filterKategori, function ($query, $filterKategori) {
                $query->where('IdKategori', $filterKategori);
            })
            ->when(!$isFacultyUser, function ($query) {
                $query->where(function($q) {
                    $q->where('requiresFaculty', false)
                    ->orWhereNull('requiresFaculty');
                });
            })
            ->orderBy('peminjaman_count', 'desc')
            ->where('status', 'aktif')
            ->paginate(6)
            ->appends($request->except('page'));

        $trendData = TanggalPeminjaman::selectRaw('DATE_FORMAT(tanggal, "%b %Y") as month, YEAR(tanggal) as year, MONTH(tanggal) as month_num, COUNT(*) as total')
            ->whereRaw('tanggal >= DATE_SUB(NOW(), INTERVAL 6 MONTH)')
            ->groupBy('year', 'month_num', 'month')
            ->orderBy('year')
            ->orderBy('month_num')
            ->get();

        $topBorrowed = Sarana::withCount('peminjaman')
            ->orderBy('peminjaman_count', 'desc')
            ->limit(5)
            ->get();

        $pengumuman = Pengumuman::latest()->limit(3)->get();

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
        
        $sarana->load(['kategoriSarana', 'gambarSarana', 'penjaga']);
        
        $ruangan = collect();
        $events = []; 

        $admin = User::whereHas('saranaAccess', function($query) use ($sarana) {
            $query->where('sarana_id', $sarana->id);
        })->where('role', 'admin')->first();    

        $user = User::find(auth()->id());

        if ($sarana->status !== 'aktif') {
            return redirect()->route('user.sarana')->with('error', 'Sarana ini tidak tersedia atau telah dinonaktifkan.');
        }

        if ($sarana->requiresFaculty && (!$user || !$user->isFacultyUser())) {
            return redirect()->route('user.sarana')->with('faculty-error', 'Sarana ini hanya dapat diakses oleh pengguna dari fakultas/unit.');
        }

        // Hitung jam lembur bulan ini
        $currentMonth = Carbon::now()->format('Y-m');
        $bulanIni = Carbon::now()->translatedFormat('F Y');
        
        // Data jam lembur bulan ini berdasarkan peminjaman aktif
        $jamLemburBulanIni = $this->calculateOvertimeHours($sarana->id, $currentMonth);
        
        // Data jam lembur seluruh bulan dalam setahun
        $tahunIni = Carbon::now()->year;
        $dataJamLembur = [];
        
        // Mengumpulkan data untuk 12 bulan
        for ($i = 1; $i <= 12; $i++) {
            $bulan = Carbon::createFromDate($tahunIni, $i, 1);
            $bulanFormat = $bulan->format('Y-m');
            $namaBulan = $bulan->translatedFormat('F Y');
            
            $jamLembur = $this->calculateOvertimeHours($sarana->id, $bulanFormat);
            
            $dataJamLembur[] = [
                'bulan' => $namaBulan,
                'bulan_format' => $bulanFormat,
                'jam_terpakai' => $jamLembur,
                'sisa_jam' => 40 - $jamLembur,
                'persentase' => ($jamLembur / 40) * 100,
                'is_current' => $bulanFormat === $currentMonth
            ];
        }
        
        if ($sarana->isRoom == 1) {
            $ruangan = $sarana->ruangan()
                ->where('idSarana', $sarana->id) 
                ->when($search, function ($query, $search) {
                    $query->where(function($q) use ($search) {
                        $q->where('nama', 'like', "%{$search}%")
                          ->orWhere('deskripsi', 'like', "%{$search}%");
                    });
                })
                ->latest()
                ->where('status', 'aktif')
                ->paginate(6);
        } else {
            $peminjaman = Peminjaman::with(['tanggalPeminjaman.jadwal']) 
                ->where('idSarana', $sarana->id)
                ->whereIn('status', ['diajukan', 'disetujui', 'diproses', 'diajukanbatal'])
                ->get();
                
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
        
        return view('detailsarana', compact(
            'sarana', 'ruangan', 'search', 'events', 'admin', 
            'jamLemburBulanIni', 'bulanIni', 'dataJamLembur', 'currentMonth'
        ));
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

    /**
     * Hitung jam lembur berdasarkan peminjaman aktif
     */
    private function calculateOvertimeHours($saranaId, $bulanFilter = null, $ruanganId = null)
    {
        $query = Peminjaman::with(['tanggalPeminjaman.jadwal'])
            ->where('idSarana', $saranaId)
            ->whereIn('status', ['diajukan', 'diproses', 'disetujui', 'diajukanbatal']);
            
        if ($ruanganId) {
            $query->where('idRuangan', $ruanganId);
        }
        
        if ($bulanFilter) {
            $query->whereHas('tanggalPeminjaman', function($q) use ($bulanFilter) {
                $q->whereRaw("DATE_FORMAT(tanggal, '%Y-%m') = ?", [$bulanFilter]);
            });
        }
        
        $peminjamans = $query->get();
        $totalJamLembur = 0;
        
        foreach ($peminjamans as $peminjaman) {
            foreach ($peminjaman->tanggalPeminjaman as $tanggalPeminjaman) {
                if ($bulanFilter && Carbon::parse($tanggalPeminjaman->tanggal)->format('Y-m') !== $bulanFilter) {
                    continue;
                }
                
                $jadwal = $tanggalPeminjaman->jadwal;
                if (!$jadwal) continue;
                
                $date = Carbon::parse($tanggalPeminjaman->tanggal);
                $start = Carbon::createFromFormat('H:i:s', $jadwal->mulai);
                $endTime = Carbon::createFromFormat('H:i:s', $jadwal->selesai);
                $hours = $endTime->diffInHours($start);
                
                $isWeekend = $date->isWeekend();
                $isAfterHours = $start->hour >= 16 || $endTime->hour >= 16;
                
                // Hanya hitung jam lembur (weekend atau after hours)
                if ($isWeekend || $isAfterHours) {
                    $chargeableHours = $hours;
                    
                    // Jika bukan weekend tapi after hours, hitung hanya bagian setelah jam 16:00
                    if (!$isWeekend && $isAfterHours && $start->hour < 16) {
                        $cutoffTime = Carbon::createFromFormat('H:i:s', '16:00:00');
                        $chargeableHours = $endTime->diffInHours($cutoffTime);
                    }
                    
                    $totalJamLembur += $chargeableHours;
                }
            }
        }
        
        return $totalJamLembur;
    }
}