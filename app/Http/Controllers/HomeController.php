<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Tag;
use App\Models\Admin;
use App\Models\Category;
class HomeController extends Controller
{
    public function getdashbroad()
    {
    	$post_count = Post::count();
    	$admin_count = Admin::count();
    	$tag_count = Tag::count();
    	$category_count = Category::count();
    	return view('admin.index',['num_post'=> $post_count,'num_admin'=>$admin_count,'num_tag'=>$tag_count,'num_cate'=>$category_count]);
    }
}
