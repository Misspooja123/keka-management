<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
// use Yajra\DataTables\Html\Builder;
use App\Interfaces\PostRepositoryInterface;
use App\Repositories\PostRepository;
use App\Interfaces\MarksheetInterface;
use App\Repositories\MarksheetRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
        $this->app->bind(PostRepositoryInterface::class, PostRepository::class);
        $this->app->bind(MarksheetInterface::class, MarksheetRepository::class);
    }


    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
       // Builder::useVite();
    }
}
