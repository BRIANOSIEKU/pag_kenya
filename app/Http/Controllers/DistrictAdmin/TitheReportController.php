<?php

namespace App\Http\Controllers\DistrictAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Assembly;
use App\Models\TitheReport;
use App\Models\TitheReportItem;
use App\Models\TitheReportHistory;
use App\Models\TitheReportItemHistory;
use Barryvdh\DomPDF\Facade\Pdf;

class TitheReportController extends Controller
{
    // =========================
    // LIST REPORTS
    // =========================
    public function index(Request $request)
    {
        $districtId = session('district_admin_district_id');

        $query = TitheReport::where('district_id', $districtId);

        if ($request->filled('year')) {
            $query->where('year', $request->year);
        }

        if ($request->filled('month')) {
            $query->where('month', 'like', '%' . $request->month . '%');
        }

        $query->orderByDesc('year')
              ->orderByRaw("
                FIELD(month,
                'December','November','October','September','August','July',
                'June','May','April','March','February','January')
              ");

        if (!$request->filled('year') && !$request->filled('month')) {
            $query->limit(12);
        }

        $reports = $query->get();

        return view('district_admin.tithes.index', compact('reports'));
    }

    // =========================
    // CREATE FORM
    // =========================
    public function create()
    {
        $districtId = session('district_admin_district_id');

        $assemblies = Assembly::where('district_id', $districtId)
            ->where('status', 'approved')
            ->orderBy('name')
            ->get();

        return view('district_admin.tithes.create', compact('assemblies'));
    }

    // =========================
    // STORE REPORT
    // =========================
    public function store(Request $request)
    {
        $districtId = session('district_admin_district_id');

        $request->validate([
            'year' => 'required|integer',
            'month' => 'required|string',
            'payment_code' => 'required|unique:tithe_reports,payment_code',
            'receipt' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'amounts' => 'required|array',
        ]);

        $receiptPath = $request->file('receipt')->store('tithes/receipts', 'public');

        $total = collect($request->amounts)->sum(fn ($a) => (float) $a);

        $report = TitheReport::create([
            'district_id'  => $districtId,
            'year'         => $request->year,
            'month'        => $request->month,
            'payment_code' => $request->payment_code,
            'total_amount' => $total,
            'receipt'      => $receiptPath,
            'status'       => 'pending',
            'rejection_reason' => null,
        ]);

        foreach ($request->amounts as $assemblyId => $amount) {
            TitheReportItem::create([
                'tithe_report_id' => $report->id,
                'assembly_id'     => $assemblyId,
                'amount'          => (float) $amount,
            ]);
        }

        return redirect()
            ->route('district.admin.tithes.index')
            ->with('success', 'Tithe report submitted successfully!');
    }

    // =========================
    // EDIT REPORT
    // =========================
    public function edit($id)
    {
        $districtId = session('district_admin_district_id');

        $report = TitheReport::where('district_id', $districtId)
            ->where('id', $id)
            ->firstOrFail();

        if (!in_array($report->status, ['pending', 'rejected'])) {
            return redirect()
                ->route('district.admin.tithes.index')
                ->with('error', 'Only pending or rejected reports can be edited.');
        }

        $assemblies = Assembly::where('district_id', $districtId)
            ->where('status', 'approved')
            ->orderBy('name')
            ->get();

        $items = TitheReportItem::where('tithe_report_id', $id)
            ->get()
            ->keyBy('assembly_id');

        return view('district_admin.tithes.edit', compact('report', 'assemblies', 'items'));
    }

    // =========================
    // UPDATE REPORT (WITH HISTORY)
    // =========================
    public function update(Request $request, $id)
    {
        $districtId = session('district_admin_district_id');

        $report = TitheReport::where('district_id', $districtId)
            ->where('id', $id)
            ->firstOrFail();

        if (!in_array($report->status, ['pending', 'rejected'])) {
            return redirect()
                ->route('district.admin.tithes.index')
                ->with('error', 'Only pending or rejected reports can be updated.');
        }

        $request->validate([
            'year' => 'required|integer',
            'month' => 'required|string',
            'payment_code' => 'required|unique:tithe_reports,payment_code,' . $id,
            'amounts' => 'required|array',
        ]);

        // =========================
        // 🔥 SAVE HISTORY FIRST
        // =========================
        TitheReportHistory::create([
            'tithe_report_id'  => $report->id,
            'year'             => $report->year,
            'month'            => $report->month,
            'payment_code'     => $report->payment_code,
            'total_amount'     => $report->total_amount,
            'status'           => $report->status,
            'rejection_reason' => $report->rejection_reason,
            'archived_at'      => now(),
        ]);

        $oldItems = TitheReportItem::where('tithe_report_id', $report->id)->get();

        foreach ($oldItems as $item) {
            TitheReportItemHistory::create([
                'tithe_report_id' => $item->tithe_report_id,
                'assembly_id'     => $item->assembly_id,
                'amount'          => $item->amount,
            ]);
        }

        // =========================
        // UPDATE REPORT
        // =========================
        $total = collect($request->amounts)
            ->sum(fn ($a) => (float) $a);

        $report->update([
            'year'             => $request->year,
            'month'            => $request->month,
            'payment_code'     => $request->payment_code,
            'total_amount'     => $total,
            'status'           => 'pending',
            'rejection_reason' => null,
        ]);

        // replace items
        TitheReportItem::where('tithe_report_id', $id)->delete();

        foreach ($request->amounts as $assemblyId => $amount) {
            TitheReportItem::create([
                'tithe_report_id' => $report->id,
                'assembly_id'     => $assemblyId,
                'amount'          => (float) $amount,
            ]);
        }

        return redirect()
            ->route('district.admin.tithes.index')
            ->with('success', 'Report updated and resubmitted successfully!');
    }

    // =========================
    // EXPORT PDF
    // =========================
    public function export($id)
    {
        $districtId = session('district_admin_district_id');

        $report = TitheReport::with('items.assembly')
            ->where('district_id', $districtId)
            ->where('id', $id)
            ->firstOrFail();

        $pdf = Pdf::loadView('district_admin.tithes.tithe_report_pdf', compact('report'));

        return $pdf->download(
            'tithe-report-' . $report->year . '-' . $report->month . '.pdf'
        );
    }
}