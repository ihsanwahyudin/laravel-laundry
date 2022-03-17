<?php

namespace App\Providers;

use App\Repositories\Eloquent\BarangInventarisRepository;
use App\Repositories\Eloquent\LaporanRepository;
use App\Repositories\Eloquent\LogActivityRepository;
use App\Repositories\Eloquent\MemberRepository;
use App\Repositories\Eloquent\OutletRepository;
use App\Repositories\Eloquent\PaketRepository;
use App\Repositories\Eloquent\PenjemputanRepository;
use App\Repositories\Eloquent\TransaksiRepository;
use App\Repositories\Eloquent\UserRepository;
use App\Repositories\Interfaces\Eloquent\BarangInventarisRepositoryInterface;
use App\Repositories\Interfaces\Eloquent\LaporanRepositoryInterface;
use App\Repositories\Interfaces\Eloquent\LogActivityRepositoryInterface;
use App\Repositories\Interfaces\Eloquent\MemberRepositoryInterface;
use App\Repositories\Interfaces\Eloquent\OutletRepositoryInterface;
use App\Repositories\Interfaces\Eloquent\PaketRepositoryInterface;
use App\Repositories\Interfaces\Eloquent\PenjemputanRepositoryInterface;
use App\Repositories\Interfaces\Eloquent\TransaksiRepositoryInterface;
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
        $this->app->bind(PaketRepositoryInterface::class, PaketRepository::class);
        $this->app->bind(TransaksiRepositoryInterface::class, TransaksiRepository::class);
        $this->app->bind(LaporanRepositoryInterface::class, LaporanRepository::class);
        $this->app->bind(LogActivityRepositoryInterface::class, LogActivityRepository::class);
        $this->app->bind(BarangInventarisRepositoryInterface::class, BarangInventarisRepository::class);
        $this->app->bind(PenjemputanRepositoryInterface::class, PenjemputanRepository::class);
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
