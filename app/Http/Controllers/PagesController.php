<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Category;
use App\Models\File;
use App\Models\Tag;
use App\Models\Admin;

class PagesController extends Controller
{
    public function getindex()
    {
        try {
            $cates = Category::where('name','!=','video')->whereNotNull('parent_id')->get();
            $videos = Post::query()->where('post_type','=','video')->take(5)->orderBy('created_at','desc')->get();
            $postNew = Post::query()->where('status',1)->orderBy('id','desc')->take(5)->get();
            return view('news.theme-1.pages.home',['cates'=>$cates,'videos'=>$videos, 'postNew' => $postNew]);
//            return view('news.pages.home',['cates'=>$cates,'videos'=>$videos]);
        }catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ]);
        }

    }
    public function getCategory($slug)
    {
        $cate = Category::where('slug', $slug)->first();
        $categories = Category::where('parent_id',$cate->id)->get();
        if ($categories->count() == 0) {
            $categories = $cate;
        }
        if(!$cate || !$cate->posts){
            return view('news.theme-1.pages.category',['key'=>$slug]);
        } else {
            $listHot = Post::whereIn('category_id',$categories->pluck('id'))
                            ->where('status',1)
                            ->where('created_at','>=',now()->subDays(5))
                            ->orderBy('view','desc')
                            ->take(5)->get();
            $list = Post::whereIn('category_id',$categories->pluck('id')->toArray())->where('status',1)->orderBy('id','desc')->paginate(10);
            return view('news.theme-1.pages.category',['posts'=>$list, 'listHot' => $listHot, 'cate'=>$cate, 'listCategory' => $categories]);
        }

    }

    public function getSubCategory($slug, $sub_slug)
    {
        $cate = Category::where('slug', $slug)->first();
        $cates = Category::where('parent_id', $cate->id)->get();
        $sub_cate = Category::where('slug', "$slug/$sub_slug")->first();
        if(!$cate || !$sub_cate || !$sub_cate->posts){
            return view('news.pages.category',['key'=>$slug]);
        } else {
            $listHot = Post::where('category_id',$sub_cate->id)
                ->where('status',1)
                ->where('created_at','>=',now()->subDays(5))
                ->orderBy('view','desc')
                ->take(5)->get();
            $list = Post::where('category_id',$sub_cate->id)->where('status',1)->orderBy('id','desc')->paginate(10);
            return view('news.theme-1.pages.category',['posts'=>$list,'listHot' => $listHot,'cate'=>$cate, 'sub_cate' =>$sub_cate,'listCategory' => $cates]);
        }
    }

    public function getPost($slug)
    {
        $post = Post::where('status',1)->where('slug', $slug)->first();
        if(!$post){
            return view('news.pages.singlepost',['key'=>$slug]);
        } else
        {
            $post->view = $post->view + 1;
            $post_lq = Post::where('status',1)->where('slug','!=', $slug)->where('category_id','=',$post->category_id)->take(5)->get();
            $post->save();
            return view('news.theme-1.pages.singlepost',['post'=>$post,'lq'=>$post_lq]);
        }
    }
    public function getTag($key)
    {
    	$tag = Tag::where('name', $key)->first();
        if(!$tag || !$tag->posts){
            return view('news.pages.tag',['key'=>$key]);
        } else
        return view('news.pages.tag',['tag'=>$tag]);
    }
    public function getSearch(Request $request)
    {
        $key= $request->input('key');
    	$posts = Post::where('status',1)->where('title', 'like', '%'.$key.'%')->get();
        return view('news.pages.search',['posts'=>$posts,'key'=>$key]);
    }
    public function getAuthor($user)
    {
        $author = Admin::where('name',$user )->first();
        if(!$author || !$author->posts){
            return view('news.pages.author',['key'=>$user]);
        } else
        return view('news.pages.author',['author'=>$author]);
    }
    public function getContact()
    {
    	return view('news.pages.contact');
    }
}
