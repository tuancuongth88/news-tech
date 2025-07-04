<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;
use App\Models\Post;

class TinNoiBatComposer
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
        $mostViewedPost = Post::query()->where('status', 1)
            ->when(Post::query()->whereDate('created_at', now())->exists(), function ($query) {
                return $query->whereDate('created_at', now());
            })
            ->orderBy('view', 'desc')
            ->orderBy('created_at', 'desc')
            ->first();

        $otherPosts = Post::query()->where('status', 1)
            ->where('id', '!=', $mostViewedPost->id)
            ->when(Post::query()->whereDate('created_at', now())->exists(), function ($query) {
                return $query->whereDate('created_at', now());
            })
            ->orderBy('view', 'desc')
            ->orderBy('created_at', 'desc')
            ->limit(6)->get();

        $view->with('mostViewedPost', $mostViewedPost)
            ->with('otherPosts', $otherPosts);
    }
}
