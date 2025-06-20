@extends('admin.layout.layout')
@section('content')
    <div class="container">
        <h1 class="mt-4">Edit File</h1>
        <form action="{{ route('file-manager.update', $file->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="name">File Name</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ $file->name }}" required>
            </div>
            <div class="form-group">
                <label for="file">Replace File (optional)</label>
                <input type="file" name="file" id="file" class="form-control">
            </div>
            <button type="submit" class="btn btn-success">Update</button>
        </form>
    </div>
@endsection
