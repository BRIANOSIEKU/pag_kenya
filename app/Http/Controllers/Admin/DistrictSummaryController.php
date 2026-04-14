<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class DistrictSummaryController extends Controller
{
    // =========================
    // FORM
    // =========================
    public function form()
    {
        $districts = DB::table('districts')
            ->orderBy('name')
            ->get();

        return view('admin.exports.district_summary_form', compact('districts'));
    }

    // =========================
    // EXPORT PDF
    // =========================
    public function export(Request $request)
    {
        $request->validate([
            'district_id' => 'required|integer',
            'year' => 'required|integer',
            'month' => 'required|string',
            'status' => 'required|string',
        ]);

        // =========================
        // 1. DISTRICT
        // =========================
        $district = DB::table('districts')
            ->where('id', $request->district_id)
            ->first();

        // =========================
        // 2. OVERSEER
        // =========================
        $overseer = DB::table('district_leaders')
            ->where('district_id', $request->district_id)
            ->where('position', 'Overseer')
            ->first();

        // =========================
        // 3. MAIN QUERY (DISTRICT SUMMARY)
        // =========================
        $data = DB::table('tithe_report_items')
            ->join('tithe_reports', 'tithe_reports.id', '=', 'tithe_report_items.tithe_report_id')
            ->join('assemblies', 'assemblies.id', '=', 'tithe_report_items.assembly_id')
            ->leftJoin('pastoral_teams', 'pastoral_teams.assembly_id', '=', 'assemblies.id')

            ->where('assemblies.district_id', $request->district_id)
            ->where('tithe_reports.year', $request->year)
            ->whereRaw('LOWER(tithe_reports.month) = ?', [strtolower($request->month)])
            ->whereRaw('LOWER(tithe_reports.status) = ?', [strtolower($request->status)])

            ->select(
                'assemblies.id as assembly_id',
                'assemblies.name as assembly_name',
                'pastoral_teams.name as pastor_name',
                'pastoral_teams.contact',
                DB::raw('SUM(tithe_report_items.amount) as total_tithe')
            )

            ->groupBy(
                'assemblies.id',
                'assemblies.name',
                'pastoral_teams.name',
                'pastoral_teams.contact'
            )
            ->orderByDesc(DB::raw('SUM(tithe_report_items.amount)'))
            ->get();

        // =========================
        // 4. SORTING (FINAL SAFETY SORT)
        // =========================
        $sorted = $data->sortByDesc('total_tithe')->values();

        // =========================
        // 5. TOTAL CALCULATION
        // =========================
        $total = $sorted->sum('total_tithe');

        // =========================
        // 6. PDF EXPORT
        // =========================
        $pdf = Pdf::loadView('admin.exports.district_summary_pdf', [
            'district' => $district,
            'overseer' => $overseer,
            'data' => $sorted,
            'year' => $request->year,
            'month' => $request->month,
            'total' => $total,
        ])->setPaper('A4', 'portrait');

        return $pdf->download('district_summary.pdf');
    }
}