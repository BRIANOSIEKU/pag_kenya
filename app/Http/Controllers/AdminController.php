<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminController extends Controller
{
    /**
     * Show the admin login page
     */
    public function showLogin()
    {
        if (Auth::check() && in_array(Auth::user()->role, ['admin', 'super_admin'])) {
            return redirect()->route('admin.dashboard');
        }

        return view('admin.login'); // your login Blade
    }

    /**
     * Handle admin login form submission
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            if (in_array(Auth::user()->role, ['admin', 'super_admin'])) {
                return redirect()->route('admin.dashboard');
            } else {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'You do not have admin access.',
                ])->withInput();
            }
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->withInput();
    }

    /**
     * Admin dashboard
     */
    public function dashboard()
    {
        return view('admin.dashboard'); // your dashboard Blade
    }

    /**
     * Logout admin
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }

    //===================== SUPER ADMIN FUNCTIONALITY ======================//

    /**
     * List all admins
     */
    public function listAdmins()
    {
        $admins = User::whereIn('role', ['admin', 'super_admin'])->get();
        return view('admin.admins.list', compact('admins'));
    }

    /**
     * Show form to create new admin
     */
    public function createAdmin()
    {
        return view('admin.admins.create'); // Blade form
    }

    /**
     * Store new admin
     */
    public function storeAdmin(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'nullable|in:admin,super_admin' // optional, default to admin
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role ?? 'admin'
        ]);

        return redirect()->route('admin.admins.list')->with('success', 'Admin added successfully.');
    }

    /**
     * Show form to reset a regular admin's password (super admin only)
     */
    public function showResetPasswordForm(User $admin)
    {
        $currentUser = auth()->user();

        if ($currentUser->role !== 'super_admin') {
            abort(403, 'Unauthorized action.');
        }

        if ($admin->role !== 'admin') {
            abort(403, 'You can only reset password for regular admins.');
        }

        return view('admin.admins.reset_password', compact('admin'));
    }

    /**
     * Update regular admin's password (super admin only)
     */
    public function updateAdminPassword(Request $request, User $admin)
    {
        $currentUser = auth()->user();

        if ($currentUser->role !== 'super_admin') {
            abort(403, 'Unauthorized action.');
        }

        if ($admin->role !== 'admin') {
            abort(403, 'You can only reset password for regular admins.');
        }

        $request->validate([
            'new_password' => 'required|string|min:6|confirmed',
        ]);

        $admin->password = Hash::make($request->new_password);
        $admin->save();

        return redirect()->route('admin.admins.list')->with('success', "Password for {$admin->name} has been updated successfully.");
    }

    /**
     * Show form to reset super admin's own password
     */
    public function showResetMyPasswordForm()
    {
        return view('admin.admins.reset_my_password'); // Blade form
    }

    /**
     * Handle updating super admin's own password
     */
    public function resetMyPassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|string|min:6|confirmed',
        ]);

        $user = auth()->user();

        // Check current password
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return back()->with('success', 'Your password has been updated successfully.');
    }
}