<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PastoralTransfer;

class TransferApprovalController extends Controller
{
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

        return view('admin.transfers.index', compact('transfers'));
    }

    // =========================
    // APPROVE (HQ FINAL STEP)
    // =========================
    public function approve($id)
    {
        $transfer = PastoralTransfer::findOrFail($id);

        // prevent double processing
        if ($transfer->main_admin_approved == 1 || $transfer->status == 'approved') {
            return back()->with('error', 'This transfer has already been approved.');
        }

        if ($transfer->status == 'rejected') {
            return back()->with('error', 'This transfer has already been rejected.');
        }

        // HQ approval
        $transfer->update([
            'main_admin_approved' => 1,
            'status' => 'approved',
        ]);

        // Move pastor to new district & assembly (FINAL STEP)
        if ($transfer->pastor) {
            $transfer->pastor->update([
                'district_id' => $transfer->to_district_id,
                'assembly_id' => $transfer->to_assembly_id,
            ]);
        }

        return back()->with('success', 'Transfer approved successfully.');
    }

    // =========================
    // REJECT (HQ FINAL STEP)
    // =========================
    public function reject(Request $request, $id)
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:255'
        ]);

        $transfer = PastoralTransfer::findOrFail($id);

        // prevent double processing
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