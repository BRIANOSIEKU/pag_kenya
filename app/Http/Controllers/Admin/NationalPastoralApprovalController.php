<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class NationalPastoralApprovalController extends Controller
{
    /**
     * Only authenticated users
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    // =========================
    // LIST
    // =========================
    public function index()
    {
        $pastors = DB::table('pastoral_teams')
            ->join('districts', 'districts.id', '=', 'pastoral_teams.district_id')
            ->join('assemblies', 'assemblies.id', '=', 'pastoral_teams.assembly_id')
            ->select(
                'pastoral_teams.*',
                'districts.name as district_name',
                'assemblies.name as assembly_name'
            )
            ->where('pastoral_teams.status', 'pending')
            ->orderBy('districts.name')
            ->get();

        return view('admin.national_pastoral_approvals.index', compact('pastors'));
    }

    // =========================
    // VIEW
    // =========================
    public function view($id)
    {
        $pastor = DB::table('pastoral_teams')
            ->leftJoin('districts', 'districts.id', '=', 'pastoral_teams.district_id')
            ->leftJoin('assemblies', 'assemblies.id', '=', 'pastoral_teams.assembly_id')
            ->select(
                'pastoral_teams.*',
                'districts.name as district_name',
                'assemblies.name as assembly_name'
            )
            ->where('pastoral_teams.id', $id)
            ->first();

        if (!$pastor) {
            return redirect()
                ->route('admin.national_pastoral_approvals.index')
                ->with('error', 'Pastor not found.');
        }

        // =========================
        // ATTACHMENT NORMALIZER
        // =========================
        $attachments = $pastor->attachments;

        if (empty($attachments)) {
            $attachments = [];
        } elseif (is_string($attachments)) {
            $decoded = json_decode($attachments, true);

            if (is_string($decoded)) {
                $decoded = json_decode($decoded, true);
            }

            $attachments = is_array($decoded) ? $decoded : [];
        }

        $pastor->attachments = array_values(array_filter($attachments));

        return view('admin.national_pastoral_approvals.view', compact('pastor'));
    }

    // =========================
    // APPROVE (SECURED)
    // =========================
    public function approve($id)
    {
        // 🔐 ROLE CHECK (UPDATED CORRECTLY)
        if (!auth()->user()->hasRole(['super-admin', 'general-secretary'])) {
            abort(403, 'You are not authorized to approve pastoral transfers.');
        }

        $updated = DB::table('pastoral_teams')
            ->where('id', $id)
            ->where('status', 'pending')
            ->update([
                'status' => 'approved',
                'rejection_reason' => null,
                'updated_at' => now()
            ]);

        return back()->with(
            $updated ? 'success' : 'error',
            $updated ? 'Pastor approved successfully.' : 'Already processed or not found.'
        );
    }

    // =========================
    // REJECT (SECURED)
    // =========================
    public function reject(Request $request, $id)
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:1000'
        ]);

        // 🔐 ROLE CHECK (UPDATED CORRECTLY)
        if (!auth()->user()->hasRole(['super-admin', 'general-secretary'])) {
            abort(403, 'You are not authorized to reject pastoral transfers.');
        }

        $updated = DB::table('pastoral_teams')
            ->where('id', $id)
            ->where('status', 'pending')
            ->update([
                'status' => 'rejected',
                'rejection_reason' => $request->rejection_reason,
                'updated_at' => now()
            ]);

        return back()->with(
            $updated ? 'success' : 'error',
            $updated ? 'Pastor rejected successfully.' : 'Already processed or not found.'
        );
    }
}