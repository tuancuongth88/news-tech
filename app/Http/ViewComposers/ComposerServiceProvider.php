<?php

namespace App\Http\ViewComposers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Register bindings in the container.
     *
     * @return  void
     */
    public function boot()
    {
        // Using class based composers...
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

    /**
     * Register the service provider.
     *
     * @return  void
     */
    public function register()
    {
        //
    }
}
