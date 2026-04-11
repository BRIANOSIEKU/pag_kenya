<?php

namespace App\Http\Controllers\DistrictAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PastoralTeam;
use App\Models\Assembly;
use Illuminate\Support\Facades\Storage;

class PastoralTeamController extends Controller
{
    // =========================
    // LIST ALL RECORDS
    // =========================
    public function index()
    {
        $districtId = session('district_admin_district_id');

        $pastors = PastoralTeam::with('assembly')
            ->where('district_id', $districtId)
            ->latest()
            ->get();

        return view('district_admin.pastoral.index', compact('pastors'));
    }

    // =========================
    // SHOW CREATE FORM
    // =========================
    public function create()
    {
        $districtId = session('district_admin_district_id');

        $assemblies = Assembly::where('district_id', $districtId)
            ->where('status', 'approved')
            ->orderBy('name')
            ->get();

        return view('district_admin.pastoral.create', compact('assemblies'));
    }

    // =========================
    // STORE NEW RECORD
    // =========================
    public function store(Request $request)
    {
        $districtId = session('district_admin_district_id');

        $request->validate([
            'name' => 'required|string|max:255',
            'national_id' => 'required|unique:pastoral_teams,national_id',
            'gender' => 'required|string',
            'contact' => 'required|string',
            'assembly_id' => 'required|exists:assemblies,id',
            'graduation_year' => 'nullable|digits:4',
            'date_of_birth' => 'nullable|date',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'attachments.*' => 'nullable|file|mimes:pdf,doc,docx,jpg,png|max:5120',
        ]);

        // PHOTO
        $photoPath = $request->hasFile('photo')
            ? $request->file('photo')->store('pastors/photos', 'public')
            : null;

        // ATTACHMENTS
        $attachmentPaths = [];

        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $attachmentPaths[] = $file->store('pastors/attachments', 'public');
            }
        }

        // SAVE
        PastoralTeam::create([
            'name' => $request->name,
            'national_id' => $request->national_id,
            'gender' => $request->gender,
            'contact' => $request->contact,
            'assembly_id' => $request->assembly_id,
            'graduation_year' => $request->graduation_year,
            'date_of_birth' => $request->date_of_birth,
            'photo' => $photoPath,
            'attachments' => json_encode($attachmentPaths),
            'district_id' => $districtId,
        ]);

        return redirect()->route('district.admin.pastoral.index')
            ->with('success', 'Pastoral member added successfully!');
    }

    // =========================
    // SHOW SINGLE RECORD
    // =========================
    public function show($id)
    {
        $pastor = PastoralTeam::with('assembly')->findOrFail($id);

        return view('district_admin.pastoral.show', compact('pastor'));
    }

    // =========================
    // SHOW EDIT FORM
    // =========================
    public function edit($id)
    {
        $districtId = session('district_admin_district_id');

        $pastor = PastoralTeam::findOrFail($id);

        $assemblies = Assembly::where('district_id', $districtId)
            ->where('status', 'approved')
            ->orderBy('name')
            ->get();

        return view('district_admin.pastoral.edit', compact('pastor', 'assemblies'));
    }

    // =========================
    // UPDATE RECORD
    // =========================
    public function update(Request $request, $id)
    {
        $pastor = PastoralTeam::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'national_id' => 'required|unique:pastoral_teams,national_id,' . $id,
            'gender' => 'required|string',
            'contact' => 'required|string',
            'assembly_id' => 'required|exists:assemblies,id',
            'graduation_year' => 'nullable|digits:4',
            'date_of_birth' => 'nullable|date',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'attachments.*' => 'nullable|file|mimes:pdf,doc,docx,jpg,png|max:5120',
        ]);

        // PHOTO UPDATE
        if ($request->hasFile('photo')) {
            if ($pastor->photo) {
                Storage::disk('public')->delete($pastor->photo);
            }

            $pastor->photo = $request->file('photo')->store('pastors/photos', 'public');
        }

        // ATTACHMENTS UPDATE
        $existingAttachments = json_decode($pastor->attachments, true) ?? [];

        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $existingAttachments[] = $file->store('pastors/attachments', 'public');
            }
        }

        // UPDATE
        $pastor->update([
            'name' => $request->name,
            'national_id' => $request->national_id,
            'gender' => $request->gender,
            'contact' => $request->contact,
            'assembly_id' => $request->assembly_id,
            'graduation_year' => $request->graduation_year,
            'date_of_birth' => $request->date_of_birth,
            'photo' => $pastor->photo,
            'attachments' => json_encode($existingAttachments),
        ]);

        return redirect()->route('district.admin.pastoral.index')
            ->with('success', 'Pastoral record updated successfully!');
    }

    // =========================
    // DELETE RECORD
    // =========================
    public function destroy($id)
    {
        $pastor = PastoralTeam::findOrFail($id);

        if ($pastor->photo) {
            Storage::disk('public')->delete($pastor->photo);
        }

        if ($pastor->attachments) {
            $files = json_decode($pastor->attachments, true);

            if (is_array($files)) {
                foreach ($files as $file) {
                    Storage::disk('public')->delete($file);
                }
            }
        }

        $pastor->delete();

        return redirect()->route('district.admin.pastoral.index')
            ->with('success', 'Pastoral record deleted successfully!');
    }
}