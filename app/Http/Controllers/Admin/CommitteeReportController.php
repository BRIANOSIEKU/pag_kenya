<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Committee;
use App\Models\CommitteeReport;
use Illuminate\Support\Facades\Storage;

class CommitteeReportController extends Controller
{
    // List all reports for a committee
    public function index($committeeId)
    {
        $committee = Committee::findOrFail($committeeId);
        $reports = $committee->reports()->orderBy('report_date', 'desc')->get();

        return view('admin.committees.reports', compact('committee', 'reports'));
    }

    // Show create report form
    public function create($committeeId)
    {
        $committee = Committee::findOrFail($committeeId);
        return view('admin.committees.create_report', compact('committee'));
    }

    // Store new report
    public function store(Request $request, $committeeId)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'report_date' => 'required|date',
            'attachment' => 'required|file|mimes:pdf,doc,docx|max:10240', // max 10MB
        ]);

        $committee = Committee::findOrFail($committeeId);

        $path = $request->file('attachment')->store('committee_reports', 'public');

        CommitteeReport::create([
            'committee_id' => $committee->id,
            'title' => $request->title,
            'description' => $request->description,
            'report_date' => $request->report_date,
            'attachment' => $path,
        ]);

        return redirect()->route('admin.committees.reports.list', $committee->id)
                         ->with('success', 'Report uploaded successfully.');
    }

    // Show edit form
    public function edit($committeeId, $reportId)
    {
        $committee = Committee::findOrFail($committeeId);
        $report = CommitteeReport::findOrFail($reportId);

        return view('admin.committees.edit_report', compact('committee', 'report'));
    }

    // Update report
    public function update(Request $request, $committeeId, $reportId)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'report_date' => 'required|date',
            'attachment' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
        ]);

        $report = CommitteeReport::findOrFail($reportId);

        if ($request->hasFile('attachment')) {
            // Delete old file if exists
            if ($report->attachment && Storage::disk('public')->exists($report->attachment)) {
                Storage::disk('public')->delete($report->attachment);
            }
            $report->attachment = $request->file('attachment')->store('committee_reports', 'public');
        }

        $report->update([
            'title' => $request->title,
            'description' => $request->description,
            'report_date' => $request->report_date,
        ]);

        return redirect()->route('admin.committees.reports.list', $committeeId)
                         ->with('success', 'Report updated successfully.');
    }

    // Delete report
    public function destroy($committeeId, $reportId)
    {
        $report = CommitteeReport::findOrFail($reportId);

        if ($report->attachment && Storage::disk('public')->exists($report->attachment)) {
            Storage::disk('public')->delete($report->attachment);
        }

        $report->delete();

        return redirect()->route('admin.committees.reports.list', $committeeId)
                         ->with('success', 'Report deleted successfully.');
    }
}