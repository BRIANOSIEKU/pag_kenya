<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PastoralTeam;
use App\Models\District;
use App\Models\Assembly;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class PastoralTeamController extends Controller
{
    // =========================
    // LIST
    // =========================
    public function index(Request $request, $districtId)
    {
        $district = District::findOrFail($districtId);

        $query = PastoralTeam::with(['assembly', 'district'])
            ->where('district_id', $districtId);

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('contact', 'like', "%{$search}%")
                  ->orWhere('gender', 'like', "%{$search}%")
                  ->orWhere('national_id', 'like', "%{$search}%")
                  ->orWhereHas('assembly', function ($q2) use ($search) {
                      $q2->where('name', 'like', "%{$search}%");
                  });
            });
        }

        $pastors = $query->latest()->paginate(10)->withQueryString();

        return view('admin.districts.pastoral_teams.index', compact('district', 'pastors'));
    }

    // =========================
    // SHOW
    // =========================
    public function show($id)
    {
        $pastor = PastoralTeam::with(['district', 'assembly'])->findOrFail($id);

        return view('admin.districts.pastoral_teams.show', compact('pastor'));
    }

    // =========================
    // CREATE
    // =========================
    public function create()
    {
        $districts = District::orderBy('name')->get();
        $assemblies = Assembly::orderBy('name')->get();

        return view('admin.districts.pastoral_teams.create', compact('districts', 'assemblies'));
    }

    // =========================
    // STORE
    // =========================
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'district_id' => 'required|exists:districts,id',
            'assembly_id' => 'required|exists:assemblies,id',
            'gender' => 'required|string|max:20',
            'contact' => 'required|string|max:50',
            'national_id' => 'required|string|max:50',
            'year_of_graduation' => 'nullable|integer',
            'date_of_birth' => 'nullable|date',
            'photo' => 'nullable|image|max:2048',
            'attachments.*' => 'nullable|file|max:4096',
        ]);

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('pastoral_team', 'public');
        }

        if ($request->hasFile('attachments')) {
            $files = [];

            foreach ($request->file('attachments') as $file) {
                $files[] = $file->store('pastoral_team/docs', 'public');
            }

            $data['attachments'] = $files;
        }

        PastoralTeam::create($data);

        return redirect()
            ->route('admin.districts.pastoral-teams.index', $request->district_id)
            ->with('success', 'Pastor added successfully.');
    }

    // =========================
    // EDIT
    // =========================
    public function edit($id)
    {
        $team = PastoralTeam::findOrFail($id);

        $districts = District::orderBy('name')->get();
        $assemblies = Assembly::orderBy('name')->get();

        return view('admin.districts.pastoral_teams.edit', compact('team', 'districts', 'assemblies'));
    }

    // =========================
    // UPDATE
    // =========================
    public function update(Request $request, $id)
    {
        $team = PastoralTeam::findOrFail($id);

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'district_id' => 'required|exists:districts,id',
            'assembly_id' => 'required|exists:assemblies,id',
            'gender' => 'required|string|max:20',
            'contact' => 'required|string|max:50',
            'national_id' => 'required|string|max:50',
            'year_of_graduation' => 'nullable|integer',
            'date_of_birth' => 'nullable|date',
            'photo' => 'nullable|image|max:2048',
            'attachments.*' => 'nullable|file|max:4096',
        ]);

        if ($request->hasFile('photo')) {
            if ($team->photo) {
                Storage::disk('public')->delete($team->photo);
            }

            $data['photo'] = $request->file('photo')->store('pastoral_team', 'public');
        }

        if ($request->hasFile('attachments')) {
            if ($team->attachments && is_array($team->attachments)) {
                foreach ($team->attachments as $file) {
                    Storage::disk('public')->delete($file);
                }
            }

            $files = [];

            foreach ($request->file('attachments') as $file) {
                $files[] = $file->store('pastoral_team/docs', 'public');
            }

            $data['attachments'] = $files;
        }

        $team->update($data);

        return redirect()
            ->route('admin.districts.pastoral-teams.index', $team->district_id)
            ->with('success', 'Pastor updated successfully.');
    }

    // =========================
    // DELETE
    // =========================
    public function destroy($id)
    {
        $team = PastoralTeam::findOrFail($id);

        if ($team->photo) {
            Storage::disk('public')->delete($team->photo);
        }

        if ($team->attachments && is_array($team->attachments)) {
            foreach ($team->attachments as $file) {
                Storage::disk('public')->delete($file);
            }
        }

        $districtId = $team->district_id;

        $team->delete();

        return redirect()
            ->route('admin.districts.pastoral-teams.index', $districtId)
            ->with('success', 'Pastor deleted successfully.');
    }

    // =========================
    // EXPORT DISTRICT PDF
    // =========================
    public function exportPdf($districtId)
    {
        $district = District::findOrFail($districtId);

        $pastors = PastoralTeam::with(['assembly', 'district'])
            ->where('district_id', $districtId)
            ->get();

        $pdf = Pdf::loadView('admin.districts.pastoral_teams.export', [
            'district' => $district,
            'pastors' => $pastors,
            'date' => Carbon::now()
        ]);

        return $pdf->download('Pastoral_Team_' . $district->name . '.pdf');
    }

    // =========================
    // EXPORT ALL PASTORS (FIXED ERROR)
    // =========================
    public function exportAllPastors()
    {
        $pastors = PastoralTeam::with(['district', 'assembly'])->latest()->get();

        $pdf = Pdf::loadView('admin.districts.pastoral_teams.export_all', [
            'pastors' => $pastors,
            'date' => Carbon::now()
        ]);

        return $pdf->download('All_Pastoral_Teams.pdf');
    }
}