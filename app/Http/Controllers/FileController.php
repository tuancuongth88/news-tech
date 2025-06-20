<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\File;
use Illuminate\Support\Facades\Session;

class FileController extends Controller
{
    public function index()
    {
        $files = File::all();
        return view('admin.file.index', compact('files'));
    }

    public function create()
    {
        return view('admin.file.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'file' => 'required|file',
        ]);

        $path = $request->file('file')->store('uploads', 'public');

        File::create([
            'name' => $request->name,
            'link' => '/storage/' . $path,
        ]);

        return redirect()->route('admin.file.index')->with('success', 'File uploaded successfully.');
    }

    public function edit(File $file)
    {
        return view('admin.file.edit', compact('file'));
    }

    public function update(Request $request, File $file)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        if ($request->hasFile('file')) {
            $path = $request->file('file')->store('uploads', 'public');
            $file->link = '/storage/' . $path;
        }

        $file->name = $request->name;
        $file->save();

        return redirect()->route('admin.file.index')->with('success', 'File updated successfully.');
    }

    public function destroy(File $file)
    {
        $file->delete();
        return redirect()->route('admin.file.index')->with('success', 'File deleted successfully.');
    }
}
