<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(\App\Services\DuskScraper::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->app->alias('DataTables', \Yajra\DataTables\Facades\DataTables::class);

//        View::composer(
//            'news.partials.sidebar', 'App\Http\ViewComposers\SidebarComposer'
//        );
//        View::composer(
//            'news.partials.menu', 'App\Http\ViewComposers\MenuComposer'
//        );
//        View::composer(
//            'news.partials.slide', 'App\Http\ViewComposers\SlideComposer'
//        );

        //template new
        View::composer(
            'news.theme-1.partials.header', 'App\Http\ViewComposers\MenuComposer'
        );
        View::composer(
            'news.theme-1.partials.tin-nong', 'App\Http\ViewComposers\TinNongComposer'
        );
        View::composer(
            'news.theme-1.partials.tin-noi-bat', 'App\Http\ViewComposers\TinNoiBatComposer'
        );
        View::composer(
            'news.theme-1.partials.footer', 'App\Http\ViewComposers\FooterComposer'
        );
        Paginator::defaultView('news.theme-1.components.pagination');
    }
}
