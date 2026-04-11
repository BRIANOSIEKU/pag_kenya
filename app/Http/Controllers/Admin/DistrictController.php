<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\District;
use Illuminate\Http\Request;

class DistrictController extends Controller
{
    /**
     * Display District Dashboard
     */
    public function dashboard()
    {
        return view('admin.districts.dashboard');
    }

    /**
     * Display a listing of districts
     */
    public function index()
    {
        $districts = District::latest()->get();
        return view('admin.districts.index', compact('districts'));
    }

    /**
     * Show form to create a district
     */
    public function create()
    {
        return view('admin.districts.create');
    }

    /**
     * Store a new district
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        District::create([
            'name' => $request->name,
        ]);

        return redirect()->route('admin.districts.index')
            ->with('success', 'District created successfully.');
    }

    /**
     * Show form to edit a district
     */
    public function edit(District $district)
    {
        return view('admin.districts.edit', compact('district'));
    }

    /**
     * Update a district
     */
    public function update(Request $request, District $district)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $district->update([
            'name' => $request->name,
        ]);

        return redirect()->route('admin.districts.index')
            ->with('success', 'District updated successfully.');
    }

    /**
     * Delete a district
     */
    public function destroy(District $district)
    {
        $district->delete();

        return redirect()->route('admin.districts.index')
            ->with('success', 'District deleted successfully.');
    }
}