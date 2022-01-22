<?php

namespace App\Providers;

use App\Repositories\Eloquent\MemberRepository;
use App\Repositories\Eloquent\OutletRepository;
use App\Repositories\Eloquent\UserRepository;
use App\Repositories\Interfaces\Eloquent\MemberRepositoryInterface;
use App\Repositories\Interfaces\Eloquent\OutletRepositoryInterface;
use App\Repositories\Interfaces\Eloquent\UserRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(OutletRepositoryInterface::class, OutletRepository::class);
        $this->app->bind(MemberRepositoryInterface::class, MemberRepository::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
