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
        'role' => 'required|in:admin,staff'
    ]);

    // Create User
    User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'role' => $request->role,
        'admin' => $request->role === 'admin' ? 1 : 0,
        'staff' => $request->role === 'staff' ? 1 : 0,
    ]);

    // Redirect to correct login URL with role
    return redirect('/login?role=' . $request->role)
        ->with('success', 'Account created successfully! Please login.');
}



    // Handle login
public function login(Request $request)
{
    $credentials = $request->only('email', 'password');

    $role = $request->role; // role coming from login form

    // Get user by email
    $user = User::where('email', $request->email)->first();
    if (!$user) {
        return back()->withErrors(['email' => 'This email is not registered.']);
    }

    // Attempt login
    if (!Auth::attempt($credentials)) {
        return back()->withErrors(['email' => 'Invalid credentials.']);
    }

    // SET ROLE & PERMISSIONS
    if ($role === 'admin') {
        $user->role = 'admin';
        $user->admin = 1;
        $user->staff = 0;

    } elseif ($role === 'staff') {
        $user->role = 'staff';
        $user->admin = 0;
        $user->staff = 1;

    } else {
        // user opened /login without selecting role
        return back()->withErrors(['email' => 'Please select Admin or Staff login.']);
    }

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
