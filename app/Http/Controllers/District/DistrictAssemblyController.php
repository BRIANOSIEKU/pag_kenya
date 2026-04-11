<?php

namespace App\Http\Controllers\District;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Assembly;

class DistrictAssemblyController extends Controller
{
    /**
     * LIST ASSEMBLIES
     */
    public function index()
    {
        $districtId = session('district_admin_district_id');

        if (!$districtId) {
            return redirect()->route('district.admin.login')
                ->with('error', 'Session expired. Please login again.');
        }

        $assemblies = Assembly::where('district_id', $districtId)
            ->latest()
            ->get();

        return view('district_admin.assemblies.index', compact('assemblies'));
    }

    /**
     * SHOW CREATE FORM
     */
    public function create()
    {
        $districtId = session('district_admin_district_id');

        if (!$districtId) {
            return redirect()->route('district.admin.login')
                ->with('error', 'Session expired. Please login again.');
        }

        return view('district_admin.assemblies.create');
    }

    /**
     * STORE ASSEMBLY
     */
    public function store(Request $request)
    {
        $districtId = session('district_admin_district_id');

        if (!$districtId) {
            return redirect()->route('district.admin.login')
                ->with('error', 'Session expired. Please login again.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'physical_address' => 'required|string|max:255',
        ]);

        Assembly::create([
            'district_id' => $districtId,
            'name' => $request->name,
            'physical_address' => $request->physical_address,
            'status' => 'pending',
        ]);

        return redirect()
            ->route('district.admin.assemblies.index')
            ->with('success', 'Assembly created successfully and is pending approval.');
    }

    /**
     * DELETE ASSEMBLY
     */
    public function destroy($id)
    {
        $districtId = session('district_admin_district_id');

        if (!$districtId) {
            return redirect()->route('district.admin.login')
                ->with('error', 'Session expired. Please login again.');
        }

        $assembly = Assembly::where('district_id', $districtId)
            ->where('id', $id)
            ->first();

        if (!$assembly) {
            return redirect()
                ->route('district.admin.assemblies.index')
                ->with('error', 'Assembly not found or unauthorized.');
        }

        $assembly->delete();

        return redirect()
            ->route('district.admin.assemblies.index')
            ->with('success', 'Assembly deleted successfully.');
    }
}