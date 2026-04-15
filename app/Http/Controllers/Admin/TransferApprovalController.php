<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PastoralTransfer;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

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
    // ROLE CHECK HELPER
    // =========================
    private function authorizeHQ()
    {
        if (!auth()->user()->hasRole(['super_admin', 'general_superintendent'])) {
            abort(403, 'You are not authorized to perform this action.');
        }
    }

    // =========================
    // LIST (HQ PENDING APPROVALS)
    // =========================
    public function index()
    {
        $this->authorizeHQ();

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
                    ->orderByDesc('tithe_reports.id')
                    ->limit(4)
                    ->get()
                : collect();

            // TARGET PERFORMANCE
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
                    ->orderByDesc('tithe_reports.id')
                    ->limit(4)
                    ->get()
                : collect();
        }

        return view('admin.transfers.index', compact('transfers'));
    }

    // =========================
    // APPROVE (MESSAGE + DOWNLOAD TRIGGER)
    // =========================
    public function approve($id)
    {
        $this->authorizeHQ();

        $transfer = PastoralTransfer::with([
            'pastor',
            'fromDistrict',
            'toDistrict',
            'fromAssembly',
            'toAssembly'
        ])->findOrFail($id);

        $status = strtolower(trim($transfer->status));

        // SAFETY CHECKS
        if ($transfer->main_admin_approved == 1 || $status === 'approved') {
            return back()->with('error', 'This transfer has already been approved.');
        }

        if ($status === 'rejected') {
            return back()->with('error', 'This transfer has already been rejected.');
        }

        // APPROVE
        $transfer->update([
            'main_admin_approved' => 1,
            'status' => 'approved',
        ]);

        // UPDATE PASTOR LOCATION
        if ($transfer->pastor) {
            $transfer->pastor->update([
                'district_id' => $transfer->to_district_id,
                'assembly_id' => $transfer->to_assembly_id,
            ]);
        }

        // SUCCESS + TRIGGER DOWNLOAD FLAG
        return redirect()
            ->route('admin.transfers')
            ->with('success', 'Transfer approved successfully.')
            ->with('download_transfer_id', $transfer->id);
    }

    // =========================
    // REJECT
    // =========================
    public function reject(Request $request, $id)
    {
        $this->authorizeHQ();

        $request->validate([
            'rejection_reason' => 'required|string|max:255'
        ]);

        $transfer = PastoralTransfer::findOrFail($id);

        $status = strtolower(trim($transfer->status));

        if ($transfer->main_admin_approved == 1 || $status === 'approved') {
            return back()->with('error', 'This transfer has already been approved.');
        }

        if ($status === 'rejected') {
            return back()->with('error', 'This transfer has already been rejected.');
        }

        $transfer->update([
            'status' => 'rejected',
            'rejection_reason' => $request->rejection_reason,
        ]);

        return back()->with('success', 'Transfer rejected successfully.');
    }

    // =========================
    // SHOW LETTER
    // =========================
    public function showLetter($id)
    {
        $this->authorizeHQ();

        $transfer = PastoralTransfer::with([
            'pastor',
            'fromDistrict',
            'toDistrict',
            'fromAssembly',
            'toAssembly'
        ])->findOrFail($id);

        if ($transfer->status !== 'approved' || $transfer->main_admin_approved != 1) {
            abort(403, 'Transfer letter not available until approval.');
        }

        return view('district_admin.pastoral_transfers.letter', compact('transfer'));
    }

    // =========================
    // DOWNLOAD LETTER (PDF)
    // =========================
    public function downloadLetter($id)
    {
        $this->authorizeHQ();

        $transfer = PastoralTransfer::with([
            'pastor',
            'fromDistrict',
            'toDistrict',
            'fromAssembly',
            'toAssembly'
        ])->findOrFail($id);

        if ($transfer->status !== 'approved' || $transfer->main_admin_approved != 1) {
            abort(403, 'Cannot generate letter until approval.');
        }

        $pdf = Pdf::loadView(
            'district_admin.pastoral_transfers.letter',
            compact('transfer')
        );

        $pastorName = $transfer->pastor->name ?? 'pastor';
$pastorName = str_replace(' ', '_', strtolower($pastorName));

$fileName = 'transfer-letter-' . $pastorName . '-' . $transfer->id . '.pdf';

return $pdf->download($fileName);
    }
}