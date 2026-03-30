<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HomeSetting;
use App\Models\HeroSlide;

class HeroController extends Controller
{
    // Show the current theme & scripture + all hero slides
    public function index()
    {
        $setting = HomeSetting::first();           // fetch theme & scripture
        $slides  = HeroSlide::orderBy('sort_order')->get(); // fetch all slides

        return view('admin.hero.index', compact('setting', 'slides'));
    }

    // Show form to create new theme/scripture
    public function create()
    {
        return view('admin.hero.create');
    }

    // Store new theme/scripture
    public function store(Request $request)
    {
        $request->validate([
            'theme' => 'required|string|max:255',
            'scripture' => 'required|string|max:255',
        ]);

        HomeSetting::create($request->all());

        return redirect()->route('admin.hero.index')->with('success', 'Home settings saved.');
    }

    // Edit existing theme/scripture
    public function edit($id)
    {
        $setting = HomeSetting::findOrFail($id);
        return view('admin.hero.edit', compact('setting'));
    }

    // Update theme/scripture
    public function update(Request $request, $id)
    {
        $request->validate([
            'theme' => 'required|string|max:255',
            'scripture' => 'required|string|max:255',
        ]);

        $setting = HomeSetting::findOrFail($id);
        $setting->update($request->all());

        return redirect()->route('admin.hero.index')->with('success', 'Home settings updated.');
    }
}