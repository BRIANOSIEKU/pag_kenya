<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Assembly;
use App\Models\AssemblyMember;

class AssemblyMemberController extends Controller
{
    public function index(Assembly $assembly)
    {
        $members = AssemblyMember::where('assembly_id', $assembly->id)->get();

        return view('district_admin.assembly_members.index', compact('assembly', 'members'));
    }

    public function create(Assembly $assembly)
    {
        return view('district_admin.assembly_members.create', compact('assembly'));
    }

    public function store(Request $request, Assembly $assembly)
    {
        $request->validate([
            'name' => 'required',
            'gender' => 'required',
            'contact' => 'required',
        ]);

        AssemblyMember::create([
            'assembly_id' => $assembly->id,
            'name' => $request->name,
            'gender' => $request->gender,
            'contact' => $request->contact,
        ]);

        return redirect()
            ->route('district.assemblies.members.index', $assembly->id)
            ->with('success', 'Member added successfully');
    }

    public function show(Assembly $assembly, AssemblyMember $member)
    {
        return view('district_admin.assembly_members.show', compact('assembly', 'member'));
    }

    public function edit(Assembly $assembly, AssemblyMember $member)
    {
        return view('district_admin.assembly_members.edit', compact('assembly', 'member'));
    }

    public function update(Request $request, Assembly $assembly, AssemblyMember $member)
    {
        $request->validate([
            'name' => 'required',
            'gender' => 'required',
            'contact' => 'required',
        ]);

        $member->update([
            'name' => $request->name,
            'gender' => $request->gender,
            'contact' => $request->contact,
        ]);

        return redirect()
            ->route('district.assemblies.members.index', $assembly->id)
            ->with('success', 'Member updated successfully');
    }

    public function destroy(Assembly $assembly, AssemblyMember $member)
    {
        $member->delete();

        return back()->with('success', 'Member deleted successfully');
    }
}