<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PenggunaController extends Controller
{
    public function index()
    {
        $pengguna = User::all();

        return view('admin.pengguna', compact('pengguna'));
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'kontak' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|string|min:8',
                'role' => 'required|in:user,admin,superadmin,pimpinan',
            ]);

            $validated['password'] = Hash::make($request->password);
            User::create($validated);

            return response()->json([
                'success' => true,
                'message' => 'Data Pengguna berhasil ditambahkan',
                'redirect' => route('pengguna.index')
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menambahkan pengguna: ' . $e->getMessage(),
                'redirect' => route('pengguna.index')
            ]);
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
                'success' => true,
                'message' => 'Data Pengguna berhasil ditambahkan',
                'redirect' => route('pengguna.index')
            ]);
        }
    }
}