<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Assembly;
use App\Models\AssemblyLeader;

class AssemblyLeaderController extends Controller
{
    public function index(Assembly $assembly)
    {
        $leaders = AssemblyLeader::where('assembly_id', $assembly->id)->get();

        return view('district_admin.assembly_leaders.index', compact('assembly', 'leaders'));
    }

    public function create(Assembly $assembly)
    {
        return view('district_admin.assembly_leaders.create', compact('assembly'));
    }

    public function store(Request $request, Assembly $assembly)
    {
        $request->validate([
            'name' => 'required',
            'position' => 'required',
            'gender' => 'required',
            'contact' => 'required',
            'national_id' => 'required',
            'dob' => 'required',
        ]);

        $data = $request->all();
        $data['assembly_id'] = $assembly->id;

        // PHOTO UPLOAD
        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('assembly_leaders/photos', 'public');
        }

        // ATTACHMENTS UPLOAD
        if ($request->hasFile('attachments')) {
            $files = [];

            foreach ($request->file('attachments') as $file) {
                $files[] = $file->store('assembly_leaders/attachments', 'public');
            }

            $data['attachments'] = json_encode($files);
        }

        AssemblyLeader::create($data);

        return redirect()
            ->route('district.assemblies.leaders.index', $assembly->id)
            ->with('success', 'Assembly leader added successfully');
    }

    public function show(Assembly $assembly, AssemblyLeader $leader)
    {
        return view('district_admin.assembly_leaders.show', compact('assembly', 'leader'));
    }

    public function edit(Assembly $assembly, AssemblyLeader $leader)
    {
        return view('district_admin.assembly_leaders.edit', compact('assembly', 'leader'));
    }

    public function update(Request $request, Assembly $assembly, AssemblyLeader $leader)
    {
        $request->validate([
            'name' => 'required',
            'position' => 'required',
            'gender' => 'required',
            'contact' => 'required',
            'national_id' => 'required',
            'dob' => 'required',
        ]);

        $data = $request->all();

        // UPDATE PHOTO
        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('assembly_leaders/photos', 'public');
        }

        // UPDATE ATTACHMENTS
        if ($request->hasFile('attachments')) {
            $files = [];

            foreach ($request->file('attachments') as $file) {
                $files[] = $file->store('assembly_leaders/attachments', 'public');
            }

            $data['attachments'] = json_encode($files);
        }

        $leader->update($data);

        return redirect()
            ->route('district.assemblies.leaders.index', $assembly->id)
            ->with('success', 'Assembly leader updated successfully');
    }

    public function destroy(Assembly $assembly, AssemblyLeader $leader)
    {
        $leader->delete();

        return back()->with('success', 'Assembly leader deleted successfully');
    }
}