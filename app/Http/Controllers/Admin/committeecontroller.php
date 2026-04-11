<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Committee;
use App\Models\Leader;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class CommitteeController extends Controller
{
    // ================= Committees =================

    public function index()
    {
        $committees = Committee::with('leaders')->orderBy('id', 'desc')->paginate(10);
        return view('admin.committees.index', compact('committees'));
    }

    public function create()
    {
        return view('admin.committees.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'overview' => 'nullable|string',
        ]);

        Committee::create($request->only('name', 'overview'));

        return redirect()->route('admin.committees.index')
                         ->with('success', 'Committee created successfully');
    }

    public function edit(Committee $committee)
    {
        return view('admin.committees.edit', compact('committee'));
    }

    public function update(Request $request, Committee $committee)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'overview' => 'nullable|string',
        ]);

        $committee->update($request->only('name', 'overview'));

        return redirect()->route('admin.committees.index')
                         ->with('success', 'Committee updated successfully');
    }

    public function destroy(Committee $committee)
    {
        foreach ($committee->leaders as $leader) {
            $pivotPhoto = $leader->pivot->photo ?? null;
            if ($pivotPhoto && Storage::disk('public')->exists('leaders_photos/' . $pivotPhoto)) {
                Storage::disk('public')->delete('leaders_photos/' . $pivotPhoto);
            }
        }

        $committee->leaders()->detach();
        $committee->delete();

        return redirect()->route('admin.committees.index')
                         ->with('success', 'Committee deleted successfully');
    }

    // ================= Leadership =================

    public function leadership(Committee $committee)
    {
        $committee->load('leaders');
        return view('admin.committees.leadership', compact('committee'));
    }

    public function leadershipCreate(Committee $committee)
    {
        return view('admin.committees.leadership_create', compact('committee'));
    }

    public function storeLeadership(Request $request, Committee $committee)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'position' => 'nullable|string|max:255',
            'contact' => 'nullable|string|max:50',
            'photo' => 'nullable|image|max:2048',
            // Note: email, brief_description, and message are validated but not stored 
            // because they don't exist in your current table schema.
        ]);

        // FIX: Only insert columns that exist in the 'leaders' table (name)
        $leader = Leader::create([
            'name' => $request->full_name,
        ]);

        $pivotPhoto = null;
        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('leaders_photos', 'public');
            $pivotPhoto = basename($path);
        }

        // Save everything else to the 'committee_leader' pivot table
        $committee->leaders()->attach($leader->id, [
            'role' => $request->position,
            'contact' => $request->contact,
            'photo' => $pivotPhoto,
        ]);

        return redirect()->route('admin.committees.leadership', $committee->id)
                         ->with('success', 'Leader added successfully');
    }

    public function editLeadership(Committee $committee, Leader $leader)
    {
        $leader = $committee->leaders()->where('leader_id', $leader->id)->firstOrFail();
        return view('admin.committees.edit_leadership', compact('committee', 'leader'));
    }

    public function updateLeadership(Request $request, Committee $committee, Leader $leader)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'position' => 'nullable|string|max:255',
            'contact' => 'nullable|string|max:50',
        ]);

        // Update the core name in leaders table
        $leader->update(['name' => $request->full_name]);

        $pivotData = [
            'role' => $request->position,
            'contact' => $request->contact,
        ];

        if ($request->hasFile('photo')) {
            // Find current pivot photo to delete old one
            $currentPivot = DB::table('committee_leader')
                ->where('committee_id', $committee->id)
                ->where('leader_id', $leader->id)
                ->first();

            if ($currentPivot && $currentPivot->photo && Storage::disk('public')->exists('leaders_photos/' . $currentPivot->photo)) {
                Storage::disk('public')->delete('leaders_photos/' . $currentPivot->photo);
            }

            $path = $request->file('photo')->store('leaders_photos', 'public');
            $pivotData['photo'] = basename($path);
        }

        $committee->leaders()->updateExistingPivot($leader->id, $pivotData);

        return redirect()->route('admin.committees.leadership', $committee->id)
                         ->with('success', 'Leader updated successfully');
    }

    public function destroyLeadership(Committee $committee, Leader $leader)
    {
        $currentPivot = DB::table('committee_leader')
            ->where('committee_id', $committee->id)
            ->where('leader_id', $leader->id)
            ->first();

        if ($currentPivot && $currentPivot->photo && Storage::disk('public')->exists('leaders_photos/' . $currentPivot->photo)) {
            Storage::disk('public')->delete('leaders_photos/' . $currentPivot->photo);
        }

        $committee->leaders()->detach($leader->id);

        if ($leader->committees()->count() === 0) {
            $leader->delete();
        }

        return redirect()->route('admin.committees.leadership', $committee->id)
                         ->with('success', 'Leader removed successfully');
    }

    // ================= Members =================

    public function members(Committee $committee)
    {
        $members = $committee->members()->orderBy('id', 'desc')->paginate(10);
        return view('admin.committees.members', compact('committee', 'members'));
    }

    public function createMember(Committee $committee)
    {
        return view('admin.committees.create_member', compact('committee'));
    }

    public function addMember(Request $request, Committee $committee)
    {
        $request->validate([
            'member_name' => 'required|string|max:255',
            'member_gender' => 'nullable|in:Male,Female,Other',
            'member_id' => 'nullable|integer',
            'phone' => 'nullable|string|max:20',
        ]);

        $committee->members()->create($request->only('member_name', 'member_gender', 'member_id', 'phone'));

        return redirect()->route('admin.committees.members.index', $committee->id)
                         ->with('success', 'Member added successfully');
    }

    public function editMember(Committee $committee, Member $member)
    {
        return view('admin.committees.edit_member', compact('committee', 'member'));
    }

    public function updateMember(Request $request, Committee $committee, Member $member)
    {
        $request->validate([
            'member_name' => 'required|string|max:255',
            'member_gender' => 'nullable|in:Male,Female,Other',
            'member_id' => 'nullable|integer',
            'phone' => 'nullable|string|max:20',
        ]);

        $member->update($request->only('member_name', 'member_gender', 'member_id', 'phone'));

        return redirect()->route('admin.committees.members', $committee->id)
                         ->with('success', 'Member updated successfully');
    }

    public function removeMember(Committee $committee, Member $member)
    {
        $member->delete();

        return redirect()->route('admin.committees.members', $committee->id)
                         ->with('success', 'Member removed successfully');
    }

    // ================= Reports & Duties =================

    public function reports(Committee $committee)
    {
        return view('admin.committees.reports', compact('committee'));
    }

    public function duties(Committee $committee)
    {
        return view('admin.committees.duties', compact('committee'));
    }
}