<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TitheReport;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class OverseerReportController extends Controller
{
    // =========================
    // INDEX (EXPORT DASHBOARD)
    // =========================
    public function index()
    {
        return view('admin.exports.index');
    }

    // =========================
    // FORM
    // =========================
    public function form()
    {
        $banks = DB::table('district_leaders')
            ->where('position', 'Overseer')
            ->whereNotNull('bank_name')
            ->where('bank_name', '!=', '')
            ->distinct()
            ->pluck('bank_name');

        return view('admin.exports.overseer_form', compact('banks'));
    }

    // =========================
    // EXPORT PDF (FIXED ACCURATE CALCULATION)
    // =========================
    public function export(Request $request)
    {
        $request->validate([
            'year' => 'required|integer',
            'month' => 'required|string',
            'status' => 'required|string',
            'bank' => 'nullable|string',
        ]);

        // =========================
        // STEP 1: GET FILTERED REPORTS
        // =========================
        $reports = TitheReport::where('year', $request->year)
            ->whereRaw('LOWER(month) = ?', [strtolower($request->month)])
            ->whereRaw('LOWER(status) = ?', [strtolower($request->status)])
            ->get();

        // =========================
        // STEP 2: GROUP BY DISTRICT (CRITICAL FIX)
        // =========================
        $districtTotals = $reports->groupBy('district_id')
            ->map(function ($group) {
                return (float) $group->sum('total_amount');
            });

        // =========================
        // STEP 3: CALCULATE 15% PER DISTRICT (ACCURATE)
        // =========================
        $districtShares = $districtTotals->map(function ($total) {
            return round($total * 0.15, 2);
        });

        // =========================
        // STEP 4: GET OVERSEERS
        // =========================
        $overseersQuery = DB::table('district_leaders')
            ->where('position', 'Overseer');

        if (!empty($request->bank)) {
            $overseersQuery->where('bank_name', $request->bank);
        }

        $overseers = $overseersQuery->get();

        // =========================
        // STEP 5: BUILD FINAL PAYROLL LIST
        // =========================
        $leaders = [];

        foreach ($overseers as $o) {

            $districtId = $o->district_id;

            $amount = $districtShares[$districtId] ?? 0;

            $leaders[] = [
                'name' => $o->name,
                'district' => DB::table('districts')
                    ->where('id', $districtId)
                    ->value('name') ?? 'N/A',
                'national_id' => $o->national_id,
                'gender' => $o->gender,
                'phone' => $o->contact,
                'bank' => $o->bank_name,
                'branch' => $o->bank_branch,
                'account' => $o->account_number,
                'amount' => $amount,
            ];
        }

        // =========================
        // STEP 6: FINAL TOTAL
        // =========================
        $grandTotal = collect($leaders)->sum('amount');

        return Pdf::loadView('admin.exports.overseer_pdf', [
            'leaders' => $leaders,
            'year' => $request->year,
            'month' => $request->month,
            'total' => $grandTotal
        ])->setPaper('A4', 'portrait')
          ->download('overseer_reimbursement.pdf');
    }
}