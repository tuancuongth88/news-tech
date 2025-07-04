@extends('admin.layout.layout')
@section('content')
    <div class="container">
        <h1 class="mt-4">Upload New File</h1>
        <form action="{{ route('file-manager.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="name">File Name</label>
                <input type="text" name="name" id="name" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="file">Choose File</label>
                <input type="file" name="file" id="file" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-success">Upload</button>
        </form>
    </div>
@endsection
