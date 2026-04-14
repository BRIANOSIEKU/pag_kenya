<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\District;
use Illuminate\Http\Request;
use PDF;

class DistrictController extends Controller
{
    /**
     * Dashboard
     */
    public function dashboard()
    {
        return view('admin.districts.dashboard');
    }

    /**
     * LIST DISTRICTS + LOAD PASTORAL TEAM
     */
    public function index(Request $request)
    {
        $query = District::with('pastoralTeam');

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $districts = $query->latest()->get();

        return view('admin.districts.index', compact('districts'));
    }

    /**
     * SHOW SINGLE DISTRICT (PUBLIC VIEW FIXED)
     */
    public function show($id)
    {
        $district = District::with('pastoralTeam')->findOrFail($id);

        // PUBLIC VIEW (NOT ADMIN)
        return view('pages.districts.show', compact('district'));
    }

    /**
     * CREATE FORM
     */
    public function create()
    {
        return view('admin.districts.create');
    }

    /**
     * STORE DISTRICT
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        District::create([
            'name' => $request->name,
        ]);

        return redirect()
            ->route('admin.districts.index')
            ->with('success', 'District created successfully.');
    }

    /**
     * EDIT FORM
     */
    public function edit(District $district)
    {
        return view('admin.districts.edit', compact('district'));
    }

    /**
     * UPDATE DISTRICT
     */
    public function update(Request $request, District $district)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $district->update([
            'name' => $request->name,
        ]);

        return redirect()
            ->route('admin.districts.index')
            ->with('success', 'District updated successfully.');
    }

    /**
     * DELETE DISTRICT
     */
    public function destroy(District $district)
    {
        $district->delete();

        return redirect()
            ->route('admin.districts.index')
            ->with('success', 'District deleted successfully.');
    }

    /**
     * ============================
     * EXPORT ALL PASTORS
     * ============================
     */
    public function exportPastors()
    {
        $districts = District::with(['pastoralTeam'])->get();

        $pdf = PDF::loadView(
            'admin.districts.exports.all_pastors',
            compact('districts')
        )->setPaper('a4', 'portrait');

        return $pdf->download('all_pastors_by_district.pdf');
    }
}