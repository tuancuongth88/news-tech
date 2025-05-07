@extends('admin.layout.layout')
@section('content')     
<!-- Page Content -->
<style type="text/css">
.white-box {
    background: rgb(255, 255, 255);
    padding: 20px;
    padding-bottom: 0;
}
.user-bg {
    height: 197px;
    position: relative;
    margin: -25px;
    overflow: hidden;
}
.user-bg .overlay-box {
    opacity: 0.9;
    position: absolute;
    top: 0px;
    left: 0px;
    right: 0px;
    height: 100%;
    text-align: center;
    background: rgb(112, 124, 210);
}
.user-bg .overlay-box .user-content {
    margin-top: 20px;
    padding: 15px;
}
.thumb-lg {
    height: 88px;
    width: 88px;
}
.img-circle {
    border-radius: 50%;
}
.text-white {
    color: rgb(255, 255, 255);
}
h4 {
    line-height: 22px;
    font-size: 18px;
}
.user-btm-box {
    clear: both;
    padding: 40px 0px 10px;
    overflow: hidden;
}
h2 {
    line-height: 25px;
    font-size: 25px;
}
.text-purple {
    color: #707cd2;
}
.text-danger {
    color: #f33155;
}
</style>
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row" style="margin-bottom: 40px">
        		<div class="col-lg-12">
                <h1 class="page-header">Profile</h1>
                </div>
            <div class="col-lg-4">
            	<div class="panel panel-default">
                    <div class="panel-heading">
                        <i class="fa fa-user fa-fw"></i> Thông tin cá nhân
                    </div>
                    <div class="panel-body">
                        <div class="white-box">
                            <div class="user-bg"> <img width="100%" alt="user" src="https://wrappixel.com/ampleadmin/ampleadmin-html/plugins/images/large/img1.jpg">
                                <div class="overlay-box">
                                    <div class="user-content">
                                        <a href="javascript:void(0)"><img src="{{ $profile->avatar}}" class="thumb-lg img-circle" alt="img"></a>
                                        <h4 class="text-white">{{ $profile->name }}</h4>
                                        <h5 class="text-white">{{ $profile->email }}</h5> </div>
                                </div>
                            </div>
                            <div class="user-btm-box">
                                <div class="col-md-6 col-sm-6 text-center">
                                    <p class="text-purple"><i class="fa fa-pencil fa-fw"></i></p>
                                    <h1>{{ $profile->posts->count('name')}}</h1> </div>
                                <div class="col-md-6 col-sm-6 text-center">
                                    <p class="text-danger"><i class="fa fa-file" aria-hidden="true"></i></i></p>
                                    <h2>125</h2> </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-7">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <i class="fa fa-cog" aria-hidden="true"></i> Thiết Đặt
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#home" data-toggle="tab" aria-expanded="true">Cập nhật Profile</a>
                            </li>
                            <li class=""><a href="#posts" data-toggle="tab" aria-expanded="false">Các bài đăng</a>
                            </li>
                        </ul>

                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div class="tab-pane fade active in" id="home">
                            	<br>
                            	@if(count($errors)>0)
				                    <div class="alert alert-danger">
				                        @foreach($errors->all() as $err)
				                            {{ $err }}<br>
				                        @endforeach
				                    </div>
				                @endif
				                @if(Session::has('flash_success'))
					                <div class="alert alert-success">
					                    {{ session('flash_success') }}
					                </div>
				                @endif
                                <form action="admin/profile/update" method="POST" enctype="multipart/form-data">
					                <input type="hidden" name="_token" value="{{ csrf_token() }}">
					                    <div class="form-group">
					                        <label>Username</label>
					                        <input class="form-control" name="name" value="{{ $profile->name }}" />
					                    </div>
					                     <div class="form-group">
					                        <label>Password</label>
					                        <input class="form-control" name="password" type="password">
					                    </div>
					                     <div class="form-group">
					                        <label>Email</label>
					                        <input class="form-control" name="email" type="text" value="{{ $profile->email }}" />
					                    </div>
					                     <div class="form-group">
					                        <label>Avatar</label>
					                        <input class="form-control" name="avatar" type="file"/>
					                    </div>
					                     <div class="form-group">
					                        <label>Ngày Sinh</label>
					                        <input class="form-control" name="birthday" type="date" />
					                    </div>
					                    <button type="reset" class="btn btn-default btn-sm">Làm mới</button>
					                    <button type="submit" class="btn btn-success btn-sm">Cập Nhật</button>
					             </form>
                            </div>
                            <div class="tab-pane fade" id="posts">
                            	<h3>Danh sách các bài viết của bạn</h3>
                            	<div class="list-group">
                                 @foreach($profile->posts as $post)
                                        <a href="{{$post->slug}}"><p><i class="fa fa-arrow-circle-right"></i> {{$post->title}} </p></a>
                                    
                                @endforeach
                            	</div>
                            </div>
                        </div>
                    </div>
                    <!-- /.panel-body -->
                </div>
                <!-- /.panel -->
            </div>
        </div>
    </div>
</div>
@endsection