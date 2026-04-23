<?php

namespace App\Http\Controllers\DistrictAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\PastoralTransfer;
use App\Models\PastoralTeam;
use App\Models\District;
use App\Models\Assembly;
use App\Models\DistrictAdmin;

// NOTIFICATIONS
use App\Notifications\PastoralTransferCreated;
use App\Notifications\PastoralTransferCompleted;

class PastoralTransferController extends Controller
{
    // =========================
    // LIST
    // =========================
    public function index()
    {
        $districtId = session('district_admin_district_id');

        $transfers = PastoralTransfer::with([
            'pastor',
            'fromDistrict',
            'toDistrict',
            'fromAssembly',
            'toAssembly'
        ])
        ->where(function ($q) use ($districtId) {
            $q->where('from_district_id', $districtId)
              ->orWhere('to_district_id', $districtId);
        })
        ->latest()
        ->get();

        return view('district_admin.pastoral_transfers.index', compact('transfers'));
    }

    // =========================
    // INCOMING
    // =========================
    public function incoming()
    {
        $districtId = session('district_admin_district_id');

        $transfers = PastoralTransfer::with([
            'pastor',
            'fromDistrict',
            'toDistrict',
            'fromAssembly',
            'toAssembly'
        ])
        ->where(function ($q) use ($districtId) {
            $q->where('from_district_id', $districtId)
              ->orWhere('to_district_id', $districtId);
        })
        ->where('status', 'pending')
        ->where(function ($q) use ($districtId) {

            $q->where(function ($sub) use ($districtId) {
                $sub->where('from_district_id', $districtId)
                    ->where('from_district_approved', 0);
            })
            ->orWhere(function ($sub) use ($districtId) {
                $sub->where('to_district_id', $districtId)
                    ->where('to_district_approved', 0);
            });

        })
        ->whereNull('rejection_reason')
        ->latest()
        ->get();

        return view('district_admin.pastoral_transfers.incoming', compact('transfers'));
    }

    // =========================
    // CREATE
    // =========================
    public function create()
    {
        $districtId = session('district_admin_district_id');

        return view('district_admin.pastoral_transfers.create', [
            'pastors' => PastoralTeam::where('district_id', $districtId)->get(),
            'districts' => District::all(),
        ]);
    }

    // =========================
    // STORE
    // =========================
    public function store(Request $request)
    {
        $request->validate([
            'pastoral_team_id' => 'required|exists:pastoral_teams,id',
            'from_district_id' => 'required|exists:districts,id',
            'from_assembly_id' => 'required|exists:assemblies,id',
            'to_assembly_id' => 'required|exists:assemblies,id',
            'to_district_id' => 'nullable|exists:districts,id',
            'reason' => 'nullable|string',
            'transfer_type' => 'required|in:within,outside'
        ]);

        $fromDistrict = $request->from_district_id;

        $toDistrict = $request->transfer_type === 'within'
            ? $fromDistrict
            : $request->to_district_id;

        $transfer = PastoralTransfer::create([
            'pastoral_team_id' => $request->pastoral_team_id,
            'from_district_id' => $fromDistrict,
            'from_assembly_id' => $request->from_assembly_id,
            'to_district_id' => $toDistrict,
            'to_assembly_id' => $request->to_assembly_id,
            'transfer_date' => now(),
            'reason' => $request->reason,
            'status' => 'pending',

            'from_district_approved' => 0,
            'to_district_approved' => ($fromDistrict == $toDistrict ? 1 : 0),
            'general_secretary_approved' => 0,
        ]);

        $admins = DistrictAdmin::where('district_id', $toDistrict)->get();

        foreach ($admins as $admin) {
            $admin->notify(new PastoralTransferCreated($transfer));
        }

        return redirect()->route('district.admin.pastoral.transfers.index')
            ->with('success', 'Transfer submitted successfully.');
    }

    // =========================
    // DISTRICT APPROVAL
    // =========================
    public function approve($id)
    {
        $transfer = PastoralTransfer::findOrFail($id);

        if ($transfer->status !== 'pending') {
            return back()->with('error', 'Already processed.');
        }

        $districtId = session('district_admin_district_id');

        // SAME DISTRICT
        if ($transfer->from_district_id == $transfer->to_district_id) {

            $transfer->update([
                'from_district_approved' => 1,
                'to_district_approved' => 1,
            ]);

            $this->checkFinalApproval($transfer);

            return back()->with('success', 'District approved.');
        }

        // FROM DISTRICT
        if ($districtId == $transfer->from_district_id) {

            $transfer->update([
                'from_district_approved' => 1
            ]);

            $this->checkFinalApproval($transfer);

            return back()->with('success', 'Source district approved.');
        }

        // TO DISTRICT
        if ($districtId == $transfer->to_district_id) {

            $transfer->update([
                'to_district_approved' => 1
            ]);

            $this->checkFinalApproval($transfer);

            return back()->with('success', 'Target district approved.');
        }

        return back()->with('error', 'Unauthorized action.');
    }

    // =========================
    // GENERAL SECRETARY APPROVAL
    // =========================
    public function generalSecretaryApprove($id)
    {
        $transfer = PastoralTransfer::findOrFail($id);

        if ($transfer->status !== 'pending') {
            return back()->with('error', 'Already processed.');
        }

        if (!($transfer->from_district_approved && $transfer->to_district_approved)) {
            return back()->with('error', 'District approval required first.');
        }

        $transfer->update([
            'general_secretary_approved' => 1,
            'general_secretary_approved_at' => now(),
        ]);

        $this->checkFinalApproval($transfer);

        return back()->with('success', 'General Secretary approved.');
    }

    // =========================
    // FINAL APPROVAL (GENERAL SUPERINTENDENT)
    // =========================
    private function checkFinalApproval($transfer)
    {
        $transfer->refresh();

        // STEP 1: District approvals
        if (!($transfer->from_district_approved && $transfer->to_district_approved)) {
            return;
        }

        // STEP 2: General Secretary
        if (!$transfer->general_secretary_approved) {
            return;
        }

        // STEP 3: FINAL (GENERAL SUPERINTENDENT)
        $transfer->update([
            'status' => 'approved',
        ]);

        $this->movePastor($transfer);

        $admins = DistrictAdmin::whereNull('district_id')->get();

        foreach ($admins as $admin) {
            $admin->notify(new PastoralTransferCompleted($transfer));
        }
    }

    public function destroy($id)
{
    $transfer = PastoralTransfer::findOrFail($id);

    // optional safety check
    if ($transfer->status === 'approved') {
        return back()->with('error', 'Cannot delete an approved transfer.');
    }

    $transfer->delete();

    return back()->with('success', 'Transfer deleted successfully.');
}
    // =========================
    // REJECT
    // =========================
    public function reject(Request $request, $id)
    {
        $request->validate([
            'rejection_reason' => 'required|string',
        ]);

        $transfer = PastoralTransfer::findOrFail($id);

        if ($transfer->status !== 'pending') {
            return back()->with('error', 'Already processed.');
        }

        $transfer->update([
            'status' => 'rejected',
            'rejection_reason' => $request->rejection_reason
        ]);

        return back()->with('success', 'Transfer rejected.');
    }

    // =========================
    // MOVE PASTOR
    // =========================
    private function movePastor($transfer)
    {
        $pastor = PastoralTeam::find($transfer->pastoral_team_id);

        if ($pastor) {
            $pastor->update([
                'district_id' => $transfer->to_district_id,
                'assembly_id' => $transfer->to_assembly_id,
            ]);
        }
    }
}