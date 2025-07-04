@extends('admin.layout.layout')
@section('content')
    <div class="container">
        <h1 class="mt-4">File Management</h1>
        <a href="{{ route('file-manager.create') }}" class="btn btn-primary mb-3">Upload New File</a>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Link</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($files as $file)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $file->name }}</td>
                    <td><a href="{{ $file->link }}" target="_blank">View File</a></td>
                    <td>
                        <a href="{{ route('admin.file.edit', $file->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('admin.file.destroy', $file->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
