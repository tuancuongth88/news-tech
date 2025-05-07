<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;
use Illuminate\Support\Facades\DB;

class MenuComposer
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
        $categories = DB::table('categories')->limit(5)->get();
        $view->with('categories',$categories);
    }
}
