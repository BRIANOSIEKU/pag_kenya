<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminController extends Controller
{
    /**
     * Allowed admin roles (Spatie ONLY)
     */
    private array $adminRoles = [
        'super_admin',
        'admin',
        'general_secretary',
        'general_treasurer',
        'general_superintendent',
    ];

    /**
     * LOGIN PAGE
     */
    public function showLogin()
    {
        if (Auth::check()) {
            $user = Auth::user();

            if ($user->hasAnyRole($this->adminRoles)) {
                return redirect()->route('admin.dashboard');
            }

            Auth::logout();
        }

        return view('admin.login');
    }

    /**
     * LOGIN PROCESS (FIXED FLOW)
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Attempt login
        if (!Auth::attempt($credentials)) {
            return back()->withErrors([
                'email' => 'The provided credentials do not match our records.',
            ]);
        }

        $request->session()->regenerate();

        $user = Auth::user();

        // IMPORTANT: Spatie role check ONLY
        if (!$user || !$user->hasAnyRole($this->adminRoles)) {
            Auth::logout();

            return redirect()->route('admin.login')
                ->withErrors([
                    'email' => 'You do not have administrative access.',
                ]);
        }

        return redirect()->route('admin.dashboard');
    }

    /**
     * DASHBOARD (ROLE PROTECTED)
     */
    public function dashboard()
    {
        $user = Auth::user();

        if (!$user || !$user->hasAnyRole($this->adminRoles)) {
            abort(403, 'Unauthorized access.');
        }

        return view('admin.dashboard');
    }

    /**
     * LOGOUT
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }

    /**
     * LIST ADMINS
     */
    public function listAdmins()
    {
        $admins = User::role($this->adminRoles)->get();

        return view('admin.admins.list', compact('admins'));
    }

    /**
     * CREATE ADMIN FORM
     */
    public function createAdmin()
    {
        return view('admin.admins.create');
    }

    /**
     * STORE ADMIN
     */
    public function storeAdmin(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'required|in:' . implode(',', $this->adminRoles),
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $user->assignRole($request->role);

        return redirect()->route('admin.admins.list')
            ->with('success', 'Admin user created successfully.');
    }

    /**
     * RESET PASSWORD (SUPER ADMIN ONLY)
     */
    public function showResetPasswordForm(User $admin)
    {
        if (!Auth::user()->hasRole('super_admin')) {
            abort(403);
        }

        return view('admin.admins.reset_password', compact('admin'));
    }

    public function updateAdminPassword(Request $request, User $admin)
    {
        if (!Auth::user()->hasRole('super_admin')) {
            abort(403);
        }

        $request->validate([
            'new_password' => 'required|string|min:6|confirmed',
        ]);

        $admin->update([
            'password' => Hash::make($request->new_password),
        ]);

        return redirect()->route('admin.admins.list')
            ->with('success', 'Password updated successfully.');
    }

    /**
     * RESET OWN PASSWORD
     */
    public function showResetMyPasswordForm()
    {
        return view('admin.admins.reset_my_password');
    }

    public function resetMyPassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|string|min:6|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors([
                'current_password' => 'Current password is incorrect.'
            ]);
        }

        $user->update([
            'password' => Hash::make($request->new_password),
        ]);

        return back()->with('success', 'Your password has been updated.');
    }
}