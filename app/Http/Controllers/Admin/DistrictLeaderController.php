<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\District;
use App\Models\DistrictLeader;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class DistrictLeaderController extends Controller
{
    // ================= LIST LEADERS =================
    public function index(District $district)
    {
        $leaders = DistrictLeader::where('district_id', $district->id)
            ->latest()
            ->get();

        return view('admin.districts.leadership.index', compact('district', 'leaders'));
    }

    // ================= CREATE =================
    public function create(District $district)
    {
        return view('admin.districts.leadership.create', compact('district'));
    }

    // ================= STORE =================
    public function store(Request $request, District $district)
    {
        $request->validate([
            'name' => 'required',
            'position' => 'required|string|max:255',
            'gender' => 'required',
            'contact' => 'required',
            'national_id' => 'required',
            'dob' => 'required|date',

            // BANK FIELDS
            'bank_name' => 'required|string|max:255',
            'bank_branch' => 'required|string|max:255',
            'account_number' => 'required|string|max:255',

            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'attachments.*' => 'nullable|file|max:5120',
        ]);

        $photoPath = null;

        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')
                ->store('leaders/photos', 'public');
        }

        $attachments = [];

        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $attachments[] = $file->store('leaders/attachments', 'public');
            }
        }

        DistrictLeader::create([
            'district_id' => $district->id,
            'name' => $request->name,
            'position' => $request->position,
            'gender' => $request->gender,
            'contact' => $request->contact,
            'national_id' => $request->national_id,
            'dob' => $request->dob,

            // BANK FIELDS
            'bank_name' => $request->bank_name,
            'bank_branch' => $request->bank_branch,
            'account_number' => $request->account_number,

            'photo' => $photoPath,
            'attachments' => $attachments, // FIXED (no json_encode)
        ]);

        return redirect()
            ->route('admin.districts.leadership.index', $district->id)
            ->with('success', 'Leader added successfully.');
    }

    // ================= SHOW =================
    public function show(District $district, DistrictLeader $leader)
    {
        return view('admin.districts.leadership.show', compact('district', 'leader'));
    }

    // ================= EDIT =================
    public function edit(District $district, DistrictLeader $leader)
    {
        return view('admin.districts.leadership.edit', compact('district', 'leader'));
    }

    // ================= UPDATE =================
    public function update(Request $request, District $district, DistrictLeader $leader)
    {
        $request->validate([
            'name' => 'required',
            'position' => 'required|string|max:255',
            'gender' => 'required',
            'contact' => 'required',
            'national_id' => 'required',
            'dob' => 'required|date',

            // BANK FIELDS
            'bank_name' => 'required|string|max:255',
            'bank_branch' => 'required|string|max:255',
            'account_number' => 'required|string|max:255',

            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'attachments.*' => 'nullable|file|max:5120',
        ]);

        $data = [
            'name' => $request->name,
            'position' => $request->position,
            'gender' => $request->gender,
            'contact' => $request->contact,
            'national_id' => $request->national_id,
            'dob' => $request->dob,

            // BANK FIELDS
            'bank_name' => $request->bank_name,
            'bank_branch' => $request->bank_branch,
            'account_number' => $request->account_number,
        ];

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')
                ->store('leaders/photos', 'public');
        }

        if ($request->hasFile('attachments')) {
            $attachments = [];

            foreach ($request->file('attachments') as $file) {
                $attachments[] = $file->store('leaders/attachments', 'public');
            }

            $data['attachments'] = $attachments; // FIXED
        }

        $leader->update($data);

        return redirect()
            ->route('admin.districts.leadership.index', $district->id)
            ->with('success', 'Leader updated successfully.');
    }

    // ================= DELETE =================
    public function destroy(District $district, DistrictLeader $leader)
    {
        $leader->delete();

        return redirect()
            ->route('admin.districts.leadership.index', $district->id)
            ->with('success', 'Leader deleted successfully.');
    }

    // ================= EXPORT FORM =================
    public function exportForm()
    {
        return view('admin.districts.export-form');
    }

    // ================= PDF EXPORT =================
    public function exportPdf(Request $request)
    {
        $request->validate([
            'category' => 'required|string'
        ]);

        $position = $request->category;

        $leaders = DistrictLeader::with('district')
            ->where('position', $position)
            ->get();

        $pdf = Pdf::loadView('admin.reports.district_leaders_pdf', [
            'leaders' => $leaders,
            'category' => $position,
            'date' => Carbon::now()
        ]);

        return $pdf->download("{$position}_report.pdf");
    }
}