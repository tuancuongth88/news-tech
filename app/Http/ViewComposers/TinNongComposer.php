<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;
use App\Models\Post;

class TinNongComposer
{
    /**
     * The user repository implementation.
     *
     * @var  UserRepository
     */

    /**
     * Create a new profile composer.
     *
     * @param    UserRepository  $users
     * @return  void
     */
    public function __construct()
    {
        // Dependencies automatically resolved by service container...
        //$this->users = $users;
    }

    /**
     * Bind data to the view.
     *
     * @param    View  $view
     * @return  void
     */
    public function compose(View $view)
    {
        $posts = Post::where('status',1)->where('hot',1)->orderBy('created_at','desc')->limit(10)->get();
        $view->with('posts',$posts);
    }
}
