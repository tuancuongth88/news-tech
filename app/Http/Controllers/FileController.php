<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\File;
use Illuminate\Support\Facades\Session;

class FileController extends Controller
{
    public function getList()
    {
    	$files = File::all();
    	return view('admin.file.list',['files'=>$files]);
    }
    public function getDelete($id)
    {
    	$file = File::find($id);
	    	if($file){
	    		$file->delete();
	    		Session::flash('flash_success','Xóa thành công.');
	    	} else {
	    		Session::flash('flash_err','Bài viết không tồn tại.');
	    	}
	    	return redirect()->route('list-file');
    }
}
