<?php

namespace App\Http\ViewComposers;

use App\Models\Category;
use Illuminate\View\View;
use App\Models\Post;

class FooterComposer
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
        $cate = Category::query()->whereNull('parent_id')->get();
        $view->with('categories',$cate);
    }
}
