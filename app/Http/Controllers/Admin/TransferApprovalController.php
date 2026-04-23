<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PastoralTransfer;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class TransferApprovalController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // =========================
    // ROLE HELPERS
    // =========================
    private function isSecretary()
    {
        return auth()->user()->hasRole('general_secretary');
    }

    private function isSuperintendent()
    {
        return auth()->user()->hasRole('general_superintendent');
    }

    private function isHQ()
    {
        return auth()->user()->hasRole(['super_admin', 'general_secretary', 'general_superintendent']);
    }

    private function authorizeHQ()
    {
        if (!$this->isHQ()) {
            abort(403, 'Unauthorized.');
        }
    }

    private function authorizeSecretary()
    {
        if (!auth()->user()->hasRole(['general_secretary', 'super_admin'])) {
            abort(403, 'Unauthorized.');
        }
    }

    // =========================
    // INDEX (ROLE-BASED VIEW)
    // =========================
    public function index()
    {
        $this->authorizeHQ();

        $query = PastoralTransfer::with([
            'pastor',
            'fromDistrict',
            'toDistrict',
            'fromAssembly',
            'toAssembly'
        ]);

        /*
        ======================================================
        ROLE LOGIC FIX:
        - Secretary sees ALL initiated transfers (pending GS approval OR already approved by GS)
        - Superintendent sees ONLY transfers already approved by Secretary
        - HQ final view sees after GS approval (your previous logic)
        ======================================================
        */

        if ($this->isSecretary()) {

            // Secretary sees EVERYTHING pending initial HQ review
            $query->whereNull('rejection_reason')
                  ->where('status', '!=', 'rejected');

        } elseif ($this->isSuperintendent()) {

            // Superintendent sees only secretary-approved ones
            $query->where('general_secretary_approved', 1)
                  ->where('main_admin_approved', 0)
                  ->whereNull('rejection_reason')
                  ->where('status', '!=', 'rejected');

        } else {

            // Super admin / HQ final view
            $query->where('general_secretary_approved', 1)
                  ->where('main_admin_approved', 0)
                  ->whereNull('rejection_reason')
                  ->where('status', '!=', 'rejected');
        }

        $transfers = $query->latest()->get();

        foreach ($transfers as $transfer) {

            $transfer->currentAssemblyPerformance = $transfer->from_assembly_id
                ? DB::table('tithe_report_items')
                    ->join('tithe_reports', 'tithe_reports.id', '=', 'tithe_report_items.tithe_report_id')
                    ->where('tithe_report_items.assembly_id', $transfer->from_assembly_id)
                    ->select(
                        'tithe_reports.month',
                        'tithe_reports.year',
                        DB::raw('SUM(tithe_report_items.amount) as total')
                    )
                    ->groupBy('tithe_reports.month', 'tithe_reports.year')
                    ->orderByDesc('tithe_reports.year')
                    ->limit(4)
                    ->get()
                : collect();

            $transfer->targetAssemblyPerformance = $transfer->to_assembly_id
                ? DB::table('tithe_report_items')
                    ->join('tithe_reports', 'tithe_reports.id', '=', 'tithe_report_items.tithe_report_id')
                    ->where('tithe_report_items.assembly_id', $transfer->to_assembly_id)
                    ->select(
                        'tithe_reports.month',
                        'tithe_reports.year',
                        DB::raw('SUM(tithe_report_items.amount) as total')
                    )
                    ->groupBy('tithe_reports.month', 'tithe_reports.year')
                    ->orderByDesc('tithe_reports.year')
                    ->limit(4)
                    ->get()
                : collect();
        }

        return view('admin.transfers.index', compact('transfers'));
    }

    // =========================
    // GENERAL SECRETARY APPROVAL
    // =========================
    public function secretaryApprove($id)
    {
        $this->authorizeSecretary();

        $transfer = PastoralTransfer::findOrFail($id);

        if ($transfer->general_secretary_approved) {
            return back()->with('error', 'Already approved by General Secretary.');
        }

        if ($transfer->status === 'rejected') {
            return back()->with('error', 'Cannot approve rejected transfer.');
        }

        $transfer->update([
            'general_secretary_approved' => 1,
            'general_secretary_approved_at' => now(),
        ]);

        return back()->with('success', 'Approved by General Secretary.');
    }

    // =========================
    // FINAL HQ APPROVAL
    // =========================
    public function approve($id)
    {
        $this->authorizeHQ();

        $transfer = PastoralTransfer::with([
            'pastor','fromDistrict','toDistrict','fromAssembly','toAssembly'
        ])->findOrFail($id);

        if ($transfer->general_secretary_approved != 1) {
            return back()->with('error', 'Secretary approval required first.');
        }

        if ($transfer->main_admin_approved || $transfer->status === 'approved') {
            return back()->with('error', 'Already approved.');
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

        return redirect()
            ->route('admin.transfers.index')
            ->with('success', 'Transfer fully approved.')
            ->with('download_transfer_id', $transfer->id);
    }

    // =========================
    // REJECT
    // =========================
    public function reject(Request $request, $id)
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:255'
        ]);

        $transfer = PastoralTransfer::findOrFail($id);

        if ($transfer->status === 'approved') {
            return back()->with('error', 'Already approved.');
        }

        $transfer->update([
            'status' => 'rejected',
            'rejection_reason' => $request->rejection_reason,
        ]);

        return back()->with('success', 'Transfer rejected.');
    }

    // =========================
    // LETTER
    // =========================
    public function showLetter($id)
    {
        $this->authorizeHQ();

        $transfer = PastoralTransfer::with([
            'pastor','fromDistrict','toDistrict','fromAssembly','toAssembly'
        ])->findOrFail($id);

        if ($transfer->status !== 'approved') {
            abort(403);
        }

        return view('district_admin.pastoral_transfers.letter', compact('transfer'));
    }

    // =========================
    // PDF
    // =========================
    public function downloadLetter($id)
    {
        $this->authorizeHQ();

        $transfer = PastoralTransfer::with([
            'pastor','fromDistrict','toDistrict','fromAssembly','toAssembly'
        ])->findOrFail($id);

        if ($transfer->status !== 'approved') {
            abort(403);
        }

        $pdf = Pdf::loadView(
            'district_admin.pastoral_transfers.letter',
            compact('transfer')
        );

        $name = strtolower(str_replace(' ', '_', $transfer->pastor->name ?? 'pastor'));

        return $pdf->download("transfer-letter-{$name}-{$transfer->id}.pdf");
    }
}