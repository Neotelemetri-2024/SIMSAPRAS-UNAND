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
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // Cek apakah user sudah login
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();
        
        // Jika user role ada dalam roles yang diizinkan, lanjutkan request
        if (in_array($user->role, $roles)) {
            return $next($request);
        }

        // Redirect berdasarkan role jika mencoba mengakses area yang tidak sesuai
        if ($user->role === 'user') {
            return redirect()->route('home');
        }

        if (in_array($user->role, ['superadmin', 'admin', 'pimpinan'])) {
            return redirect()->route('dashboard.index');
        }

        // Jika role tidak dikenali
        abort(403, 'Unauthorized access');
    }
}