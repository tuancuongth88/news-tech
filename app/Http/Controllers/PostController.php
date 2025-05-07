<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Category;
use App\Models\Tag;
use App\Models\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class PostController extends Controller
{
    public function getList()
    {
    	$posts = Post::all();
        if(Auth::user()->role=='author'){
            $posts = $posts->where('user_id',Auth::user()->id);
        }
    	return view('admin.post.list',['posts'=>$posts]);
    }
    public function getAdd()
    {
    	$cates = Category::all();
    	$tags = Tag::all();
    	return view('admin.post.add',['cates'=>$cates,'tags'=>$tags]);
    }
    public function postAdd(Request $request)
    {
    	$rules= [
    			'title'=>'required|min:3|max:100',
    			'des' =>'required|max:180',
    			'category_id'=> 'required| integer',
    			'content'=> 'required',
    			'slug'=> 'required|unique:posts,slug|alpha_dash',
    			];
    	$msg = [
    			'title.required'=>'Không được bỏ trống tiêu đề.',
    			'title.unique' => 'Tin này đã bị trùng, vui lòng nhập lại!',
    			'title.min'=>'Tên tin tức gồm ít nhất 3 ký tự!',
    			'title.max'=>'Tên tin tức gồm tối đa 100 ký tự!',
    			'des.required'=>'Không được bỏ trống tóm tắt.',
    			'content.required'=>'Không được bỏ trống nội dung',
    			'category_id.required'=> 'Không được bỏ trống chuyên mục.',
    			'category_id.integer'=> 'Chọn sai chuyên mục.',
    			'slug.unique' => 'Url đã tồn tại, vui lòng nhập lại tiều đề!',
                'slug.required'=> 'Không được bỏ trống url',
                'slug.alpha_dash'=> 'Sai định dạng slug.',
    			];
		$validator = Validator::make($request->all(), $rules , $msg);

		if ($validator->fails()) {
		    return redirect()->back()
		                ->withErrors($validator)
		                ->withInput();
		} else {
	    	$post = new Post();
	    	$post->title = $request->input('title');
	    	$post->content = $request->input('content');
	    	$post->description = $request->input('des');
            $post->status = 0;
            if(Auth::user()->role =='admin'){
                $post->status = 1;
            }
	    	$post->slug = $request->input('slug');
	    	$post->user_id = Auth::user()->id;
	    	$post->category_id = $request->input('category_id');
	    	//Upload Image
	    	if($request->hasFile('img_post')){
	    		$file = $request->file('img_post');
	    		$file_extension = $file->getClientOriginalExtension(); // Lấy đuôi của file
	    		if($file_extension == 'png' || $file_extension == 'jpg' || $file_extension == 'jpeg'){
	    			$post->post_type = 'text';
	    		} else if($file_extension == 'mp4' || $file_extension == '3gp' || $file_extension == 'avi' || $file_extension == 'flv'){
	    			$post->post_type = 'video';
	    		} else return redirect()->back()->with('errfile','Chưa hỗ trợ định dạng file vừa upload.')->withInput();

	    		$file_name = $file->getClientOriginalName();
	    		$random_file_name = Str::random(4).'_'.$file_name;
	    		while(file_exists('upload/posts/'.$random_file_name)){
	    			$random_file_name = Str::random(4).'_'.$file_name;
	    		}
	    		$file->move('upload/posts',$random_file_name);
	    		// $file_upload = new File();
	    		// $file_upload->name = $random_file_name;
	    		// $file_upload->link = 'upload/posts/'.$random_file_name;
	    		// $file_upload->post_id = $post->id;
	    		// $file_upload->save();
	    		$post->feture = 'upload/posts/'.$random_file_name;
	    	} else $post->feture='';
	    	$post->save();
	    	// Inset to table tag.
	    	$post->tags()->sync( $request->input('tags') ,false);
    	}
    	Session::flash('flash_success','Thêm tin tức thành công.');
    	return redirect()->route('list-post');
    }
    public function getUpdate($id)
    {
    	$post = Post::find($id);
        if($post){
            if($post->user_id == Auth::user()->id){
                $cates = Category::all();
                $cates2 = array();
                foreach ($cates as $cate) {
                    $cates2[$cate->id] = $cate->name;
                }
                $tags = Tag::all();
                $tags2 = array();
                foreach ($tags as $tag) {
                    $tags2[$tag->id] = $tag->name;
                }
                return view('admin.post.edit',['post'=>$post,'cates'=>$cates2,'tags'=>$tags2]);
            } else {
                 Session::flash('flash_err','Bạn không có quyền thay đổi.');
                return redirect()->route('list-post');
            }
        }
    	else {
            Session::flash('flash_err','Sai Thông tin Bài Viết.');
            return redirect()->route('list-post');
        }

    }

    public function postUpdate(Request $request,$id)
    {
    	$post = Post::find($id);
        if( $post ) {
            if($post->user_id == Auth::user()->id){
            	if($post->slug == $request->input('slug')){
                    $rules= [
                        'title'=>'required|min:3|max:100',
                        'des' =>'required|max:180',
                        'category_id'=> 'required| integer',
                        'content'=> 'required',
                    ];
                    $msg = [
                        'title.required'=>'Không được bỏ trống tiêu đề.',
                        'title.unique' => 'Tin này đã bị trùng, vui lòng nhập lại!',
                        'title.min'=>'Tên tin tức gồm ít nhất 3 ký tự!',
                        'title.max'=>'Tên tin tức gồm tối đa 100 ký tự!',
                        'des.required'=>'Không được bỏ trống tóm tắt.',
                        'content.required'=>'Không được bỏ trống nội dung',
                        'category_id.required'=> 'Không được bỏ trống chuyên mục.',
                        'category_id.integer'=> 'Chọn sai chuyên mục.',
                    ];
            	} else {
                	$rules= [
            			'title'=>'required|min:3|max:100',
            			'des' =>'required|max:180',
            			'category_id'=> 'required| integer',
            			'content'=> 'required',
            			'slug'=> 'required|unique:posts,slug|alpha_dash',
            		];
                	$msg = [
            			'title.required'=>'Không được bỏ trống tiêu đề.',
            			'title.unique' => 'Tin này đã bị trùng, vui lòng nhập lại!',
            			'title.min'=>'Tên tin tức gồm ít nhất 3 ký tự!',
            			'title.max'=>'Tên tin tức gồm tối đa 100 ký tự!',
            			'des.required'=>'Không được bỏ trống tóm tắt.',
            			'content.required'=>'Không được bỏ trống nội dung',
            			'category_id.required'=> 'Không được bỏ trống chuyên mục.',
            			'category_id.integer'=> 'Chọn sai chuyên mục.',
            			'slug.unique' => 'Url đã tồn tại, vui lòng nhập lại tiều đề!',
                        'slug.required'=> 'Không được bỏ trống url',
                        'slug.alpha_dash'=> 'Sai định dạng slug.',
            		];
                }
        		$validator = Validator::make($request->all(), $rules , $msg);

        		if ($validator->fails()) {
        		    return redirect()->back()
        		                ->withErrors($validator)
        		                ->withInput();
        		} else {
            		$post->title = $request->input('title');
        	    	$post->content = $request->input('content');
        	    	$post->description = $request->input('des');
        	    	$post->slug = $request->input('slug');
        	    	$post->user_id = Auth::user()->id;
        	    	$post->category_id = $request->input('category_id');
                    //Upload Image
                    if($request->hasFile('img_post')){
                        ini_set('memory_limit','256M');
                        $file = $request->file('img_post');
                        $file_extension = $file->getClientOriginalExtension(); // Lấy đuôi của file
                        if($file_extension == 'png' || $file_extension == 'jpg' || $file_extension == 'jpeg'){
                            $post->post_type = 'text';
                        } else if($file_extension == 'mp4' || $file_extension == '3gp' || $file_extension == 'avi' || $file_extension == 'flv'){
                            $post->post_type = 'video';
                        } else return redirect()->back()->with('errfile','Chưa hỗ trợ định dạng file vừa upload.')->withInput();

                        $file_name = $file->getClientOriginalName();
                        $random_file_name = Str::random(4).'_'.$file_name;
                        while(file_exists('upload/posts/'.$random_file_name)){
                            $random_file_name = Str::random(4).'_'.$file_name;
                        }
                        $file->move('upload/posts',$random_file_name);
                        // $file_upload = new File();
                        // $file_upload->name = $random_file_name;
                        // $file_upload->post_id = $post->id;
                        // $file_upload->save();
                        $post->feture = 'upload/posts/'.$random_file_name;
                    }

                    $post->save();

        	    	if($request->input('tags')){
        	    		$post->tags()->sync( $request->input('tags') );
        	    	} else {
        	    		$post->tags()->sync( array() );
        	    	}
        	    	Session::flash('flash_success','Thay đổi thành công.');
            		return redirect()->route('list-post');
                }
            } else {
                    Session::flash('flash_err','Bạn không có quyền thay đổi.');
                    return redirect()->route('list-post');
                }
        } else {
            Session::flash('flash_err','Sai thông tin bài viết.');
            return redirect()->route('list-post');
        }
    }

    public function getDelete($id)
    {
    	$post = Post::find($id);
	    	if( $post ){
                if( $post->user_id == Auth::user()->id || Auth::user()->role == 'admin' ){
                    $post->tags()->detach();
                    $post->delete();
                    Session::flash('flash_success','Xóa thành công.');
                    return redirect()->route('list-post');
                } else {
                    Session::flash('flash_err','Bạn không có quyền xóa bài.');
                    return redirect()->route('list-post');
                }
	    	} else {
	    		Session::flash('flash_err','Bài viết không tồn tại.');
	    	}
	    	return redirect()->route('list-post');
    }
    public function updateStatus(Request $request)
    {
        if($request->ajax()){
            $post = Post::find($request->input('id'));
            if( $post ){
                if( Auth::user()->role == 'admin' ){
                    if($request->input('status')== 0 || $request->input('status')==1 ){
                        $post->status =$request->input('status');
                        $post->save();
                        return 'ok';
                    } else { return 'Sai trạng thái.';}
                } else { return 'Bạn không đủ quyền'; }
            } else { return 'Bài viết không tồn tại.'; }
        }
    }
    public function updateHot(Request $request)
    {
        if($request->ajax()){
            $post = Post::find($request->input('id'));
            if( $post ){
                if( Auth::user()->role == 'admin' ){
                    if($request->input('hot')== 0 || $request->input('hot')==1 ){
                        $post->hot = $request->input('hot');
                        $post->save();
                        return 'ok';
                    } else { return 'Sai trạng thái.';}
                } else { return 'Bạn không đủ quyền'; }
            } else { return 'Bài viết không tồn tại.'; }
        }
    }
}
