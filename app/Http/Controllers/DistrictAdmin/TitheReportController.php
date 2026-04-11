<?php

namespace App\Http\Controllers\DistrictAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Assembly;
use App\Models\TitheReport;
use App\Models\TitheReportItem;
use Barryvdh\DomPDF\Facade\Pdf;

class TitheReportController extends Controller
{
    // =========================
    // LIST REPORTS
    // =========================
    public function index()
    {
        $districtId = session('district_admin_district_id');

        $reports = TitheReport::where('district_id', $districtId)
            ->latest()
            ->get();

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

        try {

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

        } catch (\Exception $e) {

            return back()
                ->withInput()
                ->with('error', 'Submission failed: ' . $e->getMessage());
        }
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

        if ($report->status !== 'pending') {
            return redirect()
                ->route('district.admin.tithes.index')
                ->with('error', 'Only pending reports can be edited.');
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
    // UPDATE REPORT
    // =========================
    public function update(Request $request, $id)
    {
        $districtId = session('district_admin_district_id');

        $report = TitheReport::where('district_id', $districtId)
            ->where('id', $id)
            ->firstOrFail();

        if ($report->status !== 'pending') {
            return redirect()
                ->route('district.admin.tithes.index')
                ->with('error', 'Only pending reports can be updated.');
        }

        $request->validate([
            'year' => 'required|integer',
            'month' => 'required|string',
            'payment_code' => 'required|unique:tithe_reports,payment_code,' . $id,
            'amounts' => 'required|array',
        ]);

        try {

            if ($request->hasFile('receipt')) {
                $report->receipt = $request->file('receipt')
                    ->store('tithes/receipts', 'public');
            }

            $total = collect($request->amounts)
                ->sum(fn ($a) => (float) $a);

            $report->update([
                'year'         => $request->year,
                'month'        => $request->month,
                'payment_code' => $request->payment_code,
                'total_amount' => $total,
            ]);

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
                ->with('success', 'Tithe report updated successfully!');

        } catch (\Exception $e) {

            return back()
                ->withInput()
                ->with('error', 'Update failed: ' . $e->getMessage());
        }
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