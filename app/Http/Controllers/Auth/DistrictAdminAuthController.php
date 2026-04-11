<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DistrictAdmin;
use Illuminate\Support\Facades\Hash;

class DistrictAdminAuthController extends Controller
{
    /**
     * SHOW LOGIN PAGE
     */
    public function showLoginForm()
    {
        if (session()->has('district_admin_id')) {
            return redirect()->route('district.admin.dashboard');
        }

        return view('auth.district_admin_login');
    }

    /**
     * PROCESS LOGIN
     */
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $admin = DistrictAdmin::where('username', $request->username)->first();

        if (!$admin || !Hash::check($request->password, $admin->password)) {
            return back()
                ->withInput($request->only('username'))
                ->with('error', 'Invalid username or password');
        }

        // CLEAR OLD SESSION
        session()->forget([
            'district_admin_id',
            'district_admin_district_id',
            'district_admin_username'
        ]);

        // SET NEW SESSION (CONSISTENT KEYS)
        session([
            'district_admin_id' => $admin->id,
            'district_admin_district_id' => $admin->district_id, // ✅ IMPORTANT FIX
            'district_admin_username' => $admin->username,
        ]);

        $request->session()->regenerate();

        return redirect()
            ->route('district.admin.dashboard')
            ->with('success', 'Welcome back, ' . $admin->username);
    }

    /**
     * LOGOUT
     */
    public function logout(Request $request)
    {
        session()->forget([
            'district_admin_id',
            'district_admin_district_id',
            'district_admin_username'
        ]);

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()
            ->route('district.admin.login')
            ->with('success', 'You have been logged out.');
    }
}