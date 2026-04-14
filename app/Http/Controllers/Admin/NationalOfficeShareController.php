<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TitheReport;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class NationalOfficeShareController extends Controller
{
    // =========================
    // FORM
    // =========================
    public function form()
    {
        return view('admin.exports.national_form');
    }

    // =========================
    // EXPORT
    // =========================
    public function export(Request $request)
    {
        $request->validate([
            'year' => 'required|integer',
            'month' => 'required|string',
            'status' => 'required|string',
        ]);

        // =========================
        // GET REPORTS
        // =========================
        $reports = TitheReport::where('year', $request->year)
            ->whereRaw('LOWER(month) = ?', [strtolower($request->month)])
            ->whereRaw('LOWER(status) = ?', [strtolower($request->status)])
            ->get();

        $data = [];

        foreach ($reports as $report) {

            $totalTithe = (float) $report->total_amount;

            // 15% overseer share
            $overseerShare = round($totalTithe * 0.15, 2);

            // national office share
            $nationalShare = round($totalTithe - $overseerShare, 2);

            // overseer info (take first overseer in district)
            $overseer = DB::table('district_leaders')
                ->where('district_id', $report->district_id)
                ->where('position', 'Overseer')
                ->first();

            $data[] = [
                'district' => DB::table('districts')
                    ->where('id', $report->district_id)
                    ->value('name') ?? 'N/A',

                'overseer' => $overseer->name ?? 'N/A',
                'contact' => $overseer->contact ?? 'N/A',

                'payment_code' => $report->payment_code,
                'total_tithe' => $totalTithe,
                'overseer_share' => $overseerShare,
                'national_share' => $nationalShare,
            ];
        }

        return Pdf::loadView('admin.exports.national_pdf', [
            'data' => $data,
            'year' => $request->year,
            'month' => $request->month,
        ])->setPaper('A4', 'landscape')
          ->download('national_office_share.pdf');
    }
}