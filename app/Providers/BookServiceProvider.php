<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\BookService;
use App\Services\BookServiceInterface;

class BookServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(BookServiceInterface::class, BookService::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
