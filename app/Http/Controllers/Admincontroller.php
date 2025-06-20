<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Crypt;

class Admincontroller extends Controller
{
    public function getList()
    {
    	return view('admin.author.list');
    }

    public function postAdd(Request $request)
    {
    	if($request->ajax()){
	    	$author = new Admin();
	    	$author->name = $request->input('authorname');
	    	$author->password =bcrypt($request->input('password'));
	    	$author->email = $request->input('email');
	    	$author->save();
	        return 'ok';
	    }
    }

    public function dataTable()
    {
        try {
            $model = Admin::where('role','!=','admin');
            $data = DataTables::of($model)
                ->addColumn('post_count', function(Admin $author) {
                    return $author->posts->count().' bài viết';
                })
                ->addColumn('action', '
                    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#show-delete">
                    	<i class="fa fa-trash" aria-hidden="true"></i> Xoá
                    </button>')
                ->make(true);
            return $data;
        }catch (\Exception $e) {
            dd($e);
        }

    }

    public function delete(Request $request)
    {
    	if($request->ajax()){
    		$author = Admin::find($request->input('id'));
    		if($author->delete()){
    			return 'ok';
    		} else return 'Không thể xóa.';
    	} else return 'err';
    }
}
