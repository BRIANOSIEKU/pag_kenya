<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Assembly;
use App\Models\District;

class AssemblyApprovalController extends Controller
{
    // =========================
    // LIST ALL REQUESTS (WITH SEARCH)
    // =========================
    public function index(Request $request)
    {
        $query = Assembly::with('district')
            ->where('status', 'pending');

        // =========================
        // FILTER BY DISTRICT
        // =========================
        if ($request->filled('district_id')) {
            $query->where('district_id', $request->district_id);
        }

        $requests = $query->latest()->get();

        // District dropdown
        $districts = District::orderBy('name')->get();

        return view('admin.assemblies.requests', compact('requests', 'districts'));
    }

    // =========================
    // APPROVE REQUEST
    // =========================
    public function approve($id)
    {
        $assembly = Assembly::findOrFail($id);
        $assembly->status = 'approved';
        $assembly->save();

        return redirect()->back()->with('success', 'Assembly approved successfully!');
    }

    // =========================
    // REJECT REQUEST
    // =========================
    public function reject($id)
    {
        $assembly = Assembly::findOrFail($id);
        $assembly->status = 'rejected';
        $assembly->save();

        return redirect()->back()->with('success', 'Assembly rejected successfully!');
    }
}