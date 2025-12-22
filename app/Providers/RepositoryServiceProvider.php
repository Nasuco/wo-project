<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Repositories\Contracts\UserRepositoryInterface;
use App\Repositories\Contracts\PackageRepositoryInterface;
use App\Repositories\EloquentPackageRepository;
use App\Repositories\EloquentUserRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(
            UserRepositoryInterface::class, EloquentUserRepository::class
        );

        $this->app->bind(
            PackageRepositoryInterface::class, EloquentPackageRepository::class
        );
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}