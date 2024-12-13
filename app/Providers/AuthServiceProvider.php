<?php
namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Models\User;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        // Jika Anda ingin mendefinisikan policy untuk model tertentu
    ];

    public function boot(): void
    {
        // Gate untuk cek sudah login
        Gate::define('is-authenticated', function ($user) {
            return auth()->check();
        });

        // Gate untuk admin
        Gate::define('is-admin', function ($user) {
            return $user->role === 'admin';
        });

        // Gate untuk user biasa
        Gate::define('is-user', function ($user) {
            return $user->role === 'user';
        });

        // Gate untuk superadmin
        Gate::define('is-superadmin', function ($user) {
            return $user->role === 'superadmin';
        });

        // Gate untuk pimpinan
        Gate::define('is-pimpinan', function ($user) {
            return $user->role === 'pimpinan';
        });

        // Gate kombinasi (contoh: admin atau superadmin)
        Gate::define('manage-users', function ($user) {
            return in_array($user->role, ['admin', 'superadmin']);
        });
    }
}