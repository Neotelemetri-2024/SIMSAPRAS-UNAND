<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * Default "home" route for the application.
     *
     * @var string
     */
    public const HOME = '/'; // Default HOME

    /**
     * Get the appropriate home path based on the authenticated user role.
     *
     * @return string
     */
    public static function getHome(): string
    {
        $user = Auth::user();
        if ($user && $user->hasAnyRole(['superadmin', 'admin', 'pimpinan'])) {
            return '/admin/dashboard';
        }

        return self::HOME; // Default to '/user'
    }

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        $this->routes(function () {
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->group(base_path('routes/web.php'));
        });
    }
}
