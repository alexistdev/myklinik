<?php

namespace App\Providers;

use App\Services\Admin\GolonganService;
use App\Services\Admin\GolonganServiceImpl;
use App\Services\Admin\KategoriService;
use App\Services\Admin\KategoriServiceImpl;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
         * Author: AlexistDev
         * Email: Alexistdev@gmail.com
         * Phone: 082371408678
         * Github: https://github.com/alexistdev
         */

    public $bindings = [
            KategoriService::class => KategoriServiceImpl::class,
            GolonganService::class => GolonganServiceImpl::class,
    ];

    public function register(): void
    {
        //
    }


    public function boot(): void
    {
        Paginator::useBootstrap();
    }
}
