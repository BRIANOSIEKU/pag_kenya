<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ChurchProfile;

class ChurchProfileController extends Controller
{
    // Show current church profile (redirect to show if exists)
    public function index()
    {
        $profile = ChurchProfile::first();

        if ($profile) {
            // Redirect to the show page
            return redirect()->route('admin.church-profile.show', $profile->id);
        }

        // No profile yet, maybe show empty index or create
        return view('admin.church-profile.index', compact('profile'));
    }

    // Show create form
    public function create()
    {
        return view('admin.church-profile.create');
    }

    // Store new profile
    public function store(Request $request)
    {
        $validated = $request->validate([
            'motto' => 'required|string|max:255',
            'vision' => 'required|string',
            'mission' => 'required|string',
            'core_values' => 'required|string',
            'statement_of_faith' => 'required|string',
            'overview' => 'required|string',
            'history' => 'required|string',
        ]);

        $profile = ChurchProfile::create($validated);

        return redirect()->route('admin.church-profile.show', $profile->id)
                         ->with('success', 'Church profile created successfully.');
    }

    // Show a single profile
    public function show($id)
    {
        $profile = ChurchProfile::findOrFail($id);

        return view('admin.church-profile.show', compact('profile'));
    }

    // Show edit form
    public function edit($id)
    {
        $profile = ChurchProfile::findOrFail($id);

        return view('admin.church-profile.edit', compact('profile'));
    }

    // Update existing profile
    public function update(Request $request, $id)
    {
        $profile = ChurchProfile::findOrFail($id);

        $validated = $request->validate([
            'motto' => 'required|string|max:255',
            'vision' => 'required|string',
            'mission' => 'required|string',
            'core_values' => 'required|string',
            'statement_of_faith' => 'required|string',
            'overview' => 'required|string',
            'history' => 'required|string',
        ]);

        $profile->update($validated);

        return redirect()->route('admin.church-profile.show', $profile->id)
                         ->with('success', 'Church profile updated successfully.');
    }
}
