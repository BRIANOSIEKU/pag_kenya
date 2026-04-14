<?php

namespace App\Http\Controllers\DistrictAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Assembly;
use App\Models\TitheReport;
use App\Models\TitheReportItem;
use App\Models\TitheReportHistory;
use App\Models\TitheReportItemHistory;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf; // ✅ ADD THIS

class TitheReportController extends Controller
{
    // =========================
    // LIST
    // =========================
    public function index(Request $request)
    {
        $districtId = session('district_admin_district_id');

        $query = TitheReport::where('district_id', $districtId);

        if ($request->year) {
            $query->where('year', $request->year);
        }

        if ($request->month) {
            $query->whereRaw('LOWER(month) = ?', [strtolower($request->month)]);
        }

        $reports = $query->orderByDesc('year')->get();

        return view('district_admin.tithes.index', compact('reports'));
    }

    // =========================
    // CREATE
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
    // STORE
    // =========================
    public function store(Request $request)
    {
        $districtId = session('district_admin_district_id');

        $request->validate([
            'year' => 'required|integer',
            'month' => 'required|string',
            'payment_code' => 'required|unique:tithe_reports,payment_code',
            'receipt' => 'required|image|max:5120',
            'amounts' => 'required|array',
            'assembly_ids' => 'required|array',
        ]);

        $receiptPath = $request->file('receipt')
            ? $request->file('receipt')->store('tithes/receipts', 'public')
            : null;

        $total = (float) collect($request->amounts)->sum();

        $report = TitheReport::create([
            'district_id' => $districtId,
            'year' => $request->year,
            'month' => $request->month,
            'payment_code' => $request->payment_code,
            'total_amount' => $total,
            'receipt' => $receiptPath,
            'status' => 'pending',
        ]);

        $files = $request->file('assembly_muhtasari', []);

        foreach ($request->assembly_ids as $index => $assemblyId) {

            $file = $files[$index] ?? $files[$assemblyId] ?? null;

            $path = $file
                ? $file->store('tithes/assembly_muhtasari', 'public')
                : null;

            TitheReportItem::create([
                'tithe_report_id' => $report->id,
                'assembly_id' => $assemblyId,
                'amount' => (float) ($request->amounts[$assemblyId] ?? 0),
                'assembly_muhtasari' => $path,
            ]);
        }

        return redirect()->route('district.admin.tithes.index')
            ->with('success', 'Report submitted successfully');
    }

    // =========================
    // EDIT
    // =========================
    public function edit($id)
    {
        $districtId = session('district_admin_district_id');

        $report = TitheReport::where('district_id', $districtId)->findOrFail($id);

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
    // UPDATE
    // =========================
    public function update(Request $request, $id)
    {
        $districtId = session('district_admin_district_id');

        $report = TitheReport::where('district_id', $districtId)->findOrFail($id);

        $request->validate([
            'year' => 'required|integer',
            'month' => 'required|string',
            'payment_code' => 'required|unique:tithe_reports,payment_code,' . $id,
            'receipt' => 'nullable|image|max:5120',
            'amounts' => 'required|array',
            'assembly_ids' => 'required|array',
        ]);

        if ($request->hasFile('receipt')) {
            if ($report->receipt) {
                Storage::disk('public')->delete($report->receipt);
            }

            $report->receipt = $request->file('receipt')
                ->store('tithes/receipts', 'public');
        }

        TitheReportHistory::create([
            'tithe_report_id' => $report->id,
            'year' => $report->year,
            'month' => $report->month,
            'payment_code' => $report->payment_code,
            'total_amount' => $report->total_amount,
            'status' => $report->status,
            'rejection_reason' => $report->rejection_reason,
            'archived_at' => now(),
        ]);

        foreach ($report->items as $item) {
            TitheReportItemHistory::create([
                'tithe_report_id' => $item->tithe_report_id,
                'assembly_id' => $item->assembly_id,
                'amount' => $item->amount,
                'assembly_muhtasari' => $item->assembly_muhtasari,
            ]);
        }

        $newTotal = (float) collect($request->amounts)->sum();

        $report->update([
            'year' => $request->year,
            'month' => $request->month,
            'payment_code' => $request->payment_code,
            'total_amount' => $newTotal,
            'status' => 'pending',
        ]);

        TitheReportItem::where('tithe_report_id', $report->id)->delete();

        $files = $request->file('assembly_muhtasari', []);

        foreach ($request->assembly_ids as $index => $assemblyId) {

            $file = $files[$index] ?? $files[$assemblyId] ?? null;

            $path = $file
                ? $file->store('tithes/assembly_muhtasari', 'public')
                : null;

            TitheReportItem::create([
                'tithe_report_id' => $report->id,
                'assembly_id' => $assemblyId,
                'amount' => (float) ($request->amounts[$assemblyId] ?? 0),
                'assembly_muhtasari' => $path,
            ]);
        }

        return redirect()->route('district.admin.tithes.index')
            ->with('success', 'Report updated successfully');
    }

    // =========================
    // ✅ FINAL PDF EXPORT
    // =========================
    public function export($id)
    {
        $districtId = session('district_admin_district_id');

        $report = TitheReport::with('items.assembly')
            ->where('district_id', $districtId)
            ->findOrFail($id);

        $pdf = Pdf::loadView('district_admin.tithes.export', compact('report'))
            ->setPaper('A4', 'portrait');

        return $pdf->download(
            'tithe-report-' . $report->year . '-' . $report->month . '.pdf'
        );
    }
}