<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Devotion;

class DevotionController extends Controller
{
    /**
     * Display a listing of devotions.
     */
    public function index()
    {
        $devotions = Devotion::orderBy('date', 'desc')->paginate(10);
        return view('admin.devotions.index', compact('devotions'));
    }

    /**
     * Show the form for creating a new devotion.
     */
    public function create()
    {
        return view('admin.devotions.create');
    }

    /**
     * Store a newly created devotion.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'date' => 'required|date',
            'content' => 'required|string',
            'thumbnail' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        // Handle thumbnail upload
        if ($request->hasFile('thumbnail')) {
            $file = $request->file('thumbnail');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/devotions'), $filename);
            $validated['thumbnail'] = 'uploads/devotions/' . $filename;
        }

        Devotion::create($validated);

        return redirect()->route('admin.devotions.index')
            ->with('success', 'Devotion created successfully.');
    }

    /**
     * Show the form for editing the specified devotion.
     */
    public function edit(Devotion $devotion)
    {
        return view('admin.devotions.edit', compact('devotion'));
    }

    /**
     * Update the specified devotion.
     */
    public function update(Request $request, Devotion $devotion)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'date' => 'required|date',
            'content' => 'required|string',
            'thumbnail' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        // Handle thumbnail upload
        if ($request->hasFile('thumbnail')) {
            // Delete old thumbnail
            if ($devotion->thumbnail && file_exists(public_path($devotion->thumbnail))) {
                unlink(public_path($devotion->thumbnail));
            }

            $file = $request->file('thumbnail');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/devotions'), $filename);
            $validated['thumbnail'] = 'uploads/devotions/' . $filename;
        }

        $devotion->update($validated);

        return redirect()->route('admin.devotions.index')
            ->with('success', 'Devotion updated successfully.');
    }

    /**
     * Remove the specified devotion.
     */
    public function destroy(Devotion $devotion)
    {
        // Delete thumbnail
        if ($devotion->thumbnail && file_exists(public_path($devotion->thumbnail))) {
            unlink(public_path($devotion->thumbnail));
        }

        $devotion->delete();

        return redirect()->route('admin.devotions.index')
            ->with('success', 'Devotion deleted successfully.');
    }

    /**
     * Show the specified devotion.
     */
    public function show(Devotion $devotion)
    {
        return view('admin.devotions.show', compact('devotion'));
    }
}
