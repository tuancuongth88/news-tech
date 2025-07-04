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
