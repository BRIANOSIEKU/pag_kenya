<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OtherLeader;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class OtherLeaderController extends Controller
{
    // ================= INDEX =================
    public function index($departmentId)
    {
        $department = Department::findOrFail($departmentId);

        $leaders = OtherLeader::with('department')
            ->where('department_id', $departmentId)
            ->latest()
            ->paginate(10);

        return view('admin.departments.other_leaders.index', compact('leaders', 'department'));
    }

    // ================= CREATE =================
    public function create($departmentId)
    {
        $department = Department::findOrFail($departmentId);

        return view('admin.departments.other_leaders.create', compact('department'));
    }

    // ================= STORE =================
    public function store(Request $request, $departmentId)
    {
        $department = Department::findOrFail($departmentId);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $validated['department_id'] = $department->id;

        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('other_leaders', 'public');
        }

        OtherLeader::create($validated);

        return redirect()
            ->route('admin.departments.other-leaders.index', $departmentId)
            ->with('success', 'Leader added successfully');
    }

    // ================= SHOW =================
    public function show($departmentId, $id)
    {
        $department = Department::findOrFail($departmentId);

        $leader = OtherLeader::with('department')->findOrFail($id);

        return view('admin.departments.other_leaders.show', compact('leader', 'department'));
    }

    // ================= EDIT (FIXED IMPORTANT PART) =================
    public function edit($departmentId, $id)
    {
        $department = Department::findOrFail($departmentId);

        $leader = OtherLeader::findOrFail($id);

        // 🔥 FIX: ALWAYS pass departments list to avoid Undefined variable error
        $departments = Department::all();

        return view(
            'admin.departments.other_leaders.edit',
            compact('leader', 'department', 'departments')
        );
    }

    // ================= UPDATE =================
    public function update(Request $request, $departmentId, $id)
    {
        $department = Department::findOrFail($departmentId);

        $leader = OtherLeader::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $validated['department_id'] = $department->id;

        if ($request->hasFile('photo')) {
            if ($leader->photo) {
                Storage::disk('public')->delete($leader->photo);
            }

            $validated['photo'] = $request->file('photo')->store('other_leaders', 'public');
        }

        $leader->update($validated);

        return redirect()
            ->route('admin.departments.other-leaders.index', $departmentId)
            ->with('success', 'Leader updated successfully');
    }

    // ================= DELETE =================
    public function destroy($departmentId, $id)
    {
        $leader = OtherLeader::findOrFail($id);

        if ($leader->photo) {
            Storage::disk('public')->delete($leader->photo);
        }

        $leader->delete();

        return redirect()
            ->route('admin.departments.other-leaders.index', $departmentId)
            ->with('success', 'Leader deleted successfully');
    }
}