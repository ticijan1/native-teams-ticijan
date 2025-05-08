<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\AuthorService;
use App\Services\AuthorServiceInterface;

class AuthorServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(AuthorServiceInterface::class, AuthorService::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
