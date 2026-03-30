<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Announcement;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AdminAnnouncementController extends Controller
{
    // --- Display list of announcements ---
    public function index()
    {
        $announcements = Announcement::latest()->paginate(10);
        return view('admin.announcements.index', compact('announcements'));
    }

    // --- Show form to create a new announcement ---
    public function create()
    {
        return view('admin.announcements.create');
    }

    // --- Store new announcement in database ---
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'type' => 'required|in:text,video,photo,document',
            'photo' => 'nullable|image|max:10240', // max 10MB
            'video' => 'nullable|mimetypes:video/mp4,video/avi,video/mov|max:102400', // max 100MB
            'document' => 'nullable|mimes:pdf,doc,docx|max:10240', // max 10MB
        ]);

        $announcement = new Announcement();
        $announcement->title = $request->title;
        $announcement->description = $request->description;
        $announcement->type = $request->type;

        // --- Handle Photo ---
        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $filename = time() . '_' . Str::slug($request->title) . '.' . $photo->getClientOriginalExtension();
            $photo->storeAs('public/announcements/photos', $filename);
            $announcement->photo_path = $filename;
        }

        // --- Handle Video ---
        if ($request->hasFile('video')) {
            $video = $request->file('video');
            $filename = time() . '_' . Str::slug($request->title) . '.' . $video->getClientOriginalExtension();
            $video->storeAs('public/announcements/files', $filename);
            $announcement->video_path = $filename;
        }

        // --- Handle Document ---
        if ($request->hasFile('document')) {
            $document = $request->file('document');
            $filename = time() . '_' . Str::slug($request->title) . '.' . $document->getClientOriginalExtension();
            $document->storeAs('public/announcements/files', $filename);
            $announcement->document_path = $filename;
        }

        $announcement->save();

        return redirect()->route('admin.announcements.index')
                         ->with('success', 'Announcement added successfully!');
    }

    // --- Show single announcement ---
    public function show(Announcement $announcement)
    {
        return view('admin.announcements.show', compact('announcement'));
    }

    // --- Show form to edit an announcement ---
    public function edit(Announcement $announcement)
    {
        return view('admin.announcements.edit', compact('announcement'));
    }

    // --- Update announcement in database ---
    public function update(Request $request, Announcement $announcement)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'type' => 'required|in:text,video,photo,document',
            'photo' => 'nullable|image|max:10240',
            'video' => 'nullable|mimetypes:video/mp4,video/avi,video/mov|max:102400',
            'document' => 'nullable|mimes:pdf,doc,docx|max:10240',
        ]);

        $announcement->title = $request->title;
        $announcement->description = $request->description;
        $announcement->type = $request->type;

        // --- Replace Photo ---
        if ($request->hasFile('photo')) {
            if ($announcement->photo_path) {
                Storage::disk('public')->delete('announcements/photos/' . $announcement->photo_path);
            }
            $photo = $request->file('photo');
            $filename = time() . '_' . Str::slug($request->title) . '.' . $photo->getClientOriginalExtension();
            $photo->storeAs('public/announcements/photos', $filename);
            $announcement->photo_path = $filename;
        }

        // --- Replace Video ---
        if ($request->hasFile('video')) {
            if ($announcement->video_path) {
                Storage::disk('public')->delete('announcements/files/' . $announcement->video_path);
            }
            $video = $request->file('video');
            $filename = time() . '_' . Str::slug($request->title) . '.' . $video->getClientOriginalExtension();
            $video->storeAs('public/announcements/files', $filename);
            $announcement->video_path = $filename;
        }

        // --- Replace Document ---
        if ($request->hasFile('document')) {
            if ($announcement->document_path) {
                Storage::disk('public')->delete('announcements/files/' . $announcement->document_path);
            }
            $document = $request->file('document');
            $filename = time() . '_' . Str::slug($request->title) . '.' . $document->getClientOriginalExtension();
            $document->storeAs('public/announcements/files', $filename);
            $announcement->document_path = $filename;
        }

        $announcement->save();

        return redirect()->route('admin.announcements.index')
                         ->with('success', 'Announcement updated successfully!');
    }

    // --- Delete an announcement ---
    public function destroy(Announcement $announcement)
    {
        if ($announcement->photo_path) {
            Storage::disk('public')->delete('announcements/photos/' . $announcement->photo_path);
        }
        if ($announcement->video_path) {
            Storage::disk('public')->delete('announcements/files/' . $announcement->video_path);
        }
        if ($announcement->document_path) {
            Storage::disk('public')->delete('announcements/files/' . $announcement->document_path);
        }

        $announcement->delete();

        return redirect()->route('admin.announcements.index')
                         ->with('success', 'Announcement deleted successfully!');
    }
}