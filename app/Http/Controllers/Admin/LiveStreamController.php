<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LiveStream;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LiveStreamController extends Controller
{
    public function index()
    {
        $streams = LiveStream::orderBy('created_at', 'desc')->get();
        return view('admin.livestreams.index', compact('streams'));
    }

    public function create()
    {
        return view('admin.livestreams.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:radio,youtube,facebook,other',
            'url' => 'nullable|url',
            'description' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'is_active' => 'nullable|boolean',
        ]);

        $data = $request->only('title', 'type', 'url', 'description', 'is_active');

        // Handle logo upload
        if ($request->hasFile('logo')) {
            $path = $request->file('logo')->store('uploads/live_streams', 'public');
            $data['logo'] = $path;
        }

        // Ensure only one active stream
        if (!empty($data['is_active'])) {
            LiveStream::where('is_active', true)->update(['is_active' => false]);
        }

        LiveStream::create($data);

        return redirect()->route('admin.livestreams.index')
                         ->with('success', 'Live stream added successfully.');
    }

    public function edit($id)
    {
        $stream = LiveStream::findOrFail($id);
        return view('admin.livestreams.edit', compact('stream'));
    }

    public function update(Request $request, $id)
    {
        $stream = LiveStream::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:radio,youtube,facebook,other',
            'url' => 'nullable|url',
            'description' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'is_active' => 'nullable|boolean',
        ]);

        $data = $request->only('title', 'type', 'url', 'description', 'is_active');

        // Handle logo upload
        if ($request->hasFile('logo')) {
            // Delete old logo if exists
            if ($stream->logo && Storage::disk('public')->exists($stream->logo)) {
                Storage::disk('public')->delete($stream->logo);
            }
            $path = $request->file('logo')->store('uploads/live_streams', 'public');
            $data['logo'] = $path;
        }

        // Ensure only one active stream
        if (!empty($data['is_active'])) {
            LiveStream::where('is_active', true)->update(['is_active' => false]);
        }

        $stream->update($data);

        return redirect()->route('admin.livestreams.index')
                         ->with('success', 'Live stream updated successfully.');
    }

    public function destroy($id)
    {
        $stream = LiveStream::findOrFail($id);

        // Delete logo from storage
        if ($stream->logo && Storage::disk('public')->exists($stream->logo)) {
            Storage::disk('public')->delete($stream->logo);
        }

        $stream->delete();

        return redirect()->route('admin.livestreams.index')
                         ->with('success', 'Live stream deleted successfully.');
    }

    public function setActive($id)
    {
        LiveStream::where('is_active', true)->update(['is_active' => false]);

        $stream = LiveStream::findOrFail($id);
        $stream->is_active = true;
        $stream->save();

        return redirect()->back()->with('success', 'Live stream set as active.');
    }

    public function viewCurrent()
    {
        $currentStream = LiveStream::active()->first();
        return view('livestreams.view', compact('currentStream'));
    }
}