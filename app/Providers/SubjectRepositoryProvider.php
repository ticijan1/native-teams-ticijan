<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\SubjectRepository;
use App\Repositories\SubjectRepositoryInterface;

class SubjectRepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(SubjectRepositoryInterface::class, SubjectRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
