<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HeroSlide;
use App\Models\HomeSetting;
use Illuminate\Support\Facades\Storage;

class HeroSlideController extends Controller
{
    // Show all slides on the Hero index page
    public function index()
    {
        $slides = HeroSlide::orderBy('sort_order')->get();
        $setting = HomeSetting::first();

        return view('admin.hero.index', compact('slides', 'setting'));
    }

    // Show form to create a new slide
    public function create()
    {
        return view('admin.hero.slides.create'); // Blade page for adding a slide
    }

    // Store new slide
    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|max:2048',
            'title' => 'nullable|string|max:255'
        ]);

        $path = $request->file('image')->store('hero_slides', 'public');

        HeroSlide::create([
            'image' => $path,
            'title' => $request->title,
            'sort_order' => HeroSlide::max('sort_order') + 1,
            'is_active' => 1
        ]);

        return redirect()->route('admin.hero.index')->with('success', 'Slide uploaded');
    }

    // Show form to edit a slide
    public function edit($id)
    {
        $slide = HeroSlide::findOrFail($id);
        return view('admin.hero.slides.edit', compact('slide'));
    }

    // Update slide
    public function update(Request $request, $id)
    {
        $slide = HeroSlide::findOrFail($id);

        $request->validate([
            'image' => 'nullable|image|max:2048',
            'title' => 'nullable|string|max:255'
        ]);

        if ($request->hasFile('image')) {
            // Delete old image
            Storage::disk('public')->delete($slide->image);
            // Store new image
            $slide->image = $request->file('image')->store('hero_slides', 'public');
        }

        $slide->title = $request->title;
        $slide->save();

        return redirect()->route('admin.hero.index')->with('success', 'Slide updated');
    }

    // Toggle slide active/inactive
    public function toggle($id)
    {
        $slide = HeroSlide::findOrFail($id);
        $slide->is_active = !$slide->is_active;
        $slide->save();

        return back();
    }

    // Delete slide
    public function destroy($id)
    {
        $slide = HeroSlide::findOrFail($id);
        Storage::disk('public')->delete($slide->image);
        $slide->delete();

        return back()->with('success', 'Slide deleted');
    }
}