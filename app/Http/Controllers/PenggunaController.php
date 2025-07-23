<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Sarana;
use App\Models\AdminAccess;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Arr;

class PenggunaController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query()->where('role', '!=', 'superadmin');

        // Filter berdasarkan role dari dropdown
        if ($request->filled('role') && in_array($request->role, ['user', 'admin', 'pimpinan'])) {
            $query->where('role', $request->role);
        }

        $pengguna = $query->orderBy('created_at', 'desc')->paginate(25)->appends($request->all());
        $sarana = Sarana::all();

        return view('admin.pengguna', compact('pengguna', 'sarana'));
    }

    public function store(Request $request)
    {
        // Set response header untuk JSON
        if ($request->expectsJson() || $request->isXmlHttpRequest()) {
            DB::beginTransaction();
            try {
                $validated = $request->validate([
                    'name' => 'required|string|max:255',
                    'kontak' => 'required|string|regex:/^([0-9\s\-\+\(\)]*)$/|min:10|max:15',
                    'email' => 'required|email|unique:users,email',
                    'password' => 'required|string|min:8',
                    'role' => 'required|in:user,admin,pimpinan',
                    'sarana_ids' => 'nullable|array',
                    'sarana_ids.*' => 'exists:sarana,id',
                    'isFakultas' => 'nullable|boolean'
                ]);

                // Validasi khusus untuk admin
                if ($validated['role'] === 'admin') {
                    if (!isset($request->sarana_ids) || empty($request->sarana_ids)) {
                        throw new \Exception('Admin harus memilih minimal satu sarana untuk dikelola');
                    }
                }

                if ($validated['role'] === 'admin' && isset($request->sarana_ids) && !empty($request->sarana_ids)) {
                    $assignedSarana = AdminAccess::whereIn('sarana_id', $request->sarana_ids)->get();

                    if ($assignedSarana->isNotEmpty()) {
                        $assignedSaranaNames = Sarana::whereIn('id', $assignedSarana->pluck('sarana_id'))
                            ->pluck('nama')
                            ->implode(', ');

                        throw new \Exception("Sarana berikut sudah ditugaskan ke admin lain: " . $assignedSaranaNames);
                    }
                }

                $validated['password'] = Hash::make($request->password);
                if (in_array($validated['role'], ['admin', 'pimpinan'])) {
                    $validated['email_verified_at'] = now();
                }

                $validated['isFakultas'] = $request->has('isFakultas') ? true : false;

                if ($validated['isFakultas']) {
                    $validated['email_verified_at'] = now();
                }

                $user = User::create($validated);

                if ($validated['role'] === 'admin' && isset($request->sarana_ids) && !empty($request->sarana_ids)) {
                    $user->saranaAccess()->attach($request->sarana_ids);
                }

                DB::commit();

                return response()->json([
                    'success' => true,
                    'message' => 'Data Pengguna berhasil ditambahkan',
                    'redirect' => route('pengguna.index')
                ]);
            } catch (\Illuminate\Validation\ValidationException $e) {
                DB::rollBack();
                return response()->json([
                    'message' => 'Validasi gagal: ' . implode(', ', Arr::flatten($e->errors()))
                ], 422);
            } catch (\Exception $e) {
                Log::error('Error adding user: ' . $e->getMessage(), [
                    'request' => $request->all(),
                    'exception' => $e
                ]);
                DB::rollBack();
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal menambahkan pengguna: ' . $e->getMessage()
                ], 422);
            }
        }

        // Fallback untuk non-AJAX request
        return redirect()->route('pengguna.index')->with('error', 'Request tidak valid');
    }

    public function update(Request $request, User $pengguna)
    {
        if ($request->expectsJson() || $request->isXmlHttpRequest()) {
            DB::beginTransaction();
            try {
                $rules = [
                    'name' => 'required|string|max:255',
                    'kontak' => 'required|string|regex:/^([0-9\s\-\+\(\)]*)$/|min:10|max:15',
                    'role' => 'required|in:user,admin,pimpinan',
                    'sarana_ids' => 'nullable|array',
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
            } catch (\Illuminate\Validation\ValidationException $e) {
                DB::rollBack();
                return response()->json([
                    'success' => false,
                    'message' => 'Validasi gagal: ' . implode(', ', Arr::flatten($e->errors()))
                ], 422);
            } catch (\Exception $e) {
                DB::rollBack();
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal memperbarui pengguna: ' . $e->getMessage()
                ], 422);
            }
        }

        return redirect()->route('pengguna.index')->with('error', 'Request tidak valid');
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
                'message' => 'Data Pengguna Gagal Dihapus: ' . $e->getMessage()
            ], 422);
        }
    }
}