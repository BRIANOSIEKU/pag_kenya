<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PastoralTeam;
use App\Models\Overseer;
use Illuminate\Http\Request;

class PastoralTeamController extends Controller
{
    /**
     * Display a listing of the pastoral team, with optional district filter.
     */
    public function index(Request $request)
    {
        // Get all distinct districts for the filter dropdown
        $districts = Overseer::select('district_name')
            ->distinct()
            ->orderBy('district_name')
            ->pluck('district_name');

        // Build query
        $query = PastoralTeam::query();

        // Apply district filter if selected
        if ($request->has('district') && $request->district != '') {
            $query->where('district_name', $request->district);
        }

        // Paginate and preserve query string
        $teams = $query->latest()->paginate(10)->withQueryString();

        return view('admin.pastoral_teams.index', compact('teams', 'districts'));
    }

    /**
     * Show the form for creating a new pastoral team member.
     */
    public function create()
    {
        $districts = Overseer::select('district_name')
            ->distinct()
            ->orderBy('district_name')
            ->pluck('district_name');

        return view('admin.pastoral_teams.create', compact('districts'));
    }

    /**
     * Store a newly created pastoral team member in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'district_name' => 'required|string|max:255',
            'assembly_name' => 'required|string|max:255',
            'role' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'photo' => 'nullable|image|max:2048',
        ]);

        $data = $request->only(['name', 'role', 'phone', 'email']);
        $data['district_name'] = $request->input('district_name'); // hard assignment
        $data['assembly_name'] = $request->input('assembly_name'); // hard assignment

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('pastoral_team', 'public');
        }

        PastoralTeam::create($data);

        return redirect()->route('admin.pastoral-teams.index')
                         ->with('success', 'Pastoral team member added successfully.');
    }

    /**
     * Show the form for editing the specified pastoral team member.
     */
    public function edit($id)
    {
        $team = PastoralTeam::findOrFail($id);
        $districts = Overseer::select('district_name')
            ->distinct()
            ->orderBy('district_name')
            ->pluck('district_name');

        return view('admin.pastoral_teams.edit', compact('team', 'districts'));
    }

    /**
     * Update the specified pastoral team member in storage.
     */
    public function update(Request $request, $id)
    {
        $team = PastoralTeam::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'district_name' => 'required|string|max:255',
            'assembly_name' => 'required|string|max:255',
            'role' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'photo' => 'nullable|image|max:2048',
        ]);

        $data = $request->only(['name', 'role', 'phone', 'email']);
        $data['district_name'] = $request->input('district_name'); // hard assignment
        $data['assembly_name'] = $request->input('assembly_name'); // hard assignment

        if ($request->hasFile('photo')) {
            // Delete old photo if exists
            if ($team->photo) {
                \Storage::disk('public')->delete($team->photo);
            }
            $data['photo'] = $request->file('photo')->store('pastoral_team', 'public');
        }

        $team->update($data);

        return redirect()->route('admin.pastoral-teams.index')
                         ->with('success', 'Pastoral team updated successfully.');
    }

    /**
     * Remove the specified pastoral team member from storage.
     */
    public function destroy($id)
    {
        $team = PastoralTeam::findOrFail($id);

        if ($team->photo) {
            \Storage::disk('public')->delete($team->photo);
        }

        $team->delete();

        return redirect()->route('admin.pastoral-teams.index')
                         ->with('success', 'Pastoral team member deleted.');
    }
}