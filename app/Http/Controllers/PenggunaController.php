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

            return redirect()->route('pengguna.index')->with('success', 'Pengguna berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect()->route('pengguna.index')->with('error', 'Gagal menambahkan pengguna: ' . $e->getMessage());
        }
    }

    public function update(Request $request, User $pengguna)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'kontak' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $pengguna->id,
            'role' => 'required|in:user,admin,superadmin,pimpinan',
        ]);

        $pengguna->update($validated);
        return redirect()->route('pengguna.index')->with('success', 'Pengguna berhasil diperbarui');
    }

    public function destroy(User $pengguna)
    {
        try {
            $pengguna->delete();
            return redirect()->route('pengguna.index')->with('success', 'Pengguna berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->route('pengguna.index')->with('error', 'Gagal menghapus pengguna: ' . $e->getMessage());
        }
    }
}