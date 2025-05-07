<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->app->alias('DataTables', \Yajra\DataTables\Facades\DataTables::class);

        View::composer(
            'news.partials.sidebar', 'App\Http\ViewComposers\SidebarComposer'
        );
        View::composer(
            'news.partials.menu', 'App\Http\ViewComposers\MenuComposer'
        );
        View::composer(
            'news.partials.slide', 'App\Http\ViewComposers\SlideComposer'
        );
    }
}
