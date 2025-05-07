<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\Admin;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class Profilecontroller extends Controller
{
    public function getProfile()
    {
    	$profile = Admin::find(Auth::user()->id);
    	return view('admin.author.profile',['profile'=>$profile]);
    }
    public function profileUpdate(Request $request)
    {
        if($request->input('name') == Auth::user()->name && $request->input('email') != Auth::user()->email ){
            $rules= [
                'name'=>'required|min:3|max:100',
                'password' =>'required|min:4 | max:100',
                'email'=> 'required| email |unique:admin,email',
                'birthday'=> ' date',
                ];
        } else if($request->input('email') == Auth::user()->email && $request->input('name') != Auth::user()->name){
            $rules= [
                'name'=>'required|min:3|max:100|unique:admin,name',
                'password' =>'required|min:4|max:100',
                'email'=> 'required|email',
                'birthday'=> 'date',
                ];
        } else if ($request->input('name') == Auth::user()->name && $request->input('email') == Auth::user()->email ) {
            $rules= [
                'name'=>'required|min:3|max:100',
                'password' =>'required|min:4|max:100',
                'email'=> 'required|email',
                'birthday'=> 'date',
            ];
        } else {
            $rules= [
                'name'=>'required|min:3|max:100|unique:admin,name',
                'password' =>'required|min:4 | max:100',
                'email'=> 'required| email | unique:admin,email',
                'birthday'=> 'date',
                ];
        }

    	$msg = [
    			'required'=>'Không được bỏ trống :attribute.',
    			'name.unique' => 'Tên này đã bị trùng, vui lòng nhập lại!',
    			'name.min'=>'Tên gồm ít nhất 3 ký tự!',
    			'name.max'=>'Tên gồm tối đa 100 ký tự!',
    			'password.min'=>'Password gồm ít nhất 4 ký tự!',
    			'password.max'=>'Password gồm tối đa 100 ký tự!',
    			'email'=>'Email không chính xác.',
    			'email.unique'=> 'Email đã tồn tại.',
    			'birthday.date' => 'Sai định dạng ngày!',
    			];
		$validator = Validator::make($request->all(), $rules , $msg);

		if ($validator->fails()) {
		    return redirect()->back()
		                ->withErrors($validator)
		                ->withInput();
		} else {
			$profile = Admin::find(Auth::user()->id);
			$profile->name = $request->input('name');
	    	$profile->email = $request->input('email');
	    	$profile->birthday = $request->input('birthday');
	    	$profile->password= bcrypt($request->input('password'));
            //Upload Image
            if($request->hasFile('avatar')){
                $file = $request->file('avatar');
                $file_extension = $file->getClientOriginalExtension(); // Lấy đuôi của file
                if($file_extension != 'png' && $file_extension != 'jpg' && $file_extension != 'jpeg'){
                    return redirect()->back()->with('errfile','Chưa hỗ trợ định dạng file vừa upload.');
                }
                $file_name = $file->getClientOriginalName();
                $random_file_name = Str::random(4).'_'.$file_name;
                while(file_exists('upload/profiles/'.$random_file_name)){
                    $random_file_name = Str::random(4).'_'.$file_name;
                }
                $file->move('upload/profile',$random_file_name);
                $file_upload = 'upload/profile/'.$random_file_name;
                $profile->avatar = $file_upload;
            } else $profile->avatar = '';

            $profile->save();
	    	Session::flash('flash_success','Thay đổi thành công.');
    		return redirect()->back();
		}
    }
}
