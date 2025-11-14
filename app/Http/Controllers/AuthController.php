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
                'min:5', // Minimum 5 characters
                'confirmed',
                'regex:/[A-Z]/',   // Must contain at least one uppercase letter
                'regex:/[\W_]/',   // Must contain at least one special character
            ],
        ], [
            'password.min' => 'Password must be at least 5 characters long.',
            'password.regex' => 'Password must contain at least one uppercase letter and one special symbol.',
            'email.unique' => 'This email ID is already registered.',
            'password.confirmed' => 'Password confirmation does not match.',
        ]);

        // ✅ Create user and insert into DB
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // ✅ Login automatically
        Auth::login($user);

        return redirect()->route('dashboard')->with('success', 'Registration successful!');
    }

    // Handle login
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        // ✅ Check if the email exists
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors([
                'email' => 'This email is not registered. Please create an account first.'
            ])->withInput();
        }

        // ✅ Attempt login
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('dashboard');
        }

        // ✅ If password is wrong
        return back()->withErrors(['email' => 'Invalid credentials.'])->withInput();
    }

    // Handle logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}
