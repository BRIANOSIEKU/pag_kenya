<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Assembly;
use App\Models\District;

class AssemblyApprovalController extends Controller
{
    /**
     * Only authenticated users can access
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    // =========================
    // LIST ALL REQUESTS
    // =========================
    public function index(Request $request)
    {
        $query = Assembly::with('district')
            ->where('status', 'pending');

        if ($request->filled('district_id')) {
            $query->where('district_id', $request->district_id);
        }

        $requests = $query->latest()->get();
        $districts = District::orderBy('name')->get();

        return view('admin.assemblies.requests', compact('requests', 'districts'));
    }

    // =========================
    // APPROVE REQUEST (SECURED)
    // =========================
    public function approve($id)
    {
        // 🔐 ROLE CHECK (GENERAL SECRETARY + SUPER ADMIN ONLY)
        if (!auth()->user()->hasRole(['super_admin', 'general_secretary', 'general_superintendent'])) {
            abort(403, 'You are not authorized to approve assemblies.');
        }

        $assembly = Assembly::findOrFail($id);

        if ($assembly->status !== 'pending') {
            return redirect()->back()->with('error', 'Already processed.');
        }

        $assembly->status = 'approved';
        $assembly->save();

        return redirect()->back()->with('success', 'Assembly approved successfully!');
    }

    // =========================
    // REJECT REQUEST (SECURED)
    // =========================
    public function reject(Request $request, $id)
    {
        // optional but recommended
        $request->validate([
            'rejection_reason' => 'nullable|string|max:1000',
        ]);

        // 🔐 ROLE CHECK
        if (!auth()->user()->hasRole(['super_admin', 'general_secretary'])) {
            abort(403, 'You are not authorized to reject assemblies.');
        }

        $assembly = Assembly::findOrFail($id);

        if ($assembly->status !== 'pending') {
            return redirect()->back()->with('error', 'Already processed.');
        }

        $assembly->status = 'rejected';
        $assembly->rejection_reason = $request->rejection_reason;
        $assembly->save();

        return redirect()->back()->with('success', 'Assembly rejected successfully!');
    }
}