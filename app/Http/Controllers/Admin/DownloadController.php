<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Download;
use Illuminate\Support\Facades\Storage;

class DownloadController extends Controller
{
    // ================= ADMIN SIDE =================

    public function index()
    {
        $downloads = Download::latest()->get();
        return view('admin.downloads.index', compact('downloads'));
    }

    public function create()
    {
        return view('admin.downloads.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'file' => 'required|file|max:10240',
        ]);

        $file = $request->file('file');
        $path = $file->store('downloads', 'public');

        Download::create([
            'title' => $request->title,
            'description' => $request->description,
            'file_name' => $file->getClientOriginalName(),
            'file_path' => $path,
            'file_type' => $file->getClientOriginalExtension(),
            'uploaded_by' => auth()->id(),
        ]);

        return redirect()->route('admin.downloads.index')
            ->with('success', 'File uploaded successfully.');
    }

    public function show($id)
    {
        $download = Download::findOrFail($id);
        return view('admin.downloads.show', compact('download'));
    }

    public function edit($id)
    {
        $download = Download::findOrFail($id);
        return view('admin.downloads.edit', compact('download'));
    }

    public function update(Request $request, $id)
    {
        $download = Download::findOrFail($id);

        $request->validate([
            'title' => 'required',
        ]);

        $download->update([
            'title' => $request->title,
            'description' => $request->description,
        ]);

        return redirect()->route('admin.downloads.index')
            ->with('success', 'Download updated successfully.');
    }

    public function destroy($id)
    {
        $download = Download::findOrFail($id);

        Storage::disk('public')->delete($download->file_path);

        $download->delete();

        return redirect()->route('admin.downloads.index')
            ->with('success', 'File deleted successfully.');
    }

    // ================= DISTRICT ADMIN SIDE (NEW) =================

    public function districtIndex()
    {
        $downloads = Download::latest()->get();

        return view('district_admin.downloads.index', compact('downloads'));
    }
}