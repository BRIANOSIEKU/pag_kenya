<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Overseer;

class OverseerController extends Controller
{
    /**
     * Display a listing of the overseers.
     * Optional search by name or district.
     */
    public function index(Request $request)
    {
        $query = Overseer::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('district_name', 'like', "%{$search}%");
        }

        $overseers = $query->orderBy('name')->get();

        return view('admin.overseers.index', compact('overseers'));
    }

    /**
     * Show the form for creating a new overseer.
     */
    public function create()
    {
        return view('admin.overseers.create');
    }

    /**
     * Store a newly created overseer in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'district_name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'gender' => 'required|in:male,female',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->only(['name', 'district_name', 'email', 'phone', 'gender']);

        // Handle photo upload
        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('overseers', 'public');
        }

        Overseer::create($data);

        return redirect()->route('admin.overseers.index')
                         ->with('success', 'Overseer added successfully.');
    }

    /**
     * Show the form for editing the specified overseer.
     */
    public function edit(Overseer $overseer)
    {
        return view('admin.overseers.edit', compact('overseer'));
    }

    /**
     * Update the specified overseer in storage.
     */
    public function update(Request $request, Overseer $overseer)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'district_name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'gender' => 'required|in:Male,Female',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->only(['name', 'district_name', 'email', 'phone', 'gender']);

        // Handle photo upload
        if ($request->hasFile('photo')) {
            // Delete old photo if exists
            if ($overseer->photo && Storage::disk('public')->exists($overseer->photo)) {
                Storage::disk('public')->delete($overseer->photo);
            }

            // Store new photo
            $data['photo'] = $request->file('photo')->store('overseers', 'public');
        }

        $overseer->update($data);

        return redirect()->route('admin.overseers.index')
                         ->with('success', 'Overseer updated successfully.');
    }

    /**
     * Remove the specified overseer from storage.
     */
    public function destroy(Overseer $overseer)
    {
        // Delete photo if exists
        if ($overseer->photo && Storage::disk('public')->exists($overseer->photo)) {
            Storage::disk('public')->delete($overseer->photo);
        }

        $overseer->delete();

        return redirect()->route('admin.overseers.index')
                         ->with('success', 'Overseer deleted successfully.');
    }
}