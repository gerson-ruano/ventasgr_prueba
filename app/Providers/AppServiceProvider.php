<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\ApiAuthService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(ApiAuthService::class, function ($app) {
            return new ApiAuthService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
