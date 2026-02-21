<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AdminController extends Controller
{
    /**
     * Show the admin login page
     */
    public function showLogin()
    {
        // If already logged in and is admin, redirect to dashboard
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
        // Validate credentials
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Only allow admins
            if (in_array(Auth::user()->role, ['admin', 'super_admin'])) {
                return redirect()->route('admin.dashboard');
            } else {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'You do not have admin access.',
                ])->withInput();
            }
        }

        // Credentials failed
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
     * Logout admin and redirect to login page
     */
    public function logout(Request $request)
    {
        Auth::logout();                        // log out the user
        $request->session()->invalidate();      // invalidate session
        $request->session()->regenerateToken(); // regenerate CSRF token

        return redirect()->route('admin.login'); // go back to login page
    }
}