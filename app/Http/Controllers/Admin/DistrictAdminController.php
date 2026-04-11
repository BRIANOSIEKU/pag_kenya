<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\District;
use App\Models\DistrictAdmin;
use App\Models\DistrictLeader;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\QueryException;

class DistrictAdminController extends Controller
{
    // ================= INDEX =================
    public function index(Request $request)
    {
        $query = DistrictAdmin::with('district');

        if ($request->search) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('username', 'like', "%{$search}%")
                  ->orWhereHas('district', function ($d) use ($search) {
                      $d->where('name', 'like', "%{$search}%");
                  });
            });
        }

        $admins = $query->latest()->paginate(10);

        return view('admin.district_admins.index', compact('admins'));
    }

    // ================= CREATE =================
    public function create()
    {
        $districts = District::select('id', 'name')
            ->orderBy('name')
            ->get();

        return view('admin.district_admins.create', compact('districts'));
    }

    // ================= GET SECRETARIES =================
    public function getSecretaries($districtId)
    {
        $leaders = DistrictLeader::where('district_id', $districtId)
            ->where('position', 'Secretary')
            ->select('id', 'name')
            ->orderBy('name')
            ->get();

        return response()->json($leaders);
    }

    // ================= STORE (DB-SAFE FINAL VERSION) =================
    public function store(Request $request)
    {
        $request->validate([
            'district_id' => 'required|exists:districts,id',
            'leader_id'   => 'required|exists:district_leaders,id',
            'password'    => 'required|min:6',
        ]);

        $district = District::findOrFail($request->district_id);

        $username = $this->generateUsername($district->name);

        try {
            DistrictAdmin::create([
                'district_id' => $district->id,
                'username'    => $username,
                'password'    => Hash::make($request->password),
            ]);

            return redirect()
                ->route('admin.district_admins.index')
                ->with('success', "District Admin created successfully. Username: $username");

        } catch (QueryException $e) {

            // 🔥 THIS HANDLES UNIQUE CONSTRAINT VIOLATION
            if ($e->getCode() == 23000) {
                return redirect()
                    ->route('admin.district_admins.create')
                    ->with('error', '⚠️ This district already has an admin assigned. Please select another district.');
            }

            throw $e;
        }
    }

    // ================= EDIT =================
    public function edit($id)
    {
        $admin = DistrictAdmin::findOrFail($id);

        $districts = District::select('id', 'name')->get();

        return view('admin.district_admins.edit', compact('admin', 'districts'));
    }

    // ================= UPDATE =================
    public function update(Request $request, $id)
    {
        $admin = DistrictAdmin::findOrFail($id);

        $request->validate([
            'district_id' => 'required|exists:districts,id',
        ]);

        try {
            $admin->update([
                'district_id' => $request->district_id,
            ]);

            return redirect()
                ->route('admin.district_admins.index')
                ->with('success', 'District Admin updated successfully');

        } catch (QueryException $e) {

            if ($e->getCode() == 23000) {
                return back()->with('error', '⚠️ Another admin already exists for this district.');
            }

            throw $e;
        }
    }

    // ================= DELETE =================
    public function destroy($id)
    {
        DistrictAdmin::findOrFail($id)->delete();

        return redirect()
            ->route('admin.district_admins.index')
            ->with('success', 'District Admin deleted successfully');
    }

    // ================= RESET PASSWORD =================
    public function resetPassword(Request $request, $id)
    {
        $request->validate([
            'password' => 'required|min:6',
        ]);

        $admin = DistrictAdmin::findOrFail($id);

        $admin->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()
            ->route('admin.district_admins.index')
            ->with('success', 'Password reset successful');
    }

    // ================= USERNAME GENERATOR =================
    private function generateUsername($districtName)
    {
        $prefix = 'PAG';

        $clean = strtoupper(substr(
            preg_replace('/[^A-Za-z]/', '', $districtName),
            0,
            2
        ));

        $lastId = DistrictAdmin::max('id') + 1;
        $number = str_pad($lastId, 3, '0', STR_PAD_LEFT);

        return $prefix . $clean . $number;
    }
}