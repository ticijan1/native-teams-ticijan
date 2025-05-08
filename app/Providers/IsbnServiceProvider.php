<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\IsbnService;
use App\Services\IsbnServiceInterface;

class IsbnServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(IsbnServiceInterface::class, IsbnService::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
