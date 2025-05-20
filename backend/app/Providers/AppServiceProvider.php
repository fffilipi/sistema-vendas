<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Contracts\Auth\UserRepositoryInterface;
use App\Repositories\Auth\UserRepository;
use App\Repositories\Contracts\Auth\TokenRepositoryInterface;
use App\Repositories\Auth\TokenRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            UserRepositoryInterface::class,
            UserRepository::class
        );
        
        $this->app->bind(
            TokenRepositoryInterface::class,
            TokenRepository::class
        );        
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
