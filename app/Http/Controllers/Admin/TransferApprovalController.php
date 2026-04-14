<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PastoralTransfer;
use Illuminate\Support\Facades\DB;

class TransferApprovalController extends Controller
{
    /**
     * Only authenticated users
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    // =========================
    // LIST (HQ PENDING APPROVALS)
    // =========================
    public function index()
    {
        $transfers = PastoralTransfer::with([
                'pastor',
                'fromDistrict',
                'toDistrict',
                'fromAssembly',
                'toAssembly'
            ])
            ->where('to_district_approved', 1)
            ->where('main_admin_approved', 0)
            ->whereNull('rejection_reason')
            ->latest()
            ->get();

        foreach ($transfers as $transfer) {

            // CURRENT PERFORMANCE
            if ($transfer->from_assembly_id) {

                $transfer->currentAssemblyPerformance = DB::table('tithe_report_items')
                    ->join('tithe_reports', 'tithe_reports.id', '=', 'tithe_report_items.tithe_report_id')
                    ->where('tithe_report_items.assembly_id', $transfer->from_assembly_id)
                    ->select(
                        'tithe_reports.month',
                        'tithe_reports.year',
                        DB::raw('SUM(tithe_report_items.amount) as total')
                    )
                    ->groupBy('tithe_reports.month', 'tithe_reports.year')
                    ->orderByDesc('tithe_reports.year')
                    ->orderByDesc('tithe_reports.id')
                    ->limit(4)
                    ->get();
            } else {
                $transfer->currentAssemblyPerformance = collect();
            }

            // TARGET PERFORMANCE
            if ($transfer->to_assembly_id) {

                $transfer->targetAssemblyPerformance = DB::table('tithe_report_items')
                    ->join('tithe_reports', 'tithe_reports.id', '=', 'tithe_report_items.tithe_report_id')
                    ->where('tithe_report_items.assembly_id', $transfer->to_assembly_id)
                    ->select(
                        'tithe_reports.month',
                        'tithe_reports.year',
                        DB::raw('SUM(tithe_report_items.amount) as total')
                    )
                    ->groupBy('tithe_reports.month', 'tithe_reports.year')
                    ->orderByDesc('tithe_reports.year')
                    ->orderByDesc('tithe_reports.id')
                    ->limit(4)
                    ->get();
            } else {
                $transfer->targetAssemblyPerformance = collect();
            }
        }

        return view('admin.transfers.index', compact('transfers'));
    }

    // =========================
    // APPROVE (SECURED)
    // =========================
    public function approve($id)
    {
        // 🔐 ROLE CHECK (FIXED)
        if (!auth()->user()->hasRole(['super-admin', 'general-superintendent'])) {
            abort(403, 'You are not authorized to approve transfers.');
        }

        $transfer = PastoralTransfer::findOrFail($id);

        if ($transfer->main_admin_approved == 1 || $transfer->status == 'approved') {
            return back()->with('error', 'This transfer has already been approved.');
        }

        if ($transfer->status == 'rejected') {
            return back()->with('error', 'This transfer has already been rejected.');
        }

        $transfer->update([
            'main_admin_approved' => 1,
            'status' => 'approved',
        ]);

        if ($transfer->pastor) {
            $transfer->pastor->update([
                'district_id' => $transfer->to_district_id,
                'assembly_id' => $transfer->to_assembly_id,
            ]);
        }

        return back()->with('success', 'Transfer approved successfully.');
    }

    // =========================
    // REJECT (SECURED)
    // =========================
    public function reject(Request $request, $id)
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:255'
        ]);

        // 🔐 ROLE CHECK (FIXED)
        if (!auth()->user()->hasRole(['super-admin', 'general-superintendent'])) {
            abort(403, 'You are not authorized to reject transfers.');
        }

        $transfer = PastoralTransfer::findOrFail($id);

        if ($transfer->main_admin_approved == 1 || $transfer->status == 'approved') {
            return back()->with('error', 'This transfer has already been approved.');
        }

        if ($transfer->status == 'rejected') {
            return back()->with('error', 'This transfer has already been rejected.');
        }

        $transfer->update([
            'status' => 'rejected',
            'rejection_reason' => $request->rejection_reason,
        ]);

        return back()->with('success', 'Transfer rejected successfully.');
    }
}