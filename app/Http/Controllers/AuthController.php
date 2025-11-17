<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    // Show login form
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Show register form
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    // Handle registration
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => [
                'required',
                'string',
                'min:5',
                'confirmed',
                'regex:/[A-Z]/',
                'regex:/[\W_]/',
            ],
        ]);

        // Create user (no auto login)
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Redirect to login page after registration
        return redirect()->route('login')->with('success', 'Account created successfully! Please login.');
    }

    // Handle login
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        // Check email exists
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return back()->withErrors([
                'email' => 'This email is not registered. Please create an account first.'
            ])->withInput();
        }

         // Check password
    if (!Auth::attempt($credentials)) {
        return back()->withErrors(['email' => 'Invalid credentials.']);
    }

    // SET ROLE BASED ON BUTTON PRESSED
    $user->role = $request->role;
    $user->save();

    return redirect()->route('dashboard');
    }

    // Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}
