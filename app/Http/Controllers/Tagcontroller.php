<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tag;
use Yajra\DataTables\DataTables;

class Tagcontroller extends Controller
{
    public function getList()
    {
    	return view('admin.tag.list');
    }

    public function postAdd(Request $request)
    {
    	if($request->ajax()){
    	// $this->validate($req,
    	// 	[
    	// 		'cate_name'=>'required|unique:categories,name|min:3|max:70',
     //            'slug'=> 'required|unique:categories,slug|alpha_dash|max:100',
     //            'parent_id'=> 'integer',
    	// 	],
    	// 	[
    	// 		'cate_name.required'=>'Bạn chưa nhập tên chuyên mục!',
     //            'cate_name.min'=>'Tên chuyên mục gồm ít nhất 3 ký tự!',
     //            'cate_name.max'=>'Tên chuyên mục gồm tối đa 50 ký tự!',
    	// 		'slug.unique' => 'Url chuyên mục đã tồn tại, vui lòng nhập lại tên!',
     //            'slug.required'=> 'Không được bỏ trống url',
     //            'slug.alpha_dash'=> 'Sai định dạng slug.',
     //            'parent_id.integer' => 'Chuyên mục cha phải là số.'
    	// 	]);
	    	$tag = new Tag();
	    	$tag->name = $request->input('tag-name');
	    	$tag->slug = $request->input('slug');
	    	$tag->save();
	        return 'ok';
	    }
    }

    public function dataTable()
    {
    	$model = Tag::query();
    	return DataTables::of($model)
    			->addColumn('post_count', function(Tag $tag) {
                    return $tag->posts->count() . ' bài';
                })
                ->addColumn('action', '
                	<button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#show-update">
                		<i class="fa fa-pencil-square-o" aria-hidden="true"></i> Sửa
                	</button>
                    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#show-delete">
                    	<i class="fa fa-trash" aria-hidden="true"></i> Xoá
                    </button>')
                ->make(true);
    }

    public function putUpdate(Request $request)
    {
   	if($request->ajax()){
	  //       $rules = [
	  //   		'tag-name' => 'required | max : 25 ',
	  //   		'slug' => 'required'
	  //   	];

	  //   	$msg = [
			//     'required' => ':attribute không được bỏ trống.',
			//     'tag-name.max' => 'Username phải nhỏ hơn :max ký tự.',
			// ];

	  //   	$validator = Validator::make($request->all(), $rules , $msg);

	  //   	if ($validator->fails()) {
	  //           return 'err';
	  //       } else {
	    		$tag = Tag::find($request->input('id'));
	    		if( $tag ) {
	    			if( $request->input('tag-name') && $request->input('slug')){

	    				$tag->name = $request->input('tag-name');
	                    $tag->slug = $request->input('slug');
	                    $tag->save();
	                    return 'ok';
	    			} else return 'Không được bỏ trống tên và đường dẫn.';
	    		} else return 'Sai ID';
	    	//}
    	}
    }

    public function delete(Request $request)
    {
    	if($request->ajax()){
    		$tag = Tag::find($request->input('id'));
    		if($tag){
                $tag->posts()->detach();
                $tag->delete();
                return 'ok';
    		}
    		else return 'Không tồn tại tag.';
    	} else return 'err';
    }
}
