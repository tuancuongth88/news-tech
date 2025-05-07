<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\DataTables;

class CategoryController extends Controller
{
    public function getList()
    {
    	$cates = Category::all();
    	return view('admin.category.list',["cates"=>$cates]);
    }
    public function getAdd()
    {
    	$cates = Category::all();
    	return view('admin.category.add',["cates"=>$cates]);
    }
    public function postAdd(Request $req)
    {
    	$this->validate($req,
    		[
    			'cate_name'=>'required|unique:categories,name|min:3|max:70',
                'slug'=> 'required|unique:categories,slug|alpha_dash|max:100',
                'parent_id'=> 'integer',
    		],
    		[
    			'cate_name.required'=>'Bạn chưa nhập tên chuyên mục!',
                'cate_name.min'=>'Tên chuyên mục gồm ít nhất 3 ký tự!',
                'cate_name.max'=>'Tên chuyên mục gồm tối đa 50 ký tự!',
    			'slug.unique' => 'Url chuyên mục đã tồn tại, vui lòng nhập lại tên!',
                'slug.required'=> 'Không được bỏ trống url',
                'slug.alpha_dash'=> 'Sai định dạng slug.',
                'parent_id.integer' => 'Chuyên mục cha phải là số.'
    		]);
    	$cate = new Category();
    	$cate->name = $req->input('cate_name');
    	$cate->slug = $req->input('slug');
    	if( $req->input('parent_id') ){
			$parent_id = Category::find($req->input('parent_id'));
			if( $parent_id ){
				$cate->parent_id = $req->input('parent_id');
			}
    	}
    	$cate->save();
    	Session::flash('flash_success','Thêm chuyên mục thành công.');
        return redirect('admin/category/add');
    }
    public function dataTable()
    {

    	$model = Category::query();

    	return DataTables::eloquent($model)
                ->addColumn('post_count', function(Category $cate1) {
                    return $cate1->posts->count().' bài viết';
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

    public function postUpdate(Request $request)
    {
    	if($request->ajax()){

    		$cate = Category::find($request->input('id'));
    		if( $cate ) {
    			if( $request->input('cate-name') && $request->input('slug')){

    				$cate->name = $request->input('cate-name');
                    $cate->slug = $request->input('slug');
                    if( $parent_id = $request->input('parent') ){
                        $cate->parent_id = $parent_id;
                    }
    			} else return 'Không được bỏ trống tên và đường dẫn.';
    			$cate->save();
    			return 'ok';
    		} else return 'Sai ID';
    	}
    }

    public function delete(Request $request)
    {
    	if($request->ajax()){
    		$cate = Category::find($request->input('id'));
    		if( $cate ) {
    			$cate->delete();
    			return 'ok';
    		} else return 'err';
    	}
    }
}
