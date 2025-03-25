<?php

namespace App\Providers;

use App\Interface\MenuInterface;
use App\Interface\MurojaatInterface;
use App\Models\Murojaat;
use App\Repository\MenuRepository;
use App\Repository\MurojaatRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(MurojaatInterface::class, MurojaatRepository::class);
        $this->app->bind(MenuInterface::class, MenuRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
