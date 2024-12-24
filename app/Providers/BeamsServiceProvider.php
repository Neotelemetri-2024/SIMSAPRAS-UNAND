<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Pusher\PushNotifications\PushNotifications;

class BeamsServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(PushNotifications::class, function ($app) {
            return new PushNotifications([
                'instanceId' => config('beams.instance_id'),
                'secretKey' => config('beams.secret_key'),
            ]);
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->publishes([
            __DIR__.'/../../config/beams.php' => config_path('beams.php'),
        ], 'beams-config');
    }
}