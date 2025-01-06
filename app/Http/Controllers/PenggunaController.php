<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Sarana;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\AdminAccess;

class PenggunaController extends Controller
{
    public function index()
    {
        $pengguna = User::all();
        $sarana = Sarana::all();

        return view('admin.pengguna', compact('pengguna', 'sarana'));
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'kontak' => 'required|string|regex:/^([0-9\s\-\+\(\)]*)$/|min:10|max:15',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|string|min:8',
                'role' => 'required|in:user,admin,superadmin,pimpinan',
                'sarana_ids' => 'required_if:role,admin|array', 
                'sarana_ids.*' => 'exists:sarana,id'
            ]);

            if ($validated['role'] === 'admin' && isset($request->sarana_ids)) {
                $assignedSarana = AdminAccess::whereIn('sarana_id', $request->sarana_ids)->get();
                
                if ($assignedSarana->isNotEmpty()) {
                    $assignedSaranaNames = Sarana::whereIn('id', $assignedSarana->pluck('sarana_id'))
                        ->pluck('nama')
                        ->implode(', ');
                        
                    throw new \Exception("Sarana berikut sudah ditugaskan ke admin lain: " . $assignedSaranaNames);
                }
            }
            
            $validated['password'] = Hash::make($request->password);
            if (in_array($validated['role'], ['admin', 'superadmin', 'pimpinan'])) {
                $validated['email_verified_at'] = now();
            }
            $user = User::create($validated);

            if ($validated['role'] === 'admin' && isset($request->sarana_ids)) {
                $user->saranaAccess()->attach($request->sarana_ids);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Data Pengguna berhasil ditambahkan',
                'redirect' => route('pengguna.index')
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Gagal menambahkan pengguna: ' . $e->getMessage(),
                'redirect' => route('pengguna.index')
            ]);
        }
    }

    public function update(Request $request, User $pengguna)
    {
        DB::beginTransaction();
        try {
            $rules = [
                'name' => 'required|string|max:255',
                'kontak' => 'required|string|regex:/^([0-9\s\-\+\(\)]*)$/|min:10|max:15',
                'role' => 'required|in:user,admin,superadmin,pimpinan',
                'sarana_ids' => 'required_if:role,admin|array',
                'sarana_ids.*' => 'exists:sarana,id'
            ];

            $validated = $request->validate($rules);

            $updateData = collect($validated)->except('sarana_ids')->toArray();

            $pengguna->update($updateData);

            if ($validated['role'] === 'admin') {
                $pengguna->saranaAccess()->sync($request->sarana_ids ?? []);
            } else {
                $pengguna->saranaAccess()->detach();
            }

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Data Pengguna berhasil diperbarui',
                'redirect' => route('pengguna.index')
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui pengguna: ' . $e->getMessage()
            ], 422);
        }
    }

    public function destroy(User $pengguna)
    {
        try {
            $pengguna->delete();
            return response()->json([
                'success' => true,
                'message' => 'Data Pengguna berhasil dihapus',
                'redirect' => route('pengguna.index')
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Data Pengguna Gagal Dihapus: ' . $e->getMessage(),
                'redirect' => route('pengguna.index')
            ]);
        }
    }
}