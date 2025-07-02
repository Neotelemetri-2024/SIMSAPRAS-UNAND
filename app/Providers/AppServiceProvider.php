<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Carbon\Carbon;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        if(config('app.env') === 'production') {
            $this->app['request']->server->set('HTTPS', true); 
        }
    }

    /**
     * Bootstrap any application services.
     */
    

public function boot()
{
    Carbon::setLocale('id');
}
}