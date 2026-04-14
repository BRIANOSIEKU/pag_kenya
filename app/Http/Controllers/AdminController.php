<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminController extends Controller
{
    // ======================
    // ALLOWED ROLES (CENTRALIZED FIX)
    // ======================
    private array $adminRoles = [
        'admin',
        'super-admin',
        'general-secretary',
        'general-treasurer',
        'general-superintendent',
    ];

    // ======================
    // LOGIN PAGE
    // ======================
    public function showLogin()
    {
        if (Auth::check()) {

            if (Auth::user()->hasAnyRole($this->adminRoles)) {
                return redirect()->route('admin.dashboard');
            }

            Auth::logout();
        }

        return view('admin.login');
    }

    // ======================
    // LOGIN PROCESS
    // ======================
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {

            $request->session()->regenerate();

            $user = Auth::user();

            // ✅ STRICT ROLE CHECK
            if ($user && $user->hasAnyRole($this->adminRoles)) {
                return redirect()->route('admin.dashboard');
            }

            Auth::logout();

            return back()->withErrors([
                'email' => 'You do not have admin access.',
            ]);
        }

        return back()->withErrors([
            'email' => 'Invalid credentials.',
        ]);
    }

    // ======================
    // DASHBOARD
    // ======================
    public function dashboard()
    {
        if (!Auth::check() || !Auth::user()->hasAnyRole($this->adminRoles)) {
            abort(403);
        }

        return view('admin.dashboard');
    }

    // ======================
    // LOGOUT
    // ======================
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }

    // ======================
    // LIST ADMINS
    // ======================
    public function listAdmins()
    {
        $admins = User::role($this->adminRoles)->get();

        return view('admin.admins.list', compact('admins'));
    }

    // ======================
    // CREATE FORM
    // ======================
    public function createAdmin()
    {
        return view('admin.admins.create');
    }

    // ======================
    // STORE ADMIN
    // ======================
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

        // ✅ CLEAN ROLE ASSIGNMENT
        $user->syncRoles([$request->role]);

        return redirect()->route('admin.admins.list')
            ->with('success', 'User created successfully.');
    }

    // ======================
    // RESET PASSWORD (ADMIN)
    // ======================
    public function showResetPasswordForm(User $admin)
    {
        if (!Auth::user()->hasRole('super-admin')) {
            abort(403);
        }

        return view('admin.admins.reset_password', compact('admin'));
    }

    public function updateAdminPassword(Request $request, User $admin)
    {
        if (!Auth::user()->hasRole('super-admin')) {
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

    // ======================
    // RESET OWN PASSWORD
    // ======================
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
                'current_password' => 'Incorrect password'
            ]);
        }

        $user->update([
            'password' => Hash::make($request->new_password),
        ]);

        return back()->with('success', 'Password updated successfully.');
    }
}