<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\PublisherRepository;
use App\Repositories\PublisherRepositoryInterface;

class PublisherRepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(PublisherRepositoryInterface::class, PublisherRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
