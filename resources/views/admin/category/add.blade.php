@extends('admin.layout.layout')

@section('content')
<!-- Page Content -->
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Chuyên Mục
                    <small>Thêm</small>
                </h1>
            </div>
            <!-- /.col-lg-12 -->
            <div class="col-lg-7">
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
                <form action="admin/category/add" method="POST">
                  <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="form-group">
                        <label>Tên Chuyên Mục</label>
                        <input class="form-control" name="cate_name" id="title" placeholder="Tên Chuyên Mục" />
                    </div>
                     <div class="form-group">
                        <label>Đường dẫn</label>
                        <input class="form-control" name="slug" id="slug" placeholder="Slug được tạo tự động" />
                    </div>
                    <div class="form-group">
                        <label>Thuộc Chuyên Mục</label>
                         <select class="form-control" name="parent_id">
                            <option disabled selected value> -- Chuyên Mục cha -- </option>
                        @foreach($cates as $cate)
                            <option value="{{ $cate->id }}">{{ $cate->name }}</option>
                        @endforeach
                    </select>
                    </div>
                    <button type="reset" class="btn btn-default">Làm mới</button>
                    <button type="submit" class="btn btn-primary">Thêm</button>
                </form>
            </div>
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</div>
<!-- /#page-wrapper -->
@endsection
@section('script')
    <script src="js/slug.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#title').keyup(function(event) {
                var title = $('#title').val();
                var slug = ChangeToSlug(title);
                $('#slug').val(slug);
            });
        });
    </script>
@endsection
