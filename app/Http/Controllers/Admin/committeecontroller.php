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

    // ================= STORE LEADER =================

    public function storeLeadership(Request $request, Committee $committee)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'role' => 'nullable|string|max:255',
            'contact' => 'nullable|string|max:50',
            'photo' => 'nullable|image|max:2048',
        ]);

        // Create leader
        $leader = Leader::create([
            'name' => $request->name,
        ]);

        // Upload photo
        $photoName = null;

        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('leaders_photos', 'public');
            $photoName = basename($path);
        }

        // Attach pivot
        $committee->leaders()->attach($leader->id, [
            'role' => $request->role,
            'contact' => $request->contact,
            'photo' => $photoName,
        ]);

        return redirect()->route('admin.committees.leadership', $committee->id)
            ->with('success', 'Leader added successfully');
    }

    // ================= EDIT LEADER =================

    public function editLeadership(Committee $committee, Leader $leader)
    {
        $leader = $committee->leaders()
            ->where('leaders.id', $leader->id)
            ->firstOrFail();

        return view('admin.committees.edit_leadership', compact('committee', 'leader'));
    }

    // ================= UPDATE LEADER =================

    public function updateLeadership(Request $request, Committee $committee, Leader $leader)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'role' => 'nullable|string|max:255',
            'contact' => 'nullable|string|max:50',
        ]);

        // Update leader table
        $leader->update([
            'name' => $request->name,
        ]);

        $pivotData = [
            'role' => $request->role,
            'contact' => $request->contact,
        ];

        // Handle photo update
        if ($request->hasFile('photo')) {

            $currentPivot = DB::table('committee_leader')
                ->where('committee_id', $committee->id)
                ->where('leader_id', $leader->id)
                ->first();

            if ($currentPivot && $currentPivot->photo) {
                Storage::disk('public')->delete('leaders_photos/' . $currentPivot->photo);
            }

            $path = $request->file('photo')->store('leaders_photos', 'public');
            $pivotData['photo'] = basename($path);
        }

        $committee->leaders()->updateExistingPivot($leader->id, $pivotData);

        return redirect()->route('admin.committees.leadership', $committee->id)
            ->with('success', 'Leader updated successfully');
    }

    // ================= DELETE LEADER =================

    public function destroyLeadership(Committee $committee, Leader $leader)
    {
        $currentPivot = DB::table('committee_leader')
            ->where('committee_id', $committee->id)
            ->where('leader_id', $leader->id)
            ->first();

        if ($currentPivot && $currentPivot->photo) {
            Storage::disk('public')->delete('leaders_photos/' . $currentPivot->photo);
        }

        $committee->leaders()->detach($leader->id);

        if ($leader->committees()->count() === 0) {
            $leader->delete();
        }

        return redirect()->route('admin.committees.leadership', $committee->id)
            ->with('success', 'Leader removed successfully');
    }

    // ================= MEMBERS =================

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

        $committee->members()->create($request->only(
            'member_name',
            'member_gender',
            'member_id',
            'phone'
        ));

        return redirect()->route('admin.committees.members', $committee->id)
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

        $member->update($request->only(
            'member_name',
            'member_gender',
            'member_id',
            'phone'
        ));

        return redirect()->route('admin.committees.members', $committee->id)
            ->with('success', 'Member updated successfully');
    }

    public function removeMember(Committee $committee, Member $member)
    {
        $member->delete();

        return redirect()->route('admin.committees.members', $committee->id)
            ->with('success', 'Member removed successfully');
    }

    // ================= REPORTS =================

    public function reports(Committee $committee)
    {
        return view('admin.committees.reports', compact('committee'));
    }

    public function duties(Committee $committee)
    {
        return view('admin.committees.duties', compact('committee'));
    }
}