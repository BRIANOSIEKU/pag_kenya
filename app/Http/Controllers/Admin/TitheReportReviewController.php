<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TitheReport;
use Barryvdh\DomPDF\Facade\Pdf;

class TitheReportReviewController extends Controller
{
    // =========================
    // LIST ALL PENDING REPORTS
    // =========================
    public function index()
    {
        $reports = TitheReport::with([
                'district.overseer',
                'items.assembly'
            ])
            ->where('status', 'pending')
            ->latest()
            ->get();

        return view('admin.tithes.index', compact('reports'));
    }

    // =========================
    // VIEW SINGLE REPORT
    // =========================
    public function show($id)
    {
        $report = TitheReport::with([
                'district.overseer',
                'items.assembly'
            ])
            ->findOrFail($id);

        $overseer = optional($report->district)->overseer;

        return view('admin.tithes.show', compact('report', 'overseer'));
    }

    // =========================
    // APPROVE REPORT
    // =========================
    public function approve($id)
    {
        $report = TitheReport::findOrFail($id);

        if ($report->status !== 'pending') {
            return redirect()
                ->route('admin.tithe_review.index')
                ->with('error', 'This report has already been processed.');
        }

        $report->update([
            'status' => 'approved',
            'rejection_reason' => null
        ]);

        return redirect()
            ->route('admin.tithe_review.index')
            ->with('success', 'Tithe report approved successfully.');
    }

    // =========================
    // REJECT REPORT (WITH REASON)
    // =========================
    public function reject(Request $request, $id)
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:1000',
        ]);

        $report = TitheReport::findOrFail($id);

        if ($report->status !== 'pending') {
            return redirect()
                ->route('admin.tithe_review.index')
                ->with('error', 'This report has already been processed.');
        }

        $report->update([
            'status' => 'rejected',
            'rejection_reason' => $request->rejection_reason
        ]);

        return redirect()
            ->route('admin.tithe_review.index')
            ->with('success', 'Tithe report rejected successfully.');
    }

    // =========================
    // EXPORT SINGLE REPORT
    // =========================
    public function exportSingle($id)
    {
        $report = TitheReport::with([
                'district.overseer',
                'items.assembly'
            ])
            ->findOrFail($id);

        $pdf = Pdf::loadView('admin.tithes.export', compact('report'));
        $pdf->setPaper('A4', 'landscape');

        return $pdf->download(
            'tithe_report_' . $report->year . '_' . $report->month . '_' . $report->id . '.pdf'
        );
    }

    // =========================
    // EXPORT FILTERED REPORTS
    // =========================
    public function export(Request $request)
    {
        $request->validate([
            'year' => 'required',
            'month' => 'required',
            'status' => 'required'
        ]);

        $year = $request->year;
        $status = strtolower(trim($request->status));

        $monthInput = $request->month;

        $monthMap = [
            '1' => 'January',
            '2' => 'February',
            '3' => 'March',
            '4' => 'April',
            '5' => 'May',
            '6' => 'June',
            '7' => 'July',
            '8' => 'August',
            '9' => 'September',
            '10' => 'October',
            '11' => 'November',
            '12' => 'December',

            'january' => 'January',
            'february' => 'February',
            'march' => 'March',
            'april' => 'April',
            'may' => 'May',
            'june' => 'June',
            'july' => 'July',
            'august' => 'August',
            'september' => 'September',
            'october' => 'October',
            'november' => 'November',
            'december' => 'December',
        ];

        $monthKey = strtolower(trim($monthInput));
        $month = $monthMap[$monthKey] ?? $monthInput;

        $reports = TitheReport::with([
                'district.overseer',
                'items.assembly'
            ])
            ->where('year', $year)
            ->where('status', $status)
            ->where('month', $month)
            ->get();

        if ($reports->isEmpty()) {
            return redirect()
                ->back()
                ->with('error', "No reports found for {$month} {$year} ({$status})");
        }

        $pdf = Pdf::loadView('admin.tithes.export_bulk', [
            'reports' => $reports,
            'year' => $year,
            'month' => $month,
            'status' => $status,
        ]);

        $pdf->setPaper('A4', 'portrait');

        return $pdf->download(
            "tithe_reports_{$year}_{$month}_{$status}.pdf"
        );
    }
}