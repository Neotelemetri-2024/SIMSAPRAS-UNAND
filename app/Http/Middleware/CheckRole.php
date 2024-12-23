<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response; // Pastikan ini diimpor

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): \Symfony\Component\HttpFoundation\Response  $next
     * @param  string  $role
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Cek apakah user sudah login
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();
        
        // Jika route saat ini sudah sesuai dengan role, izinkan akses
        $currentRoute = $request->route()->getName();
        
        // Untuk admin-level roles
        if (in_array($user->role, ['superadmin', 'admin', 'pimpinan'])) {
            // Jika mencoba mengakses route user, redirect ke dashboard
            if (str_starts_with($currentRoute, 'peminjaman.create') || 
                str_starts_with($currentRoute, 'peminjaman.store') ||
                str_starts_with($currentRoute, 'peminjaman.index') ||
                str_starts_with($currentRoute, 'peminjaman.show') ||
                str_starts_with($currentRoute, 'peminjaman.cancel') ||
                str_starts_with($currentRoute, 'riwayat.')) {
                return redirect()->route('dashboard.index');
            }
            // Jika sudah di area admin, lanjutkan
            if (str_starts_with($currentRoute, 'dashboard.') || 
                str_starts_with($currentRoute, 'peminjaman.admin.') ||
                str_starts_with($currentRoute, 'admin.') || 
                str_starts_with($currentRoute, 'sarana.') ||
                str_starts_with($currentRoute, 'kategori.') ||
                str_starts_with($currentRoute, 'jadwal.') ||
                str_starts_with($currentRoute, 'penjaga.') ||
                str_starts_with($currentRoute, 'pengguna.')) {
                return $next($request);
            }
            return redirect()->route('dashboard.index');
        }
        
        // Untuk user biasa
        if ($user->role === 'user') {
            // Jika mencoba mengakses route admin, redirect ke home
            if (str_starts_with($currentRoute, 'dashboard.') ||
                str_starts_with($currentRoute, 'admin.') ||
                str_starts_with($currentRoute, 'peminjaman.admin.') || // Tambahkan ini untuk mencegah akses ke peminjaman admin
                str_starts_with($currentRoute, 'kategori.') ||
                str_starts_with($currentRoute, 'jadwal.') ||
                str_starts_with($currentRoute, 'penjaga.') ||
                str_starts_with($currentRoute, 'pengguna.')) {
                return redirect()->route('home');
            }
            
            // Jika sudah di area user, lanjutkan
            if (str_starts_with($currentRoute, 'peminjaman.') || 
                str_starts_with($currentRoute, 'riwayat.') ||
                str_starts_with($currentRoute, 'home') ||
                str_starts_with($currentRoute, 'user.')) {
                return $next($request);
            }
            return redirect()->route('home');
        }

        abort(403, 'Unauthorized access');
    }
}