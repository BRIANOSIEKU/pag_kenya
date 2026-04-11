<?php

namespace App\Http\Controllers\DistrictAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use App\Models\District;

class DashboardController extends Controller
{
    public function index()
    {
        // 🔐 CHECK LOGIN SESSION
        if (!Session::has('district_admin_id')) {
            return redirect()->route('district.admin.login')
                ->with('error', 'Please login first');
        }

        // GET DISTRICT ID FROM SESSION (CORRECT KEY)
        $districtId = Session::get('district_admin_district_id');

        // FETCH DISTRICT
        $district = District::find($districtId);

        return view('district_admin.dashboard', compact('district'));
    }
}