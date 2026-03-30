<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AnnouncementController extends Controller
{
    // --- List all announcements ---
    public function index()
    {
        $announcements = Announcement::orderBy('created_at', 'desc')->paginate(10);
        return view('pages.announcements.index', compact('announcements'));
    }

    // --- Show a single announcement ---
    public function show(Announcement $announcement)
    {
        // Convert storage paths to URLs
        if ($announcement->video_path) {
            $announcement->video_path = Storage::url('announcements/files/' . $announcement->video_path);
        }

        if ($announcement->document_path) {
            $announcement->document_path = Storage::url('announcements/files/' . $announcement->document_path);
        }

        if ($announcement->photo_path) {
            $announcement->photo_path = Storage::url('announcements/photos/' . $announcement->photo_path);
        }

        return view('pages.announcements.show', compact('announcement'));
    }
}